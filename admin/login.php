<?php
require __DIR__ . '/bootstrap.php';

use App\Core\Auth;
use App\Core\CSRF;

if (Auth::check()) {
    header('Location: /admin/dashboard.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::verify($_POST['csrf_token'] ?? null)) {
        $error = 'Invalid security token.';
    } elseif (Auth::login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
        header('Location: /admin/dashboard.php'); exit;
    } else {
        $error = 'Invalid login credentials.';
    }
}

adminLayoutStart('Admin Login');
?>
<div class="row justify-content-center"><div class="col-md-5"><div class="card shadow-sm"><div class="card-body">
<h3>Admin Login</h3>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>">
<div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
<div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
<button class="btn btn-primary w-100">Login</button>
</form>
</div></div></div></div>
<?php adminLayoutEnd(); ?>
