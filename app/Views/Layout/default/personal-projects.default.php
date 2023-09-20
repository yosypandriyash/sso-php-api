<!-- ======= Portfolio Section ======= -->
<section id="work" class="portfolio-mf sect-pt4 route">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-box text-center">
                    <h3 class="title-a">
                        <?= $menuEntries['work']['title']; ?>
                    </h3>
                    <p class="subtitle-a">
                        <?= $menuEntries['work']['subtitle']; ?>
                    </p>
                    <div class="line-mf"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($customerWorkItems as $customerWorkItem): ?>
                <div class="col-md-4">
                    <div class="work-box">
                        <a href="<?= $customerWorkItem['image']; ?>"
                           class="portfolio-lightbox"
                           data-gallery="<?= str_replace(' ', '_', $customerWorkItem['title']); ?>"
                           data-title="<?= $customerWorkItem['title']; ?>">
                            <div class="work-img">
                                <img src="<?= $customerWorkItem['image']; ?>" alt="<?= $customerWorkItem['title']; ?>" class="img-fluid">
                            </div>
                        </a>
                        <div class="work-content">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h2 class="w-title"><?= $customerWorkItem['title']; ?></h2>
                                    <div class="w-more">
                                        <span class="w-ctegory"><?= $customerWorkItem['category']; ?></span> / <span class="w-date"><?= $customerWorkItem['date']; ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="w-like">
                                        <a target="_blank" href="<?= $customerWorkItem['url']; ?>"><span class="bi bi-link-45deg"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($customerWorkItem['gallery'])): ?>
                            <?php foreach ($customerWorkItem['gallery'] as $image): ?>
                                <a href="<?= $image; ?>"
                                   class="portfolio-lightbox"
                                   data-gallery="<?= str_replace(' ', '_', $customerWorkItem['title']); ?>"
                                   data-title="<?= $customerWorkItem['title']; ?>"></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section><!-- End Portfolio Section -->