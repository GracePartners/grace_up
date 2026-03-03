<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Progetti</h1><div class="muted">Pipeline</div></div>
    <a class="btn" href="/projects_new.php<?= $client_id ? '?client_id='.(int)$client_id : '' ?>">+ Nuovo</a>
  </div>

  <div class="card">
    <form class="form form--inline" method="get">
      <input name="q" placeholder="Cerca progetto..." value="<?= Security::e($q) ?>">
      <select name="status">
        <option value="">Tutti gli stati</option>
        <?php foreach ($statuses as $s): ?><option value="<?= Security::e($s) ?>" <?= $status===$s?'selected':'' ?>><?= Security::e($s) ?></option><?php endforeach; ?>
      </select>
      <?php if ($client_id): ?><input type="hidden" name="client_id" value="<?= (int)$client_id ?>"><?php endif; ?>
      <button class="btn btn--soft" type="submit">Filtra</button>
      <a class="btn btn--ghost" href="/projects.php">Reset</a>
    </form>
  </div>

  <div class="grid grid--3">
    <?php foreach ($projects as $p): ?>
      <a class="card card--hover" href="/projects_view.php?id=<?= (int)$p['id'] ?>">
        <div class="card__title"><?= Security::e($p['name']) ?></div>
        <div class="muted"><?= Security::e($p['client_name'] ?? '') ?></div>
        <div class="chiprow">
          <div class="chip"><?= Security::e($p['type'] ?? '') ?></div>
          <div class="chip"><?= Security::e($p['status']) ?></div>
          <div class="chip">Due: <?= Security::e($p['due_date'] ?? '-') ?></div>
        </div>
      </a>
    <?php endforeach; ?>
    <?php if (empty($projects)): ?><div class="empty">Nessun progetto.</div><?php endif; ?>
  </div>
</div>
