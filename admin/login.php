<?php
require __DIR__ . '/bootstrap.php';

use App\Core\Auth;
use App\Core\CSRF;

if (Auth::check()) {
    header('Location: /admin/dashboard.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wait = (int) ($config['security']['login_rate_limit_seconds'] ?? 2);
    $lastAttempt = (int) ($_SESSION['login_last_attempt'] ?? 0);
    if ($lastAttempt > 0 && (time() - $lastAttempt) < $wait) {
        $error = 'Too many attempts. Please wait and retry.';
    } elseif (!CSRF::verify($_POST['csrf_token'] ?? null)) {
        $error = 'Invalid security token.';
    } elseif (Auth::login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
        unset($_SESSION['login_last_attempt']);
        header('Location: /admin/dashboard.php'); exit;
    } else {
        $_SESSION['login_last_attempt'] = time();
        $error = 'Invalid login credentials.';
    }
}

adminLayoutStart('Admin Login');
?>
<div class="row justify-content-center"><div class="col-md-5"><div class="card shadow-sm"><div class="card-body">
<h3>Admin Login</h3>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post" autocomplete="off">
<input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>">
<div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
<div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
<button class="btn btn-primary w-100">Login</button>
</form>
</div></div></div></div>
<?php adminLayoutEnd(); ?>
