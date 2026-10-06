<?php
// Variabel: $user (objek Anggota/Siswa/Guru)
$foto   = $user->getTautanFoto();
$fotoOk = $foto !== null && is_file(BASE_PATH . '/' . $foto);
if ($fotoOk): ?>
  <img class="avatar" alt="Foto profil" src="<?= e($foto) ?>?v=<?= filemtime(BASE_PATH . '/' . $foto) ?>">
<?php else: ?>
  <div class="avatar"><?= e(strtoupper(substr($user->getNama(), 0, 1))) ?></div>
<?php endif; ?>
