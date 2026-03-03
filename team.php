<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();

$pdo = DB::pdo();
$users = $pdo->query("SELECT id,name,role FROM users ORDER BY name ASC")->fetchAll();

$workload = [];
foreach ($users as $u) {
  $uid = (int)$u['id'];
  $st = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE owner_id=? AND status <> 'Done'");
  $st->execute([$uid]);
  $open = (int)$st->fetchColumn();

  $st = $pdo->prepare("SELECT COALESCE(SUM(estimate_hours),0) FROM tasks WHERE owner_id=? AND status <> 'Done'");
  $st->execute([$uid]);
  $est = $st->fetchColumn();

  $st = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE owner_id=? AND status <> 'Done' AND due_date IS NOT NULL AND due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
  $st->execute([$uid]);
  $due7 = (int)$st->fetchColumn();

  $workload[] = ['name'=>$u['name'],'role'=>$u['role'],'open_tasks'=>$open,'est_hours'=>$est,'due7'=>$due7];
}

View::render('team', compact('workload'));
