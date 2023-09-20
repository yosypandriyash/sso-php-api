<!--/ Section Blog Star /-->
<section id="blog" class="blog-mf sect-pt4 route">
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="title-box text-center">
                    <h3 class="title-a">
                        <?= $menuEntries['blog']['title']; ?>
                    </h3>
                    <p class="subtitle-a">
                        <?= $menuEntries['blog']['subtitle']; ?>
                    </p>
                    <div class="line-mf"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($customerBlogItems as $customerBlogItem): ?>
                <div class="col-md-4">
                    <div class="card card-blog">
                        <div class="card-img">
                            <a href="<?= $customerBlogItem['url']; ?>"><img src="<?= $customerBlogItem['picture']; ?>" alt="" class="img-fluid"></a>
                        </div>
                        <div class="card-body">
                            <div class="card-category-box">
                                <div class="card-category">
                                    <h6 class="category"><?= $customerBlogItem['category']; ?></h6>
                                </div>
                            </div>
                            <h3 class="card-title"><a href="blog-single.html"><?= $customerBlogItem['title']; ?></a></h3>
                            <p class="card-description">
                                <?= $customerBlogItem['content']; ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="post-author">
                                <a href="#">
                                    <img src="<?= $customerBlogItem['author']['picture']; ?>" alt="" class="avatar rounded-circle">
                                    <span class="author"><?= $customerBlogItem['author']['name']; ?></span>
                                </a>
                            </div>
                            <div class="post-date">
                                <span class="ion-ios-clock-outline"></span> <?= $customerBlogItem['date']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<!--/ Section Blog End /-->