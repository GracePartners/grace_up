<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$error = null;

$client_id = (int)($_GET['client_id'] ?? ($_POST['client_id'] ?? 0));
$project_id = (int)($_GET['project_id'] ?? ($_POST['project_id'] ?? 0));

$clients = $pdo->query("SELECT id,name FROM clients ORDER BY name ASC")->fetchAll();
$users = $pdo->query("SELECT id,name,role FROM users ORDER BY name ASC")->fetchAll();

$statuses = ['Backlog','In progress','Review','Done'];
$priorities = ['Low','Medium','High','Urgent'];

if ($client_id) {
  $st = $pdo->prepare("SELECT id,name FROM projects WHERE client_id=? ORDER BY created_at DESC");
  $st->execute([$client_id]);
  $projects = $st->fetchAll();
} else {
  $projects = $pdo->query("SELECT id,name FROM projects ORDER BY created_at DESC")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::verifyCsrf($_POST['csrf'] ?? null);

  $project_id = (int)($_POST['project_id'] ?? 0);
  $title = trim((string)($_POST['title'] ?? ''));
  if (!$project_id || $title === '') $error = "Progetto e titolo sono obbligatori.";

  if (!$error) {
    $st = $pdo->prepare("INSERT INTO tasks (project_id,title,description,status,priority,owner_id,due_date,estimate_hours) VALUES (?,?,?,?,?,?,?,?)");
    $st->execute([
      $project_id,
      $title,
      trim((string)($_POST['description'] ?? '')),
      trim((string)($_POST['status'] ?? 'Backlog')),
      trim((string)($_POST['priority'] ?? 'Medium')),
      ($_POST['owner_id'] ?? null) ?: null,
      ($_POST['due_date'] ?? null) ?: null,
      ($_POST['estimate_hours'] ?? null) ?: null,
    ]);
    $taskId = (int)$pdo->lastInsertId();

    $raw = trim((string)($_POST['checklist'] ?? ''));
    if ($raw !== '') {
      $lines = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $raw))));
      if ($lines) {
        $ins = $pdo->prepare("INSERT INTO task_checklist_items (task_id,text,is_done) VALUES (?,?,0)");
        foreach ($lines as $line) $ins->execute([$taskId, $line]);
      }
    }

    header('Location: /tasks_view.php?id=' . $taskId);
    exit;
  }
}

View::render('tasks_new', compact('error','clients','projects','users','statuses','priorities','client_id','project_id'));
