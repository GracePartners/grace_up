<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Nuovo utente</h1><div class="muted">Admin / PM / Team</div></div>
    <a class="btn btn--ghost" href="/admin_users.php">Indietro</a>
  </div>
  <?php if (!empty($error)): ?><div class="alert alert--danger"><?= Security::e($error) ?></div><?php endif; ?>
  <div class="card">
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <div class="grid grid--2">
        <div><label>Nome *</label><input name="name" required></div>
        <div><label>Email *</label><input type="email" name="email" required></div>
        <div><label>Ruolo</label><select name="role"><?php foreach ($roles as $r): ?><option value="<?= Security::e($r) ?>"><?= Security::e($r) ?></option><?php endforeach; ?></select></div>
        <div><label>Password *</label><input type="password" name="password" required></div>
      </div>
      <button class="btn" type="submit">Crea</button>
    </form>
  </div>
</div>
