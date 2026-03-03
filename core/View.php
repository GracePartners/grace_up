<?php
final class View {
  public static function render(string $view, array $data = []): void {
    extract($data);
    $app = require __DIR__ . '/../config/app.php';
    $appName = $app['app_name'];
    require __DIR__ . '/../views/layout.php';
  }
}
