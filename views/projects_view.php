<div class="container">
  <div class="hstack hstack--between">
    <div><h1><?= Security::e($project['name']) ?></h1><div class="muted"><?= Security::e($project['client_name']) ?> · <span class="pill"><?= Security::e($project['status']) ?></span></div></div>
    <div class="hstack">
      <a class="btn btn--soft" href="/tasks_new.php?project_id=<?= (int)$project['id'] ?>">+ Task</a>
      <a class="btn btn--ghost" href="/projects.php">Indietro</a>
    </div>
  </div>
  <div class="grid grid--2">
    <div class="card"><div class="card__head"><h2>Brief</h2></div><?= nl2br(Security::e($project['description'] ?? '')) ?><div class="divider"></div><div class="muted">Owner: <?= Security::e($project['owner_name'] ?? '-') ?> · Due: <?= Security::e($project['due_date'] ?? '-') ?></div></div>
    <div class="card"><div class="card__head"><h2>Task</h2><a class="link" href="/tasks.php?project_id=<?= (int)$project['id'] ?>&view=kanban">Kanban</a></div>
      <div class="list">
        <?php foreach ($tasks as $t): ?>
          <a class="list__item" href="/tasks_view.php?id=<?= (int)$t['id'] ?>"><div class="pill"><?= Security::e($t['status']) ?></div><div class="list__title"><?= Security::e($t['title']) ?></div></a>
        <?php endforeach; ?>
        <?php if (empty($tasks)): ?><div class="empty">Nessuna task.</div><?php endif; ?>
      </div>
    </div>
  </div>
</div>
