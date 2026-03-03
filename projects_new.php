<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$error = null;

$client_id = (int)($_GET['client_id'] ?? ($_POST['client_id'] ?? 0));
$clients = $pdo->query("SELECT id,name FROM clients ORDER BY name ASC")->fetchAll();
$users = $pdo->query("SELECT id,name,role FROM users ORDER BY name ASC")->fetchAll();

$types = ['ADV','WEB','SOCIAL','CONTENT','DESIGN','ADMIN'];
$statuses = ['Backlog','In progress','Review','Done'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::verifyCsrf($_POST['csrf'] ?? null);

  $name = trim((string)($_POST['name'] ?? ''));
  $client_id = (int)($_POST['client_id'] ?? 0);
  if (!$client_id || $name === '') $error = "Cliente e nome progetto sono obbligatori.";

  if (!$error) {
    $st = $pdo->prepare("INSERT INTO projects (client_id,name,type,status,due_date,owner_id,description) VALUES (?,?,?,?,?,?,?)");
    $st->execute([
      $client_id,
      $name,
      trim((string)($_POST['type'] ?? '')),
      trim((string)($_POST['status'] ?? 'Backlog')),
      ($_POST['due_date'] ?? null) ?: null,
      ($_POST['owner_id'] ?? null) ?: null,
      trim((string)($_POST['description'] ?? '')),
    ]);
    $projectId = (int)$pdo->lastInsertId();

    $template = trim((string)($_POST['template'] ?? ''));
    $tpl = [];
    if ($template === 'adv') $tpl = ['Raccolta materiali','Setup campagne','Creatività (copy + visual)','Tracking & Pixel','Report finale'];
    if ($template === 'web') $tpl = ['Wireframe','Sviluppo','Revisione interna','Revisione cliente','Deploy'];
    if ($template === 'social') $tpl = ['Piano editoriale','Copy','Grafica','Programmazione','Report performance'];

    if ($tpl) {
      $ins = $pdo->prepare("INSERT INTO tasks (project_id,title,status,priority,owner_id) VALUES (?,?,?,?,?)");
      foreach ($tpl as $t) $ins->execute([$projectId, $t, 'Backlog', 'Medium', null]);
    }

    header('Location: /projects_view.php?id=' . $projectId);
    exit;
  }
}

View::render('projects_new', compact('error','clients','users','types','statuses','client_id'));
