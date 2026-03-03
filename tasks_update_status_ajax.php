<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Security::verifyCsrf($_POST['csrf'] ?? null);

$pdo = DB::pdo();
$id = (int)($_POST['id'] ?? 0);
$status = trim((string)($_POST['status'] ?? ''));

$allowed = ['Backlog','In progress','Review','Done'];
if (!in_array($status, $allowed, true)) { http_response_code(422); header('Content-Type: application/json'); echo json_encode(['ok'=>false]); exit; }

$pdo->prepare("UPDATE tasks SET status=? WHERE id=?")->execute([$status, $id]);

header('Content-Type: application/json');
echo json_encode(['ok'=>true]);
