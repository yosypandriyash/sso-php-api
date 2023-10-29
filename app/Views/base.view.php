<!DOCTYPE html>
<html lang="<?= $pageLang ?>">
<head>
    <meta charset="utf-8">
    <title>Portfolio Designer</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Vendor CSS Files -->
    <link href="/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/lib/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body>

<?= $this->include($page) ?>

<script src="/assets/js/app/main.js"></script>

<?= $this->renderSection('page_js_scripts') ?>
</body>
</html>