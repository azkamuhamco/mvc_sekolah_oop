<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Sistem Sekolah') ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php if (!empty($_SESSION['no_ktp'])): ?>
<div class="nav">
  <strong>Sistem Sekolah</strong>
  <div>
    <a href="index.php?r=dashboard/index">Dashboard</a>
    <a href="index.php?r=profil/index">Foto Profil</a>
    <a href="index.php?r=auth/logout">Keluar</a>
  </div>
</div>
<?php endif; ?>
