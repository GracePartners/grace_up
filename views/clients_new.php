<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Nuovo cliente</h1><div class="muted">Crea un hub</div></div>
    <a class="btn btn--ghost" href="/clients.php">Indietro</a>
  </div>
  <?php if (!empty($error)): ?><div class="alert alert--danger"><?= Security::e($error) ?></div><?php endif; ?>
  <div class="card">
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <div class="grid grid--2">
        <div><label>Nome *</label><input name="name" required></div>
        <div><label>Settore</label><input name="industry"></div>
        <div><label>Email</label><input name="email" type="email"></div>
        <div><label>Telefono</label><input name="phone"></div>
        <div><label>Città</label><input name="city"></div>
        <div><label>Sito</label><input name="website" placeholder="https://"></div>
      </div>
      <label>Note interne</label>
      <textarea name="notes" rows="4"></textarea>
      <button class="btn" type="submit">Crea</button>
    </form>
  </div>
</div>
