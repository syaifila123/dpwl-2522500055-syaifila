
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

define('APPPATH', __DIR__ . '/application/');

require_once APPPATH . 'config/database.php';
require_once APPPATH . 'config/config.php';
require_once APPPATH . 'config/routes.php';
require_once APPPATH . 'helpers/url_helper.php';
require_once APPPATH . '../system/core/controller.php';

// Ambil URI dari query parameter 'route' atau PATH_INFO
$uri = $_GET['route'] ?? ($_SERVER['PATH_INFO'] ?? '');
$uri = trim($uri, '/');

// Gunakan controller default jika URI kosong
if ($uri === '') {
  $uri = $route['default_controller'] ?? 'Katalog_controller';
}

// Cek apakah URI cocok dengan definisi route
if (isset($route[$uri])) {
  $target = $route[$uri];
} else {
  $target = $uri;

  // Cek pencocokan route berparameter
  foreach ($route as $key => $val) {
    if ($key === 'default_controller') {
      continue;
    }

    $pattern = '#^' .
      str_replace(
        ['(:any)', '(:num)'],
        ['([^/]+)', '([0-9]+)'],
        $key
      ) .
      '$#';

    if (preg_match($pattern, $uri)) {
      $target = preg_replace($pattern, $val, $uri);
      break;
    }
  }
}

// Pisahkan controller, method, dan parameter
$segments = explode('/', $target);

$controllerName = ucfirst($segments[0]);
$methodName = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

// Tentukan lokasi file controller
$controllerFile = APPPATH . 'controllers/' . $controllerName . '.php';

// Periksa keberadaan file controller
if (is_file($controllerFile)) {

  require_once $controllerFile;

  // Periksa keberadaan class controller
  if (class_exists($controllerName)) {

    $controller = new $controllerName();

    // Periksa keberadaan method
    if (method_exists($controller, $methodName)) {

      // Jalankan method beserta parameter jika tersedia
      call_user_func_array(
        [$controller, $methodName],
        $params
      );

      exit;
    }
  }
}

// Jika controller atau method tidak ditemukan
http_response_code(404);
echo "Halaman tidak ditemukan (404).";
