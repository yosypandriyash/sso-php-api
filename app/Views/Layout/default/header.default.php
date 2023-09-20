<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="#"><?= $pageLogoTitle; ?></a></h1>
        <nav id="navbar" class="navbar">
            <ul>
                <?php foreach ($menuEntries as $menuEntry): ?>
                    <li>
                        <a class="nav-link scrollto" href="<?= $menuEntry['url'] ?>"><?= $menuEntry['title'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<div id="hero" class="hero route bg-image" style="background-image: url('<?= $headerBackgroundUrl; ?>')">
    <div class="overlay-itro"></div>
    <div class="hero-content display-table">
        <div class="table-cell">
            <div class="container">
                <!--<p class="display-6 color-d">Hello, world!</p>-->

                <div class="md-hidden mt-4"></div>
                <h1 class="hero-title mb-4 md-text-right h1"><?= $headerTitle; ?></h1>
                <p class="hero-subtitle d-block md-text-right "><span class="typed" data-typed-items="<?= implode(', ', $headerSubtitleSliderItems) ?>"></span></p>
                <!-- <p class="pt-3"><a class="btn btn-primary btn js-scroll px-4" href="#about" role="button">Learn More</a></p> -->
            </div>
        </div>
    </div>
</div><!-- End Hero Section -->
