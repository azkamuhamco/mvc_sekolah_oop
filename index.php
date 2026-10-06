<?php
// Front controller: index.php?r=controller/method
session_start();

require __DIR__ . '/config/config.php';
require __DIR__ . '/core/helpers.php';
require __DIR__ . '/core/Database.php';
require __DIR__ . '/core/Controller.php';

spl_autoload_register(function (string $class) {
    foreach (['/app/models/', '/app/repositories/', '/app/controllers/'] as $dir) {
        $f = __DIR__ . $dir . $class . '.php';
        if (is_file($f)) { require $f; return; }
    }
});

$route = $_GET['r'] ?? 'auth/login';
[$c, $m] = array_pad(explode('/', $route, 2), 2, 'index');

if (!preg_match('/^[a-z]+$/', $c) || !preg_match('/^[a-z_]+$/i', $m)) {
    http_response_code(404); exit('Halaman tidak ditemukan.');
}

$class = ucfirst($c) . 'Controller';
if (!class_exists($class) || !is_callable([$ctrl = new $class, $m])) {
    http_response_code(404); exit('Halaman tidak ditemukan.');
}

try {
    $ctrl->$m();
} catch (PDOException $ex) {
    http_response_code(500);
    exit('Kesalahan database. Periksa konfigurasi di config/config.php.');
} catch (InvalidArgumentException $ex) {
    http_response_code(500);
    exit('Data tidak valid: ' . e($ex->getMessage()));
}
