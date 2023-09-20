<!--/ Section Services Star /-->
<section id="service" class="services-mf route">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-box text-center">
                    <h3 class="title-a mt-4">
                        <?= $menuEntries['services']['title']; ?>
                    </h3>
                    <p class="subtitle-a">
                        <?= $menuEntries['services']['subtitle']; ?>
                    </p>
                    <div class="line-mf"></div>
                </div>
            </div>
        </div>
        <div class="row">

            <?php foreach ($customerOfferServices as $customerOfferService): ?>
                <div class="col-md-4">
                    <div class="service-box">
                        <div class="service-ico">
                            <span class="ico-circle service-emoji"><?= $customerOfferService['icon']?></span>
                        </div>
                        <div class="service-content">
                            <h2 class="s-title"><?= $customerOfferService['title']?></h2>
                            <p class="s-description text-center">
                                <?= $customerOfferService['description']?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<!--/ Section Services End /-->