<?php
require __DIR__ . '/core/bootstrap.php';
Auth::requireLogin();
Auth::requireRole(['admin']);

$pdo = DB::pdo();
$error = null;
$roles = ['admin','pm','team'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::verifyCsrf($_POST['csrf'] ?? null);

  $name = trim((string)($_POST['name'] ?? ''));
  $email = trim((string)($_POST['email'] ?? ''));
  $role = trim((string)($_POST['role'] ?? 'team'));
  $pass = (string)($_POST['password'] ?? '');

  if ($name==='' || $email==='' || $pass==='') $error = "Nome, email e password sono obbligatori.";
  if (!in_array($role, $roles, true)) $error = "Ruolo non valido.";

  if (!$error) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    try {
      $pdo->prepare("INSERT INTO users (name,email,role,password) VALUES (?,?,?,?)")->execute([$name,$email,$role,$hash]);
      header('Location: /admin_users.php');
      exit;
    } catch (Throwable $e) {
      $error = "Email già usata o errore DB.";
    }
  }
}
View::render('admin_users_new', compact('error','roles'));
