<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::verifyCsrf($_POST['csrf'] ?? null);

  $name = trim((string)($_POST['name'] ?? ''));
  if ($name === '') $error = "Il nome cliente è obbligatorio.";

  if (!$error) {
    $pdo = DB::pdo();
    $st = $pdo->prepare("INSERT INTO clients (name,industry,email,phone,city,website,notes) VALUES (?,?,?,?,?,?,?)");
    $st->execute([
      $name,
      trim((string)($_POST['industry'] ?? '')),
      trim((string)($_POST['email'] ?? '')),
      trim((string)($_POST['phone'] ?? '')),
      trim((string)($_POST['city'] ?? '')),
      trim((string)($_POST['website'] ?? '')),
      trim((string)($_POST['notes'] ?? '')),
    ]);
    header('Location: /clients.php');
    exit;
  }
}
View::render('clients_new', compact('error'));
