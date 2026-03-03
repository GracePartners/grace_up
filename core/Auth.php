<?php
final class Auth {
  public static function user(): ?array { return $_SESSION['user'] ?? null; }

  public static function requireLogin(): void {
    if (!self::user()) {
      header('Location: /login.php');
      exit;
    }
  }

  public static function isRole(string $role): bool {
    $u = self::user();
    return $u && ($u['role'] ?? '') === $role;
  }

  public static function requireRole(array $roles): void {
    $u = self::user();
    if (!$u || !in_array($u['role'] ?? '', $roles, true)) {
      http_response_code(403);
      exit('Permessi insufficienti');
    }
  }
}
