<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$id = (int)($_GET['id'] ?? 0);

$st = $pdo->prepare("SELECT p.*, c.name AS client_name, u.name AS owner_name
  FROM projects p
  JOIN clients c ON c.id=p.client_id
  LEFT JOIN users u ON u.id=p.owner_id
  WHERE p.id=?");
$st->execute([$id]);
$project = $st->fetch();
if (!$project) { http_response_code(404); exit('Progetto non trovato'); }

$st = $pdo->prepare("SELECT t.*, u.name AS owner_name FROM tasks t LEFT JOIN users u ON u.id=t.owner_id WHERE t.project_id=? ORDER BY t.created_at DESC LIMIT 12");
$st->execute([$id]);
$tasks = $st->fetchAll();

View::render('projects_view', compact('project','tasks'));
