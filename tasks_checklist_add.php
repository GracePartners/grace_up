<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Security::verifyCsrf($_POST['csrf'] ?? null);

$pdo = DB::pdo();
$taskId = (int)($_POST['task_id'] ?? 0);
$text = trim((string)($_POST['text'] ?? ''));

if ($taskId && $text !== '') {
  $pdo->prepare("INSERT INTO task_checklist_items (task_id,text,is_done) VALUES (?,?,0)")->execute([$taskId,$text]);
}
header('Location: /tasks_view.php?id=' . $taskId);
