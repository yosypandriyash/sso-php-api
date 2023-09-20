<div class="section-counter paralax-mf bg-image" style="background-image: url(<?= $customerSkillCountersBgUrl; ?>)">
    <div class="overlay-mf"></div>
    <div class="container position-relative">
        <div class="row">
            <?php foreach ($customerSkillCounters as $customerSkillCounter): ?>
                <div class="col-sm-3 col-lg-3">
                    <div class="counter-box counter-box pt-4 pt-md-0">
                        <div class="counter-ico">
                            <span class="ico-circle"><?= $customerSkillCounter['icon']; ?></span>
                        </div>
                        <div class="counter-num">
                            <p data-purecounter-start="0" data-purecounter-end="<?= $customerSkillCounter['amount']; ?>" data-purecounter-duration="1" class="counter purecounter"></p>
                            <span class="counter-text"><?= $customerSkillCounter['name']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>