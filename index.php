<?php
require __DIR__ . '/core/bootstrap.php';
header('Location: ' . (Auth::user() ? '/dashboard.php' : '/login.php'));
