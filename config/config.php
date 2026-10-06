<?php
// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_sekolah');
define('DB_USER', 'root');
define('DB_PASS', '');

// Path & upload
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_DIR', BASE_PATH . '/profil_picture/');
define('UPLOAD_URL', 'profil_picture/');
define('MAX_UPLOAD_SIZE', 2 * 1024 * 1024); // 2 MB
