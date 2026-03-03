<div class="container">
  <div class="hstack">
    <h1>Oggi</h1>
    <div class="muted">Panoramica rapida</div>
  </div>

  <div class="grid grid--3">
    <div class="card"><div class="kpi__label">Task scadute</div><div class="kpi__value"><?= (int)$kpi_overdue ?></div></div>
    <div class="card"><div class="kpi__label">In scadenza (7 giorni)</div><div class="kpi__value"><?= (int)$kpi_due7 ?></div></div>
    <div class="card"><div class="kpi__label">A me assegnate (aperte)</div><div class="kpi__value"><?= (int)$kpi_mine ?></div></div>
  </div>

  <div class="grid grid--2">
    <div class="card">
      <div class="card__head"><h2>Scadute</h2><a class="link" href="/tasks.php?filter=overdue">Vedi</a></div>
      <div class="list">
        <?php foreach ($overdue as $t): ?>
          <a class="list__item" href="/tasks_view.php?id=<?= (int)$t['id'] ?>">
            <div class="pill pill--danger">Scaduta</div>
            <div class="list__title"><?= Security::e($t['title']) ?></div>
            <div class="list__meta"><?= Security::e($t['client_name'] ?? '') ?> · <?= Security::e($t['project_name'] ?? '') ?></div>
          </a>
        <?php endforeach; ?>
        <?php if (empty($overdue)): ?><div class="empty">Niente di critico 🎉</div><?php endif; ?>
      </div>
    </div>

    <div class="card">
      <div class="card__head"><h2>Prossime scadenze</h2><a class="link" href="/tasks.php?filter=due7">Vedi</a></div>
      <div class="list">
        <?php foreach ($due7 as $t): ?>
          <a class="list__item" href="/tasks_view.php?id=<?= (int)$t['id'] ?>">
            <div class="pill"><?= Security::e($t['status']) ?></div>
            <div class="list__title"><?= Security::e($t['title']) ?></div>
            <div class="list__meta">Scade: <?= Security::e($t['due_date']) ?> · <?= Security::e($t['client_name'] ?? '') ?></div>
          </a>
        <?php endforeach; ?>
        <?php if (empty($due7)): ?><div class="empty">Nessuna scadenza.</div><?php endif; ?>
      </div>
    </div>
  </div>
</div>
