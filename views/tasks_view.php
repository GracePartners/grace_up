<div class="container">
  <div class="hstack hstack--between">
    <div>
      <h1><?= Security::e($task['title']) ?></h1>
      <div class="muted"><?= Security::e($task['client_name'] ?? '') ?> · <?= Security::e($task['project_name'] ?? '') ?></div>
      <div class="chiprow" style="margin-top:10px;">
        <span class="pill"><?= Security::e($task['status']) ?></span>
        <span class="chip">Owner: <?= Security::e($task['owner_name'] ?? '-') ?></span>
        <span class="chip">Priorità: <?= Security::e($task['priority'] ?? '-') ?></span>
        <span class="chip">Due: <?= Security::e($task['due_date'] ?? '-') ?></span>
      </div>
    </div>
    <a class="btn btn--ghost" href="/tasks.php">Indietro</a>
  </div>

  <div class="grid grid--2">
    <div class="card">
      <div class="card__head"><h2>Descrizione</h2></div>
      <div><?= nl2br(Security::e($task['description'] ?? '')) ?></div>
      <div class="divider"></div>
      <form method="post" action="/tasks_update.php" class="form form--inline">
        <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
        <input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
        <select name="status"><?php foreach ($statuses as $s): ?><option value="<?= Security::e($s) ?>" <?= $task['status']===$s?'selected':'' ?>><?= Security::e($s) ?></option><?php endforeach; ?></select>
        <select name="owner_id"><option value="">— Owner —</option><?php foreach ($users as $u): ?><option value="<?= (int)$u['id'] ?>" <?= ((int)$task['owner_id']===(int)$u['id'])?'selected':'' ?>><?= Security::e($u['name']) ?></option><?php endforeach; ?></select>
        <button class="btn btn--soft" type="submit">Aggiorna</button>
      </form>
    </div>

    <div class="card">
      <div class="card__head"><h2>Checklist</h2></div>
      <div class="checklist">
        <?php foreach ($checklist as $it): ?>
          <form method="post" action="/tasks_checklist_toggle.php" class="checklist__item">
            <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
            <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
            <button class="checklist__box <?= $it['is_done'] ? 'is-done':'' ?>" type="submit"></button>
            <div class="checklist__text <?= $it['is_done'] ? 'is-done':'' ?>"><?= Security::e($it['text']) ?></div>
          </form>
        <?php endforeach; ?>
        <?php if (empty($checklist)): ?><div class="empty">Nessuna checklist.</div><?php endif; ?>
      </div>
      <div class="divider"></div>
      <form method="post" action="/tasks_checklist_add.php" class="form">
        <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
        <input type="hidden" name="task_id" value="<?= (int)$task['id'] ?>">
        <label>Aggiungi voce</label>
        <input name="text" required>
        <button class="btn btn--soft" type="submit">Aggiungi</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card__head"><h2>Commenti</h2></div>
    <div class="comments">
      <?php foreach ($comments as $c): ?>
        <div class="comment">
          <div class="comment__meta"><?= Security::e($c['user_name']) ?> · <span class="muted"><?= Security::e($c['created_at']) ?></span></div>
          <div class="comment__body"><?= nl2br(Security::e($c['body'])) ?></div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($comments)): ?><div class="empty">Nessun commento.</div><?php endif; ?>
    </div>
    <div class="divider"></div>
    <form method="post" action="/tasks_comment_add.php" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <input type="hidden" name="task_id" value="<?= (int)$task['id'] ?>">
      <label>Nuovo commento</label>
      <textarea name="body" rows="3" required></textarea>
      <button class="btn" type="submit">Invia</button>
    </form>
  </div>
</div>
