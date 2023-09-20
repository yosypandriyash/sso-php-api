
<section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(assets/img/overlay-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="contact-mf">
                    <div id="contact" class="box-shadow-full">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-box-2">
                                    <h5 class="title-left">
                                        Contacta conmigo
                                    </h5>
                                </div>
                                <div>
                                    <form action="/contact/send-contact-form" method="post" role="form" class="php-email-form">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="contactName" class="form-control" placeholder="Tu nombre" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="contactEmail" placeholder="Tu Email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="contactPhoneNumber" placeholder="Número de teléfono" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="contactMessage" rows="5" placeholder="Mensaje" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center my-3">
                                                <div class="loading">Loading</div>
                                                <div class="error-message"></div>
                                                <div class="sent-message">Tu mensaje ha sido enviado. Muchas gracias! 👍🏻</div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="button button-a button-big button-rouded">Enviar mensaje 📤</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title-box-2 pt-4 pt-md-0">
                                    <h5 class="title-left">
                                        Y recuerda...
                                    </h5>
                                </div>
                                <div class="more-info">
                                    <p class="lead">
                                        <?= $customerContactMessage; ?>
                                    </p>
                                    <ul class="list-ico">
                                        <li><span class="bi bi-phone"></span><span class="phone-number"><?= $customerContactPhoneNumber; ?></span></li>
                                        <li><span class="bi bi-envelope"></span><?= $customerContactEmail; ?></li>
                                    </ul>
                                </div>
                                <div class="socials">
                                    <ul>
                                        <?php foreach ($customerRRSSLinks as $customerRRSSLink): ?>
                                            <li><a title="Mi perfil en <?= $customerRRSSLink['name'] ?>" target="_blank" href="<?= $customerRRSSLink['url'] ?>"><span class="ico-circle"><i class="<?= $customerRRSSLink['icon'] ?>"></i></span></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>