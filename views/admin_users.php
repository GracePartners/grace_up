<div class="container">
  <div class="hstack hstack--between">
    <div><h1>Utenti</h1><div class="muted">Solo admin</div></div>
    <a class="btn" href="/admin_users_new.php">+ Nuovo</a>
  </div>
  <div class="card">
    <div class="tablewrap">
      <table class="table">
        <thead><tr><th>Nome</th><th>Email</th><th>Ruolo</th><th>Creato</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= Security::e($u['name']) ?></td>
            <td><?= Security::e($u['email']) ?></td>
            <td><span class="pill"><?= Security::e($u['role']) ?></span></td>
            <td class="muted"><?= Security::e($u['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
