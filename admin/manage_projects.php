<?php
require __DIR__ . '/bootstrap.php';
use App\Core\Auth; use App\Core\CSRF; use App\Core\Cache; use App\Models\ContentModel;
Auth::requireRole(['Admin','Editor']);
$model = new ContentModel();
if ($_SERVER['REQUEST_METHOD']==='POST' && CSRF::verify($_POST['csrf_token']??null)) {
    if (isset($_POST['delete_id'])) { $model->delete('projects',(int)$_POST['delete_id']); }
    else {
        $image = validateUpload($_FILES['image'] ?? []);
        $model->create('projects',['title'=>trim($_POST['title']),'summary'=>trim($_POST['summary']),'location'=>trim($_POST['location']),'completed_at'=>trim($_POST['completed_at']),'image'=>$image]);
    }
    Cache::clear();
}
$items = $model->getAll('projects'); adminLayoutStart('Manage Projects');
?>
<h3>Projects</h3><form method="post" enctype="multipart/form-data" class="row g-2 mb-4"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><div class="col-md-3"><input required name="title" class="form-control" placeholder="Title"></div><div class="col-md-3"><input required name="summary" class="form-control" placeholder="Summary"></div><div class="col-md-2"><input name="location" class="form-control" placeholder="Location"></div><div class="col-md-2"><input type="date" name="completed_at" class="form-control"></div><div class="col-md-2"><input type="file" name="image" class="form-control"></div><div class="col-12"><button class="btn btn-primary">Add Project</button></div></form>
<table class="table table-striped"><tr><th>ID</th><th>Title</th><th>Location</th><th></th></tr><?php foreach($items as $item): ?><tr><td><?= (int)$item['id'] ?></td><td><?= e($item['title']) ?></td><td><?= e($item['location']) ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="delete_id" value="<?= (int)$item['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php adminLayoutEnd(); ?>
