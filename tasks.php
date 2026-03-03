<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$q = trim((string)($_GET['q'] ?? ''));
$status = trim((string)($_GET['status'] ?? ''));
$assignee = (int)($_GET['assignee'] ?? 0);
$view = trim((string)($_GET['view'] ?? 'list'));
$client_id = (int)($_GET['client_id'] ?? 0);
$project_id = (int)($_GET['project_id'] ?? 0);
$filter = trim((string)($_GET['filter'] ?? ''));

$statuses = ['Backlog','In progress','Review','Done'];
$users = $pdo->query("SELECT id,name FROM users ORDER BY name ASC")->fetchAll();

$sql = "SELECT t.*, p.name AS project_name, c.name AS client_name, u.name AS owner_name
        FROM tasks t
        JOIN projects p ON p.id=t.project_id
        JOIN clients c ON c.id=p.client_id
        LEFT JOIN users u ON u.id=t.owner_id
        WHERE 1=1";
$params = [];

if ($q !== '') { $sql .= " AND t.title LIKE ?"; $params[] = '%'.$q.'%'; }
if ($status !== '') { $sql .= " AND t.status = ?"; $params[] = $status; }
if ($assignee) { $sql .= " AND t.owner_id = ?"; $params[] = $assignee; }
if ($client_id) { $sql .= " AND c.id = ?"; $params[] = $client_id; }
if ($project_id) { $sql .= " AND p.id = ?"; $params[] = $project_id; }

if ($filter === 'overdue') { $sql .= " AND t.due_date IS NOT NULL AND t.due_date < CURDATE() AND t.status <> 'Done'"; }
if ($filter === 'due7') { $sql .= " AND t.due_date IS NOT NULL AND t.due_date >= CURDATE() AND t.due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND t.status <> 'Done'"; }

$sql .= " ORDER BY COALESCE(t.due_date,'9999-12-31') ASC, t.created_at DESC";
$st = $pdo->prepare($sql);
$st->execute($params);
$tasks = $st->fetchAll();

$byStatus = [];
foreach ($tasks as $t) $byStatus[$t['status']][] = $t;

View::render('tasks', compact('tasks','q','status','assignee','view','client_id','project_id','filter','statuses','users','byStatus'));
