<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Clienti</h1><div class="muted">Hub cliente</div></div>
    <a class="btn" href="/clients_new.php">+ Nuovo cliente</a>
  </div>

  <div class="card">
    <form class="form form--inline" method="get">
      <input name="q" placeholder="Cerca cliente..." value="<?= Security::e($q) ?>">
      <button class="btn btn--soft" type="submit">Cerca</button>
      <a class="btn btn--ghost" href="/clients.php">Reset</a>
    </form>
  </div>

  <div class="grid grid--3">
    <?php foreach ($clients as $c): ?>
      <a class="card card--hover" href="/clients_view.php?id=<?= (int)$c['id'] ?>">
        <div class="card__title"><?= Security::e($c['name']) ?></div>
        <div class="muted"><?= Security::e($c['industry'] ?? '') ?></div>
        <div class="chiprow">
          <div class="chip"><?= Security::e($c['city'] ?? '') ?></div>
          <div class="chip"><?= Security::e($c['email'] ?? '') ?></div>
        </div>
      </a>
    <?php endforeach; ?>
    <?php if (empty($clients)): ?><div class="empty">Nessun cliente.</div><?php endif; ?>
  </div>
</div>
