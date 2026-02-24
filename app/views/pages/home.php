<section class="hero text-light text-center d-flex align-items-center">
    <div class="container py-5">
        <h1 class="display-5 fw-bold fade-in">Engineering Confidence. Delivering Excellence.</h1>
        <p class="lead">Enterprise-grade contracting and general supply services across Egypt and the MENA region.</p>
        <a href="/contact" class="btn btn-gold btn-lg">Request Proposal</a>
    </div>
</section>
<section class="container py-5">
    <h2 class="section-title">Core Services</h2><div class="row g-4">
    <?php foreach ($services as $service): ?><div class="col-md-4"><div class="card h-100 shadow-sm"><div class="card-body"><h5><?= htmlspecialchars($service['title']) ?></h5><p><?= htmlspecialchars($service['summary']) ?></p></div></div></div><?php endforeach; ?>
    </div>
</section>
<section class="container pb-5"><h2 class="section-title">Featured Projects</h2><div class="row g-4"><?php foreach ($projects as $project): ?><div class="col-md-4"><div class="card h-100"><img loading="lazy" src="<?= htmlspecialchars($project['image'] ?: '/assets/img-placeholder.jpg') ?>" class="card-img-top" alt="project"><div class="card-body"><h5><?= htmlspecialchars($project['title']) ?></h5><p><?= htmlspecialchars($project['location']) ?></p></div></div></div><?php endforeach; ?></div></section>
