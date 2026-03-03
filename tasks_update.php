<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Security::verifyCsrf($_POST['csrf'] ?? null);

$pdo = DB::pdo();
$id = (int)($_POST['id'] ?? 0);

$owner = ($_POST['owner_id'] ?? '') !== '' ? (int)$_POST['owner_id'] : null;
$st = $pdo->prepare("UPDATE tasks SET status=?, owner_id=? WHERE id=?");
$st->execute([trim((string)($_POST['status'] ?? 'Backlog')), $owner, $id]);

header('Location: /tasks_view.php?id=' . $id);
