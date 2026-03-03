<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$userId = (int)Auth::user()['id'];

$kpi_overdue = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE due_date IS NOT NULL AND due_date < CURDATE() AND status <> 'Done'")->fetchColumn();
$kpi_due7 = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE due_date IS NOT NULL AND due_date >= CURDATE() AND due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND status <> 'Done'")->fetchColumn();
$st = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE owner_id=? AND status <> 'Done'");
$st->execute([$userId]);
$kpi_mine = (int)$st->fetchColumn();

$overdue = $pdo->query("SELECT t.id,t.title,t.status,p.name AS project_name,c.name AS client_name
  FROM tasks t
  JOIN projects p ON p.id=t.project_id
  JOIN clients c ON c.id=p.client_id
  WHERE t.due_date IS NOT NULL AND t.due_date < CURDATE() AND t.status <> 'Done'
  ORDER BY t.due_date ASC
  LIMIT 8")->fetchAll();

$due7 = $pdo->query("SELECT t.id,t.title,t.status,t.due_date,p.name AS project_name,c.name AS client_name
  FROM tasks t
  JOIN projects p ON p.id=t.project_id
  JOIN clients c ON c.id=p.client_id
  WHERE t.due_date IS NOT NULL AND t.due_date >= CURDATE() AND t.due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND t.status <> 'Done'
  ORDER BY t.due_date ASC
  LIMIT 10")->fetchAll();

View::render('dashboard', compact('kpi_overdue','kpi_due7','kpi_mine','overdue','due7'));
