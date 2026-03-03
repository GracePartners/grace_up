<div class="container">
  <div class="hstack hstack--between">
    <div><h1><?= Security::e($client['name']) ?></h1><div class="muted"><?= Security::e($client['industry'] ?? '') ?></div></div>
    <div class="hstack">
      <a class="btn btn--soft" href="/projects_new.php?client_id=<?= (int)$client['id'] ?>">+ Nuovo progetto</a>
      <a class="btn btn--ghost" href="/clients.php">Indietro</a>
    </div>
  </div>

  <div class="grid grid--2">
    <div class="card">
      <div class="card__head"><h2>Dati</h2></div>
      <div class="kv">
        <div class="kv__row"><div class="kv__k">Email</div><div class="kv__v"><?= Security::e($client['email'] ?? '-') ?></div></div>
        <div class="kv__row"><div class="kv__k">Telefono</div><div class="kv__v"><?= Security::e($client['phone'] ?? '-') ?></div></div>
        <div class="kv__row"><div class="kv__k">Sito</div><div class="kv__v"><?= Security::e($client['website'] ?? '-') ?></div></div>
      </div>
      <div class="divider"></div>
      <div class="muted">Note interne</div>
      <div><?= nl2br(Security::e($client['notes'] ?? '')) ?></div>
    </div>

    <div class="card">
      <div class="card__head"><h2>Progetti</h2><a class="link" href="/projects.php?client_id=<?= (int)$client['id'] ?>">Vedi</a></div>
      <div class="list">
        <?php foreach ($projects as $p): ?>
          <a class="list__item" href="/projects_view.php?id=<?= (int)$p['id'] ?>">
            <div class="pill"><?= Security::e($p['status']) ?></div>
            <div class="list__title"><?= Security::e($p['name']) ?></div>
            <div class="list__meta">Due: <?= Security::e($p['due_date'] ?? '-') ?></div>
          </a>
        <?php endforeach; ?>
        <?php if (empty($projects)): ?><div class="empty">Nessun progetto.</div><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card__head"><h2>Task recenti</h2><a class="link" href="/tasks.php?client_id=<?= (int)$client['id'] ?>">Vedi</a></div>
    <div class="tablewrap">
      <table class="table">
        <thead><tr><th>Titolo</th><th>Progetto</th><th>Status</th><th>Owner</th><th>Scadenza</th></tr></thead>
        <tbody>
        <?php foreach ($tasks as $t): ?>
          <tr>
            <td><a class="link" href="/tasks_view.php?id=<?= (int)$t['id'] ?>"><?= Security::e($t['title']) ?></a></td>
            <td><?= Security::e($t['project_name'] ?? '-') ?></td>
            <td><span class="pill"><?= Security::e($t['status']) ?></span></td>
            <td><?= Security::e($t['owner_name'] ?? '-') ?></td>
            <td><?= Security::e($t['due_date'] ?? '-') ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php if (empty($tasks)): ?><div class="empty">Nessuna task.</div><?php endif; ?>
  </div>
</div>
