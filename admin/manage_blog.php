<?php
require __DIR__ . '/bootstrap.php';
use App\Core\Auth; use App\Core\CSRF; use App\Core\Cache; use App\Models\ContentModel;
Auth::requireRole(['Admin','Editor']);
$model = new ContentModel();
if ($_SERVER['REQUEST_METHOD']==='POST' && CSRF::verify($_POST['csrf_token']??null)) {
    if (isset($_POST['delete_id'])) { $model->delete('blog_posts',(int)$_POST['delete_id']); }
    else {
        $model->create('blog_posts',['title'=>trim($_POST['title']),'excerpt'=>trim($_POST['excerpt']),'body'=>trim($_POST['body']),'status'=>trim($_POST['status']),'published_at'=>date('Y-m-d H:i:s')]);
    }
    Cache::clear();
}
$items = $model->getAll('blog_posts'); adminLayoutStart('Manage Blog');
?>
<h3>Blog Posts</h3><form method="post" class="row g-2 mb-4"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><div class="col-md-3"><input required name="title" class="form-control" placeholder="Title"></div><div class="col-md-3"><input required name="excerpt" class="form-control" placeholder="Excerpt"></div><div class="col-md-3"><input required name="body" class="form-control" placeholder="Body"></div><div class="col-md-2"><select name="status" class="form-select"><option value="draft">Draft</option><option value="published">Published</option></select></div><div class="col-md-1"><button class="btn btn-primary">Add</button></div></form>
<table class="table table-striped"><tr><th>ID</th><th>Title</th><th>Status</th><th></th></tr><?php foreach($items as $item): ?><tr><td><?= (int)$item['id'] ?></td><td><?= e($item['title']) ?></td><td><?= e($item['status']) ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="delete_id" value="<?= (int)$item['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php adminLayoutEnd(); ?>
