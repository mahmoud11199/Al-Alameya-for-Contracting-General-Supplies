<section class="container py-5">
    <h1 class="section-title">Contact Us</h1>
    <?php if (!empty($message)): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post" action="/contact-submit" class="row g-3">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
        <div class="col-md-6"><input required name="name" class="form-control" placeholder="Name"></div>
        <div class="col-md-6"><input required type="email" name="email" class="form-control" placeholder="Email"></div>
        <div class="col-md-6"><input name="phone" class="form-control" placeholder="Phone"></div>
        <div class="col-md-6"><input name="subject" class="form-control" placeholder="Subject"></div>
        <div class="col-12"><textarea required name="message" class="form-control" rows="5" placeholder="Message"></textarea></div>
        <div class="col-12"><button class="btn btn-gold">Send Message</button></div>
    </form>
</section>
