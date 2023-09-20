<section id="about" class="about-mf sect-pt4 route">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-shadow-full">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-5 col-lg-3">
                                    <div class="about-img">
                                        <img src="<?= $customerProfilePictureUrl; ?>" class="img-fluid rounded b-shadow-a" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-7 col-lg-9">
                                    <div class="about-info">
                                        <p><span class="h2"><?= $customerFullName; ?></span></p>
                                        <p><span class="h3"><?= $customerProfile; ?></span></p>
                                        <p><span class="h5"><i><?= $customerPhrase; ?></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="skill-mf">
                                        <h5 class="title-left mb-4">
                                            Niveles
                                        </h5>

                                        <?php foreach ($customerMainSkills as $customerMainSkill): ?>
                                            <span><?= ($customerMainSkill['name']); ?></span><br>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $customerMainSkill['amount']; ?>%;" aria-valuenow="<?= $customerMainSkill['amount']; ?>" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span><?= $customerMainSkill['amount'] == 100 ? "Nivel alto 💪" : "En progreso ⏳"; ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="about-me pt-4 pt-md-0">
                                <div class="title-box-2">
                                    <h5 class="title-left">
                                        <?= $menuEntries['about']['title']; ?>
                                    </h5>
                                </div>
                                <?php foreach ($customerAboutContent as $item): ?>
                                    <p class="lead">
                                        <?= $item; ?>
                                    </p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="work-experience mt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="title-left mb-5">
                                            Experiencia Laboral
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php foreach ($customerWorkExperience as $experienceItem): ?>
                                        <div class="col-xs-12 col-sm-6 col-lg-3">
                                            <div class="experience-item d-flex">
                                                <img src="<?= $experienceItem['companyIcon'] ?>" alt="<?= $experienceItem['companyName'] ?>">
                                                <div class="work-info pl-2">
                                                    <span class="company-name d-block"><?= $experienceItem['companyName'] ?></span>
                                                    <span class="d-block"><?= $experienceItem['start'] ?> - <?= $experienceItem['end'] ?></span>
                                                    <span class="d-block"><?= $experienceItem['workTitle'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="work-experience mt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="title-left mb-5">
                                            Estudios
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php foreach ($customerEducationCourses as $customerEducationCourse): ?>
                                        <div class="col-xs-12 col-sm-6 ">
                                            <div class="experience-item d-flex">
                                                <img src="<?= $customerEducationCourse['schoolIcon'] ?>" alt="<?= $customerEducationCourse['eduactionPlaceName'] ?>">
                                                <div class="work-info pl-2">
                                                    <span class="company-name d-block"><?= $customerEducationCourse['careerName'] ?></span>
                                                    <span class="d-block"><?= $customerEducationCourse['eduactionPlaceName'] ?></span>
                                                    <span class="d-block"><?= $customerEducationCourse['start'] ?> - <?= $customerEducationCourse['end'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>