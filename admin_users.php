<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Auth::requireRole(['admin']);

$pdo = DB::pdo();
$users = $pdo->query("SELECT id,name,email,role,created_at FROM users ORDER BY created_at DESC")->fetchAll();
View::render('admin_users', compact('users'));
