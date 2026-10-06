<?php $title = 'Dashboard ' . $user->getPeran(); require BASE_PATH . '/app/views/layout/header.php'; ?>
<div class="wrap">
  <div class="card">
    <h1>Selamat datang, <?= e($user->getNama()) ?></h1>
    <p>Anda login sebagai <span class="badge"><?= e($user->getPeran()) ?></span></p>

    <div class="profile">
      <?php require BASE_PATH . '/app/views/layout/avatar.php'; ?>
      <table>
        <tr><td>No. KTP</td><td><?= e($user->getNoKtp()) ?></td></tr>
        <tr><td>Nama</td><td><?= e($user->getNama()) ?></td></tr>
        <tr><td>Jenis Kelamin</td><td><?= e($user->getLabelJenisKelamin()) ?></td></tr>
        <tr><td>Email</td><td><?= e($user->getEmail()) ?></td></tr>
        <tr><td>HP</td><td><?= e($user->getHp()) ?></td></tr>
        <?php /* Polymorphism: Siswa & Guru mengembalikan atribut berbeda, view tidak perlu if/else */ ?>
        <?php foreach ($user->getInfoKhusus() as $label => $nilai): ?>
          <tr><td><?= e($label) ?></td><td><?= e($nilai) ?></td></tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require BASE_PATH . '/app/views/layout/footer.php'; ?>
