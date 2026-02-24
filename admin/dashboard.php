<?php
require __DIR__ . '/bootstrap.php';

use App\Core\Auth;
use App\Models\ContentModel;
Auth::requireRole(['Admin','Editor']);
$stats = (new ContentModel())->stats();
adminLayoutStart('Dashboard');
?>
<div class="d-flex justify-content-between align-items-center"><h2>Dashboard</h2><div><a class="btn btn-outline-secondary" href="manage_projects.php">Projects</a> <a class="btn btn-outline-secondary" href="manage_blog.php">Blog</a> <a class="btn btn-outline-secondary" href="manage_services.php">Services</a> <?php if (Auth::user()['role']==='Admin'): ?><a class="btn btn-outline-secondary" href="manage_users.php">Users</a><?php endif; ?></div></div>
<div class="row g-3 mt-2"><?php foreach ($stats as $k=>$v): ?><div class="col-md-3"><div class="card"><div class="card-body"><h6><?= e(ucfirst(str_replace('_',' ', $k))) ?></h6><h3><?= (int)$v ?></h3></div></div></div><?php endforeach; ?></div>
<?php adminLayoutEnd(); ?>
