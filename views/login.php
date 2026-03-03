<div class="auth">
  <div class="card auth__card">
    <h1>Accedi</h1>
    <?php if (!empty($error)): ?><div class="alert alert--danger"><?= Security::e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button class="btn" type="submit">Entra</button>
    </form>
    <p class="muted">Prima installazione: crea l'admin come da INSTALLAZIONE.txt.</p>
  </div>
</div>
