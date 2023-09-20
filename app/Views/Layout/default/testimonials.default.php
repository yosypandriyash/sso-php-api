<!-- ======= Testimonials Section ======= -->
<div class="testimonials paralax-mf bg-image" style="background-image: url(<?= $customerTestimonialsWallpaperUrl; ?>)">
    <div class="overlay-mf"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="0">
                    <div class="swiper-wrapper">

                        <?php foreach ($customerTestimonialsItems as $customerTestimonialsItem): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-box">
                                <div class="author-img">
                                    <img src="<?= $customerTestimonialsItem['picture']; ?>" alt="" class="rounded-circle b-shadow-a">
                                    <span class="author"><?= $customerTestimonialsItem['author']; ?></span>
                                </div>
                                <div class="content-test">
                                    <p class="description lead">
                                        <?= $customerTestimonialsItem['content']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="swiper-slide">
                            <div class="testimonial-box">
                                <div class="author-test">
                                    <span class="testimonial-add-icon h1">💌</span>
                                    <span class="author">¿Quieres publicar una opinión?</span>
                                </div>
                                <div class="content-test">
                                    <p class="description lead">
                                        Escribiendome una opinion, aportas a que más gente pueda encontrarme y contactarme, <br>
                                        y por ello, me ayudas a seguir creciendo y mejorando en el ámbito laboral. <br>
                                        De antemano, muchas gracias! 🥰😘 <br>
                                        <button class="button button-a button-rouded mt-4">
                                            ✏️ Escribir opinión
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <!-- <div id="testimonial-mf" class="owl-carousel owl-theme">
            </div> -->
            </div>
        </div>
    </div>
</div><!-- End Testimonials Section -->