<?php $__env->startSection('content'); ?>

    <!--====== Page Title Start ======-->
    <section class="page-title-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8">
                    <h1 class="page-title">Contactez Nous</h1>
                </div>
                <div class="col-auto">
                    <ul class="page-breadcrumb">
                        <li><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                        <li>Contactez Nous</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--====== Page Title End ======-->

    <!--====== Contact Section Start ======-->
    <section class="contact-section section-gap-extra-bottom">
        <div class="container">
            <!-- Contact Info Start -->
            <div class="row align-items-center justify-content-center">
                <div class="col-lx-4 col-lg-5 col-sm-10">
                    <div class="contact-info-text mb-md-70">
                        <div class="common-heading mb-30">
                            <span class="tagline">
                                <!--<i class="fas fa-plus"></i>-->
                                <span class="heading-shadow-text"><!--Allo !--></span>
                            </span>
                            <h2 class="title">Près a en savoir plus</h2>
                        </div>
                        <p>
                            Besoin de plus d'information,Nous sommes là pour vous.<br/>
                            Rendez-vous dans nos locaux ou contactez nous.
                        </p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 offset-xl-1">
                    <div class="contact-info-boxes">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6 col-sm-10">
                                <div class="info-box text-center wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="icon">
                                        <i class="flaticon-place"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5>Adresse</h5>
                                        <p>
                                            Cocody, Riviera 3 Sideci
                                        </p>
                                    </div>
                                </div>
                                <div class="info-box text-center mt-30 mb-sm-30 wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="icon">
                                        <i class="flaticon-envelope"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5>Addresse email</h5>
                                        <p>
                                            <a href="mailto:info@waribana.ci" class="__cf_email__">info@waribana.ci</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-10">
                                <div class="info-box text-center wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="icon">
                                        <i class="flaticon-phone-call-1"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5>Support 24/7</h5>
                                        <p>
                                            +225 01 03 57 00 00 <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contact Info End -->
            
        </div>
    </section>
    <!--====== Contact Section End ======-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('base_front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/contact.blade.php ENDPATH**/ ?>