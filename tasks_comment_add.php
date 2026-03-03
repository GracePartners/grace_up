<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Security::verifyCsrf($_POST['csrf'] ?? null);

$pdo = DB::pdo();
$taskId = (int)($_POST['task_id'] ?? 0);
$body = trim((string)($_POST['body'] ?? ''));
$userId = (int)Auth::user()['id'];

if ($taskId && $body !== '') {
  $pdo->prepare("INSERT INTO task_comments (task_id,user_id,body) VALUES (?,?,?)")->execute([$taskId,$userId,$body]);
}
header('Location: /tasks_view.php?id=' . $taskId);
