<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$id = (int)($_GET['id'] ?? 0);

$st = $pdo->prepare("SELECT t.*, p.name AS project_name, c.name AS client_name, u.name AS owner_name
  FROM tasks t
  JOIN projects p ON p.id=t.project_id
  JOIN clients c ON c.id=p.client_id
  LEFT JOIN users u ON u.id=t.owner_id
  WHERE t.id=?");
$st->execute([$id]);
$task = $st->fetch();
if (!$task) { http_response_code(404); exit('Task non trovata'); }

$statuses = ['Backlog','In progress','Review','Done'];
$users = $pdo->query("SELECT id,name FROM users ORDER BY name ASC")->fetchAll();

$st = $pdo->prepare("SELECT * FROM task_checklist_items WHERE task_id=? ORDER BY id ASC");
$st->execute([$id]);
$checklist = $st->fetchAll();

$st = $pdo->prepare("SELECT tc.*, u.name AS user_name
  FROM task_comments tc
  JOIN users u ON u.id=tc.user_id
  WHERE tc.task_id=?
  ORDER BY tc.id DESC");
$st->execute([$id]);
$comments = $st->fetchAll();

View::render('tasks_view', compact('task','statuses','users','checklist','comments'));
