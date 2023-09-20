<?= $this->include('Layout/default/header.default.php') ?>

<main id="main">

    <!-- ======= About Section ======= -->
    <?= $this->include('Layout/default/about-me.default.php') ?>

    <?= "" //foreach ($menuEntries as $entry): ?>
        <?= ""// if ($entry['enabled'] && $entry['template'] !== null): ?>
            <?= "" //$this->include($entry['template']) ?>
        <?= ""// endif; ?>
    <?= ""// endforeach; ?>

    <!-- ======= Services Section ======= -->
    <?= $this->include('Layout/default/services.default.php') ?>

    <!-- ======= Counter Section ======= -->
    <?= $this->include('Layout/default/skill-counters.default.php') ?>

    <!-- ======= Portfolio Section ======= -->
    <?= $this->include('Layout/default/personal-projects.default.php') ?>

    <!-- ======= Testimonials Section ======= -->
    <?= $this->include('Layout/default/testimonials.default.php') ?>

    <!-- ======= Blog Section ======= -->
    <?= $this->include('Layout/default/related-blogs.default.php') ?>

    <!-- ======= Contact Section ======= -->
    <?= $this->include('Layout/default/contact-form.default.php') ?>

</main>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
