@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $est_connecter  = false;
    if($la_session !=null){
        $est_connecter =true;
        $id_menbre_connecter  = $la_session['id'];
    }
@endphp


@extends('base_front')

@section('content')

    <!--====== Project Details Area Start ======-->
    <section class="project-details-area section-gap-extra-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="project-thumb mb-md-50">
                        @if($le_crowd->lien_pitch_video!=null)
                            <iframe width="100%" height="400px" src="{{$le_crowd->lien_pitch_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <img src="{{url($le_crowd->image_illustration)}}" style="max-width: 100%" />
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <br/>
                    <div class="project-summery">
                        <a href="{{route('decouvrir_projets')}}" class="category">Retour</a>
                        <h3 class="project-title">
                            {{$le_crowd->titre}}
                        </h3>
                        {!! Session::get('notification','') !!}
                        <div class="meta">
                            <div class="author">
                                de :
                                <a href="#">{{$le_crowd->createur->nom_complet}}</a>
                            </div>
                            <a href="#" class="date"><i class="far fa-calendar-alt"></i>{{date('d-m/Y',strtotime($le_crowd->created_at))}}</a>
                        </div>
                        <div class="project-funding-info">
                            <div class="info-box" style="width: 185px">
                                <span>{{number_format($le_crowd->montant_objectif,0,',',' ')}}  {{$le_crowd->createur->devise_choisie->symbole}}</span>
                                <span class="info-title">Objectif</span>
                            </div>
                            <div class="info-box" style="width: 185px">
                                <span>{{sizeof($le_crowd->transactions)}}</span>
                                <span class="info-title">Soutien(s)</span>
                            </div>
                        </div>
                        <div class="project-raised clearfix">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="raised-label">Montant atteinds : {{number_format($le_crowd->caisse->montant,0,',',' ')}}  {{$le_crowd->createur->devise_choisie->monaie}}</div>
                                @php
                                    $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                                @endphp
                                <div class="percent-raised">{{$pourcentage}}%</div>
                            </div>
                            <div class="stats-bar" data-value="{{$pourcentage}}">
                                <div class="bar-line"></div>
                            </div>
                        </div>
                        <div class="project-form">
                            @if($est_connecter)
                        <form method="post" action="{{route('espace_menbre.confirmation_soutien_waricrowd')}}">
                                    <div class="form-group">

                                        <input class="form-control" type="hidden" name="id_crowd" value='{{$le_crowd->id}}' required/>
                                        <b>(montant en {{$le_crowd->createur->devise_choisie->monaie}})</b>
                                        <input class="form-control" type="number" name="montant_soutien" placeholder="150000" min="100" required/>
                                        <h3 class="text-center">
                                            @csrf
                                            <button type="submit" class="main-btn"> Soutenir le projet  <i class="far fa-arrow-right"></i></button>
                                        </h3>
                                    </div>
                                </form>
                            @else
                                <a href="{{route('connexion_menbre')}}" type="submit" class="main-btn"> Connectez vous pour soutenir un projet  <i class="far fa-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="project-details-tab">

                        <div class="tab-content" id="projectTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="description-content">
                                            <h4 class="description-title">{{$le_crowd->titre}}</h4>
                                            {{$le_crowd->description_complete}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-10">
                                       {{-- <div class="rewards-box mt-md-50">
                                            <h4 class="title">Rewards</h4>
                                            <img src="assets/img/project/project-rewards.jpg" alt="Image">
                                            <span class="rewards-count"><span>$530</span> or More</span>
                                            <p>
                                                But must explain to you how all this mistaken idea of denouncing plasue and praising pain was born
                                            </p>
                                            <div class="delivery-date">
                                                <span>25 Mar 20210</span>
                                                Estimated Delivery
                                            </div>
                                            <ul class="rewards-info">
                                                <li>
                                                    <i class="far fa-user-circle"></i>5 Backers
                                                </li>
                                                <li>
                                                    <i class="far fa-trophy-alt"></i>29 Rewards Left
                                                </li>
                                            </ul>
                                            <a href="events.html" class="main-btn">Select Rewards <i class="far fa-arrow-right"></i></a>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="update" role="tabpanel">
                                Update
                            </div>
                            <div class="tab-pane fade" id="bascker-list" role="tabpanel">
                                Bascker List
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                Reviews
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== Project Details Area End ======-->

@endsection
