<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Security::verifyCsrf($_POST['csrf'] ?? null);

$pdo = DB::pdo();
$id = (int)($_POST['id'] ?? 0);

$pdo->prepare("UPDATE task_checklist_items SET is_done = IF(is_done=1,0,1) WHERE id=?")->execute([$id]);

$st = $pdo->prepare("SELECT task_id FROM task_checklist_items WHERE id=?");
$st->execute([$id]);
$taskId = (int)$st->fetchColumn();

header('Location: /tasks_view.php?id=' . $taskId);
