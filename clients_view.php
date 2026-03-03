<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$id = (int)($_GET['id'] ?? 0);

$st = $pdo->prepare("SELECT * FROM clients WHERE id=?");
$st->execute([$id]);
$client = $st->fetch();
if (!$client) { http_response_code(404); exit('Cliente non trovato'); }

$st = $pdo->prepare("SELECT * FROM projects WHERE client_id=? ORDER BY created_at DESC LIMIT 8");
$st->execute([$id]);
$projects = $st->fetchAll();

$st = $pdo->prepare("SELECT t.id,t.title,t.status,t.due_date,p.name AS project_name,u.name AS owner_name
  FROM tasks t
  JOIN projects p ON p.id=t.project_id
  LEFT JOIN users u ON u.id=t.owner_id
  WHERE p.client_id=?
  ORDER BY t.created_at DESC
  LIMIT 10");
$st->execute([$id]);
$tasks = $st->fetchAll();

View::render('clients_view', compact('client','projects','tasks'));
