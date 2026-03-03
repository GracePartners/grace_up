<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$q = trim((string)($_GET['q'] ?? ''));
$status = trim((string)($_GET['status'] ?? ''));
$client_id = (int)($_GET['client_id'] ?? 0);

$statuses = ['Backlog','In progress','Review','Done'];

$sql = "SELECT p.*, c.name AS client_name, u.name AS owner_name
        FROM projects p
        JOIN clients c ON c.id=p.client_id
        LEFT JOIN users u ON u.id=p.owner_id
        WHERE 1=1";
$params = [];

if ($q !== '') { $sql .= " AND p.name LIKE ?"; $params[] = '%'.$q.'%'; }
if ($status !== '') { $sql .= " AND p.status = ?"; $params[] = $status; }
if ($client_id) { $sql .= " AND p.client_id = ?"; $params[] = $client_id; }

$sql .= " ORDER BY p.created_at DESC";
$st = $pdo->prepare($sql);
$st->execute($params);
$projects = $st->fetchAll();

View::render('projects', compact('projects','q','status','client_id','statuses'));
