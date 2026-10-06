<?php $title = 'Foto Profil'; require BASE_PATH . '/app/views/layout/header.php'; ?>
<div class="wrap">
  <div class="card">
    <h2>Foto Profil</h2>
    <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert ok"><?= e($success) ?></div><?php endif; ?>

    <div class="profile">
      <?php require BASE_PATH . '/app/views/layout/avatar.php'; ?>
      <form method="post" action="index.php?r=profil/upload" enctype="multipart/form-data" style="flex:1;min-width:240px">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label for="foto">Unggah foto baru (JPG/PNG/GIF/WEBP, maks 2 MB)</label>
        <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/gif,image/webp" required>
        <button type="submit">Unggah</button>
        <p style="color:#6b7280;font-size:13px">
          File akan disimpan sebagai <code><?= e($user->getNoKtp()) ?>.&lt;ekstensi&gt;</code> di folder <code>profil_picture</code>.
        </p>
      </form>
    </div>
  </div>
</div>
<?php require BASE_PATH . '/app/views/layout/footer.php'; ?>
