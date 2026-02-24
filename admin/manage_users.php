<?php
require __DIR__ . '/bootstrap.php';
use App\Core\Auth; use App\Core\CSRF; use App\Models\User;
Auth::requireRole(['Admin']);
$model = new User();
if ($_SERVER['REQUEST_METHOD']==='POST' && CSRF::verify($_POST['csrf_token']??null)) {
    if (isset($_POST['delete_id'])) { $model->delete((int)$_POST['delete_id']); }
    else {
        $model->create([
            'name'=>trim($_POST['name']),
            'email'=>trim($_POST['email']),
            'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role_id'=>(int)$_POST['role_id'],
        ]);
    }
}
$users = $model->all(); $roles = $model->roles(); adminLayoutStart('Manage Users');
?>
<h3>Users</h3><form method="post" class="row g-2 mb-4"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><div class="col-md-3"><input required name="name" class="form-control" placeholder="Name"></div><div class="col-md-3"><input required type="email" name="email" class="form-control" placeholder="Email"></div><div class="col-md-3"><input required name="password" type="password" class="form-control" placeholder="Password"></div><div class="col-md-2"><select name="role_id" class="form-select"><?php foreach($roles as $role): ?><option value="<?= (int)$role['id'] ?>"><?= e($role['name']) ?></option><?php endforeach; ?></select></div><div class="col-md-1"><button class="btn btn-primary">Add</button></div></form>
<table class="table table-striped"><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th></th></tr><?php foreach($users as $u): ?><tr><td><?= (int)$u['id'] ?></td><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['role_name']) ?></td><td><?php if((int)$u['id'] !== (int)Auth::user()['id']): ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="delete_id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form><?php endif; ?></td></tr><?php endforeach; ?></table>
<?php adminLayoutEnd(); ?>
