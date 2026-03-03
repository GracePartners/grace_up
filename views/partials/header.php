<?php
require_once __DIR__ . '/../../core/Security.php';
require_once __DIR__ . '/../../core/Auth.php';
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= Security::e($appName) ?></title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="brand">
      <div class="brand__logo">G</div>
      <div class="brand__text">
        <div class="brand__name"><?= Security::e($appName) ?></div>
        <div class="brand__sub">Gestione progetti, semplice</div>
      </div>
    </div>

    <?php if (Auth::user()): ?>
      <nav class="nav">
        <a class="nav__item" href="/dashboard.php">Oggi</a>
        <a class="nav__item" href="/clients.php">Clienti</a>
        <a class="nav__item" href="/projects.php">Progetti</a>
        <a class="nav__item" href="/tasks.php">Task</a>
        <a class="nav__item" href="/team.php">Team</a>
        <?php if (Auth::isRole('admin')): ?>
          <a class="nav__item" href="/admin_users.php">Utenti</a>
        <?php endif; ?>
      </nav>
      <div class="sidebar__footer">
        <div class="me">
          <div class="me__dot"></div>
          <div class="me__meta">
            <div class="me__name"><?= Security::e(Auth::user()['name'] ?? '') ?></div>
            <div class="me__role"><?= Security::e(Auth::user()['role'] ?? '') ?></div>
          </div>
        </div>
        <a class="btn btn--ghost" href="/logout.php">Logout</a>
      </div>
    <?php else: ?>
      <div class="sidebar__footer">
        <a class="btn" href="/login.php">Login</a>
      </div>
    <?php endif; ?>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="topbar__title"></div>
      <div class="topbar__actions">
        <?php if (Auth::user()): ?>
          <a class="btn btn--soft" href="/tasks_new.php">+ Nuova task</a>
          <a class="btn btn--soft" href="/projects_new.php">+ Nuovo progetto</a>
        <?php endif; ?>
      </div>
    </div>
