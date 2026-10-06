<?php $title = 'Login'; require BASE_PATH . '/app/views/layout/header.php'; ?>
<div class="wrap login">
  <div class="card">
    <h1>Login</h1>
    <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
    <form method="post" action="index.php?r=auth/login" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="<?= e($_POST['email'] ?? '') ?>" required autofocus>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Masuk</button>
    </form>
  </div>
</div>
<?php require BASE_PATH . '/app/views/layout/footer.php'; ?>
