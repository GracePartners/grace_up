<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Task</h1><div class="muted">Lista o Kanban</div></div>
    <a class="btn" href="/tasks_new.php<?= $project_id ? '?project_id='.(int)$project_id : '' ?>">+ Nuova</a>
  </div>

  <div class="card">
    <form class="form form--inline" method="get">
      <input name="q" placeholder="Cerca task..." value="<?= Security::e($q) ?>">
      <select name="status"><option value="">Tutti gli stati</option><?php foreach ($statuses as $s): ?><option value="<?= Security::e($s) ?>" <?= $status===$s?'selected':'' ?>><?= Security::e($s) ?></option><?php endforeach; ?></select>
      <select name="assignee"><option value="">Tutti gli owner</option><?php foreach ($users as $u): ?><option value="<?= (int)$u['id'] ?>" <?= ((int)$assignee===(int)$u['id'])?'selected':'' ?>><?= Security::e($u['name']) ?></option><?php endforeach; ?></select>
      <select name="view"><option value="list" <?= $view==='list'?'selected':'' ?>>Lista</option><option value="kanban" <?= $view==='kanban'?'selected':'' ?>>Kanban</option></select>
      <?php if ($client_id): ?><input type="hidden" name="client_id" value="<?= (int)$client_id ?>"><?php endif; ?>
      <?php if ($project_id): ?><input type="hidden" name="project_id" value="<?= (int)$project_id ?>"><?php endif; ?>
      <?php if ($filter): ?><input type="hidden" name="filter" value="<?= Security::e($filter) ?>"><?php endif; ?>
      <button class="btn btn--soft" type="submit">Filtra</button>
      <a class="btn btn--ghost" href="/tasks.php">Reset</a>
    </form>
  </div>

  <?php if ($view === 'kanban'): ?>
    <form style="display:none"><input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>"></form>
    <div class="kanban" data-kanban="1">
      <?php foreach ($statuses as $col): ?>
        <div class="kanban__col">
          <div class="kanban__head"><?= Security::e($col) ?></div>
          <div class="kanban__list" data-status="<?= Security::e($col) ?>">
            <?php foreach (($byStatus[$col] ?? []) as $t): ?>
              <div class="kanban__card" draggable="true" data-task-id="<?= (int)$t['id'] ?>">
                <div class="kanban__title"><a class="link" href="/tasks_view.php?id=<?= (int)$t['id'] ?>"><?= Security::e($t['title']) ?></a></div>
                <div class="kanban__meta"><?= Security::e($t['client_name'] ?? '') ?> · <?= Security::e($t['project_name'] ?? '') ?></div>
              </div>
            <?php endforeach; ?>
            <?php if (empty($byStatus[$col] ?? [])): ?><div class="empty empty--small">—</div><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="card">
      <div class="tablewrap">
        <table class="table">
          <thead><tr><th>Titolo</th><th>Cliente</th><th>Progetto</th><th>Status</th><th>Owner</th><th>Priorità</th><th>Scadenza</th></tr></thead>
          <tbody>
          <?php foreach ($tasks as $t): ?>
            <tr>
              <td><a class="link" href="/tasks_view.php?id=<?= (int)$t['id'] ?>"><?= Security::e($t['title']) ?></a></td>
              <td><?= Security::e($t['client_name'] ?? '-') ?></td>
              <td><?= Security::e($t['project_name'] ?? '-') ?></td>
              <td><span class="pill"><?= Security::e($t['status']) ?></span></td>
              <td><?= Security::e($t['owner_name'] ?? '-') ?></td>
              <td><?= Security::e($t['priority'] ?? '-') ?></td>
              <td><?= Security::e($t['due_date'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if (empty($tasks)): ?><div class="empty">Nessuna task.</div><?php endif; ?>
    </div>
  <?php endif; ?>
</div>
