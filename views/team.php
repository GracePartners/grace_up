<div class="container">
  <div class="hstack"><h1>Team</h1><div class="muted">Carico</div></div>
  <div class="grid grid--3">
    <?php foreach ($workload as $w): ?>
      <div class="card">
        <div class="card__title"><?= Security::e($w['name']) ?></div>
        <div class="muted"><?= Security::e($w['role']) ?></div>
        <div class="divider"></div>
        <div class="kv">
          <div class="kv__row"><div class="kv__k">Task aperte</div><div class="kv__v"><?= (int)$w['open_tasks'] ?></div></div>
          <div class="kv__row"><div class="kv__k">Ore stimate</div><div class="kv__v"><?= Security::e($w['est_hours']) ?></div></div>
          <div class="kv__row"><div class="kv__k">Scadenze 7gg</div><div class="kv__v"><?= (int)$w['due7'] ?></div></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
