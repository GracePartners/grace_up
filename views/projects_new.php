<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Nuovo progetto</h1><div class="muted">Con template task</div></div>
    <a class="btn btn--ghost" href="/projects.php">Indietro</a>
  </div>
  <?php if (!empty($error)): ?><div class="alert alert--danger"><?= Security::e($error) ?></div><?php endif; ?>
  <div class="card">
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <div class="grid grid--2">
        <div><label>Cliente *</label>
          <select name="client_id" required>
            <?php foreach ($clients as $c): ?><option value="<?= (int)$c['id'] ?>" <?= ((int)$client_id===(int)$c['id'])?'selected':'' ?>><?= Security::e($c['name']) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div><label>Nome *</label><input name="name" required></div>
        <div><label>Tipo</label><select name="type"><?php foreach ($types as $t): ?><option value="<?= Security::e($t) ?>"><?= Security::e($t) ?></option><?php endforeach; ?></select></div>
        <div><label>Status</label><select name="status"><?php foreach ($statuses as $s): ?><option value="<?= Security::e($s) ?>"><?= Security::e($s) ?></option><?php endforeach; ?></select></div>
        <div><label>Due date</label><input type="date" name="due_date"></div>
        <div><label>Owner</label>
          <select name="owner_id"><option value="">—</option><?php foreach ($users as $u): ?><option value="<?= (int)$u['id'] ?>"><?= Security::e($u['name']) ?></option><?php endforeach; ?></select>
        </div>
      </div>
      <label>Brief</label><textarea name="description" rows="4"></textarea>
      <div class="divider"></div>
      <label>Template task</label>
      <select name="template">
        <option value="">Nessuno</option>
        <option value="adv">ADV</option>
        <option value="web">WEB</option>
        <option value="social">SOCIAL</option>
      </select>
      <button class="btn" type="submit">Crea</button>
    </form>
  </div>
</div>
