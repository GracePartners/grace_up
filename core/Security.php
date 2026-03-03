<?php
final class Security {
  public static function startSession(): void {
    $app = require __DIR__ . '/../config/app.php';
    session_name($app['session_name']);
    session_set_cookie_params([
      'lifetime' => 0,
      'path' => '/',
      'secure' => !empty($_SERVER['HTTPS']),
      'httponly' => true,
      'samesite' => 'Lax',
    ]);
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  }

  public static function csrfToken(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
  }

  public static function verifyCsrf(?string $token): void {
    if (!$token || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
      http_response_code(419);
      exit('CSRF token non valido');
    }
  }

  public static function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}
