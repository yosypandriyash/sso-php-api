<!DOCTYPE html>
<html lang="<?= $pageLang ?>">
<head>
    <meta charset="utf-8">
    <title>Web Yosyp Andriyash</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="assets/img/logo_dark.png"" rel="icon">
    <link href="assets/img/logo_dark.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/lib/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/lib/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/lib/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body id="page-top" <?= $darkModeEnabled ? 'class="dark-mode"' : ''; ?> style="background: <?= $bodyBg; ?>">

<?= $this->include($page) ?>

<script src="/assets/lib/jquery/jquery.min.js"></script>
<script src="/assets/lib/purecounter/purecounter_vanilla.js"></script>
<script src="/assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/lib/glightbox/js/glightbox.min.js"></script>
<script src="/assets/lib/swiper/swiper-bundle.min.js"></script>
<script src="/assets/lib/typed.js/typed.min.js"></script>
<script src="/assets/lib/php-email-form/validate.js"></script>

<script src="/assets/js/portfolio/main.js"></script>
<?= $this->renderSection('page_js_scripts') ?>
</body>
</html>