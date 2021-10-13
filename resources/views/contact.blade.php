@extends('base_front')

@section('content')

    <!--====== Page Title Start ======-->
    <section class="page-title-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8">
                    <h1 class="page-title">Contactez Nous</h1>
                </div>
                <div class="col-auto">
                    <ul class="page-breadcrumb">
                        <li><a href="{{route('accueil')}}">Accueil</a></li>
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
            <div class="contact-from-area">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="contact-maps">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d48372.81123152747!2d-73.96448279177292!3d40.733408396164116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1627206548218!5m2!1sen!2sbd" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== Contact Section End ======-->


@endsection
