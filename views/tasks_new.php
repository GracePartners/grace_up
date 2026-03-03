<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Nuova task</h1><div class="muted">Guidata</div></div>
    <a class="btn btn--ghost" href="/tasks.php">Indietro</a>
  </div>
  <?php if (!empty($error)): ?><div class="alert alert--danger"><?= Security::e($error) ?></div><?php endif; ?>
  <div class="card">
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= Security::e(Security::csrfToken()) ?>">
      <div class="grid grid--2">
        <div><label>Cliente *</label><select name="client_id" required><?php foreach ($clients as $c): ?><option value="<?= (int)$c['id'] ?>" <?= ((int)$client_id===(int)$c['id'])?'selected':'' ?>><?= Security::e($c['name']) ?></option><?php endforeach; ?></select></div>
        <div><label>Progetto *</label><select name="project_id" required><?php foreach ($projects as $p): ?><option value="<?= (int)$p['id'] ?>" <?= ((int)$project_id===(int)$p['id'])?'selected':'' ?>><?= Security::e($p['name']) ?></option><?php endforeach; ?></select></div>
        <div><label>Titolo *</label><input name="title" required></div>
        <div><label>Status</label><select name="status"><?php foreach ($statuses as $s): ?><option value="<?= Security::e($s) ?>"><?= Security::e($s) ?></option><?php endforeach; ?></select></div>
        <div><label>Owner</label><select name="owner_id"><option value="">—</option><?php foreach ($users as $u): ?><option value="<?= (int)$u['id'] ?>"><?= Security::e($u['name']) ?></option><?php endforeach; ?></select></div>
        <div><label>Priorità</label><select name="priority"><?php foreach ($priorities as $p): ?><option value="<?= Security::e($p) ?>"><?= Security::e($p) ?></option><?php endforeach; ?></select></div>
        <div><label>Scadenza</label><input type="date" name="due_date"></div>
        <div><label>Stima (ore)</label><input type="number" step="0.25" min="0" name="estimate_hours"></div>
      </div>
      <label>Descrizione</label><textarea name="description" rows="4"></textarea>
      <div class="divider"></div>
      <label>Checklist (una riga = un item)</label><textarea name="checklist" rows="4"></textarea>
      <button class="btn" type="submit">Crea</button>
    </form>
  </div>
</div>
