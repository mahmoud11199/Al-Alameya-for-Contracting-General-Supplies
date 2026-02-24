<?php
require __DIR__ . '/bootstrap.php';
use App\Core\Auth; use App\Core\CSRF; use App\Core\Cache; use App\Models\ContentModel;
Auth::requireRole(['Admin','Editor']);
$model = new ContentModel();
if ($_SERVER['REQUEST_METHOD']==='POST' && CSRF::verify($_POST['csrf_token']??null)) {
    if (isset($_POST['delete_id'])) { $model->delete('services',(int)$_POST['delete_id']); }
    else { $model->create('services',['title'=>trim($_POST['title']),'summary'=>trim($_POST['summary']),'details'=>trim($_POST['details'])]); }
    Cache::clear();
}
$items = $model->getAll('services'); adminLayoutStart('Manage Services');
?>
<h3>Services</h3><form method="post" class="row g-2 mb-4"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><div class="col-md-3"><input required name="title" class="form-control" placeholder="Title"></div><div class="col-md-4"><input required name="summary" class="form-control" placeholder="Summary"></div><div class="col-md-4"><input required name="details" class="form-control" placeholder="Details"></div><div class="col-md-1"><button class="btn btn-primary">Add</button></div></form>
<table class="table table-striped"><tr><th>ID</th><th>Title</th><th></th></tr><?php foreach($items as $item): ?><tr><td><?= (int)$item['id'] ?></td><td><?= e($item['title']) ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="delete_id" value="<?= (int)$item['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php adminLayoutEnd(); ?>
