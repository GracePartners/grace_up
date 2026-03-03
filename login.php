<?php
require __DIR__ . '/core/bootstrap.php';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::verifyCsrf($_POST['csrf'] ?? null);
  $email = trim((string)($_POST['email'] ?? ''));
  $pass  = (string)($_POST['password'] ?? '');

  $pdo = DB::pdo();
  $st = $pdo->prepare("SELECT id,name,email,role,password FROM users WHERE email=? LIMIT 1");
  $st->execute([$email]);
  $u = $st->fetch();

  if ($u && password_verify($pass, $u['password'])) {
    session_regenerate_id(true);
    unset($u['password']);
    $_SESSION['user'] = $u;
    header('Location: /dashboard.php');
    exit;
  }
  $error = "Credenziali non valide.";
}

View::render('login', compact('error'));
