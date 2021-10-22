@extends('base_front')

@section('content')

    <!--====== Page Title Start ======-->
    <section class="page-title-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8">
                    <h1 class="page-title">Comment ça marche</h1>
                </div>
                <div class="col-auto">
                    <ul class="page-breadcrumb">
                        <li><a href="{{route('accueil')}}">Accueil</a></li>
                        <li>Comment ça marche</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--====== Page Title End ======-->

    <!--====== About Section Start ======-->
    <section class="about-section-four section-gap">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                {{-- <div class="col-lg-6 col-md-10">
                    <div class="about-img mb-md-70">
                        <img src="template/assets/img/about/about-three.jpg" alt="Image">
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="about-text">
                        <div class="common-heading mb-30">
							<span class="tagline">
								<!--<i class="fas fa-plus"></i> ?-->
								<span class="heading-shadow-text"><!--Comment ça marche--></span>
							</span>
                            <h2 class="title">Comment ça marche ?</h2>
                        </div>
                        <p class="mb-20">
                            Il s’agit d’un concept de financement participatif qui a deux objectifs principaux : 
                        </p>
                        <ul class="about-list mt-30">
                            <li><i class="fas fa-check"></i>Aider les utilisateurs à accéder à un crédit plus facilement et moins cher que les solutions actuelles</li>
                            <li><i class="fas fa-check"></i> la possibilité aux utilisateurs de se constituer une épargne en finançant leurs proches.</li>
                        </ul>
                        <br/>
                            <hr/>
                                <h4 class="text-center"> Tontines << Crédit epargne >> </h4>
                            <hr/>
                        <br/>
                        <p>
                            C’est une solution de ce qui s'appelle Tontines (Crédit-Epargne) entre proches.
                        </p>
                        <br/><br/>
                        Concrètement un groupe de personnes, se connaissant entre elles, se mettent ensemble et créent une <b>Tontine</b>. 
                        <br/><br/>
                        Sur Waribana, Ils définissent un montant régulier et une fréquence de rotation. Ensuite chaque période toutes les personnes versent le montant prédéfini et la somme est reversée à chacun d’eux à tour de <b>rôle </b>.
                        <br/><br/>
                        Ainsi, les premiers à avoir touché le montant total de la tontine font un <b>crédit </b> auprès de leurs proches, et les derniers se constituent une  
                        <b>épargne</b> en faisant profiter leurs proches de leur argent plutôt que de le mettre dans des comptes bancaires.

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== About Section End ======-->

    
    <!--====== About Section Start ======-->
    <section class="about-section-four section-gap">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                
                <div class="col-md-6">
                    <div class="about-img mb-md-70">
                        <img src="template/assets/img/tontine.png" alt="Image">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="about-text">
                        <div class="common-heading mb-30">
							<span class="tagline">
								<!--<i class="fas fa-plus"></i> ?-->
								<span class="heading-shadow-text"><!--Comment ça marche--></span>
							</span>
                            <h2 class="title">Resumé</h2>
                        </div>
                        <p class="mb-20">
                            Les participants d’une tontine définissent
                        </p>
                        <ul class="about-list mt-30">
                            <li>
                                <i class="fas fa-check"></i>Un montant régulier;
                            </li>
                            <li>
                                <i class="fas fa-check"></i> Une fréquence de rotation.
                            </li>
                        </ul>           
                        <p>
                            Ensuite chaque période, toutes les personnes paient le montant prédéfini et la somme est reversée à chacun d’eux à tour de rôle.
                        </p>
                    </div>
                </div>
            </div>
                <div class="col-12">
                  
                    <br/>
                    <hr/>
                        <h4 class="text-center"> Avantages </h4>
                    <hr/>
                    <br/>
                    Quand un client souhaite contracter un crédit classique, il doit disposer de :
                    <br/>
                    <ul style="padding-left: 15px">
                        <li><i class="fas fa-angle-right"></i> Un dossier extrêmement solide</li>
                        <li><i class="fas fa-angle-right"></i> Justifier de ses revenus</li>
                        <li><i class="fas fa-angle-right"></i> Avoir un emploi stable</li>
                        <li><i class="fas fa-angle-right"></i> Ne pas avoir de charges élevées, etc…</li>
                    </ul>
                    <br/>
                    Et même avec tous ces justificatifs, l’obtention du crédit n’est pas garantie. Donc au mieux, il faut un dossier très lourd à monter, au pire, le dossier est monté et le crédit refusé.
                    <br/><br/>
                    <br/>
                    Les avantages donc des tontines sont donc :
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">	
                            <ul class="check-list mt-30">
                                <li class="wow fadeInUp" data-wow-delay="0s">
                                    <h5 class="title">Extrêmement Simple</h5>
                                    <p>
                                        Avoir un accès au crédit beaucoup plus facilement car les créanciers sont des proches qui se font parfaitement confiance. Aucun justificatif de revenu n’est donc demandé. A-t-on besoin de justificatifs de revenus entre proches quand on se prête de l’argent ? Plus de détails dans la rubrique Sécurité plus bas.
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="check-list mt-30">
                                <li class="wow fadeInUp" data-wow-delay="0s">
                                    <h5 class="title">Solidaire</h5>
                                    <p>
                                        Avec les tontines, c’est plus facile de prêter à ses proches car le montant prêté est réparti entre plusieurs personnes. Exemple : Sur un montant total d’une tontine de 1000 € sur 10 personnes, chaque personne ne va verser que 100 €. C’est plus facile pour tout le monde de verser 100 € régulièrement qu’avoir une seule personne qui prête 1000 € à une autre ;
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="check-list mt-30">
                                <li class="wow fadeInUp" data-wow-delay="0.1s">
                                    <h5 class="title">Transparent</h5>
                                    <p>
                                        Les tontines permettent aussi de savoir exactement où est investi son argent. Les personnes qui souhaitent toucher le montant de la tontine en dernier se constituent une épargne en finançant leur proches plutôt que mettre leur argent dans des comptes bancaires ;
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="check-list mt-30">
                                <li class="wow fadeInUp" data-wow-delay="0.1s">
                                    <h5 class="title">Utile</h5>
                                    <p>
                                        Le dernier avantage pour les personnes qui ont du mal à économiser de l’argent de côté, les tontines sont la solution idéale pour se faire une épargne pour un besoin futur.
                                    </p>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== About Section End ======-->
@endsection
