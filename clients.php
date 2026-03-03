<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$q = trim((string)($_GET['q'] ?? ''));

if ($q !== '') {
  $st = $pdo->prepare("SELECT * FROM clients WHERE name LIKE ? ORDER BY name ASC");
  $st->execute(['%'.$q.'%']);
  $clients = $st->fetchAll();
} else {
  $clients = $pdo->query("SELECT * FROM clients ORDER BY name ASC")->fetchAll();
}

View::render('clients', compact('clients','q'));
