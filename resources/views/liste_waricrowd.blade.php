@extends('base_front')

@section('content')


    <!--====== Project Area Start ======-->
    <section class="project-section section-gap-extra-bottom primary-soft-bg">
        <div class="container">
            <div class="row project-items justify-content-center project-style-one">

                @foreach($liste_waricrowd as $item_crowd)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="project-item mb-30">
                        <div class="thumb" style="background-image: url({{$item_crowd['image_illustration']}});"></div>
                        <div class="content">
                            <div class="cats">
                                <a href="{{route('details_projet',[$item_crowd->id])}}">{{$item_crowd['titre']}}</a>
                            </div>
                       {{--     <div class="author">
                                <img src="assets/img/author-thumbs/01.jpg" alt="Thumb">
                                <a href="#">James W. Barrows</a>
                            </div>--}}
                            <h5>
                                <a href="{{route('details_projet',[$item_crowd->id])}}">{{Str::limit($item_crowd['description_courte'], $limit = 120, $end = '...')}}</a>
                            </h5>
                            <div class="project-stats">
                                @php
                                    $pourcentage = round($item_crowd->caisse->montant *100 / $item_crowd->caisse->montant_objectif,2);
                                @endphp
                                @if($pourcentage > 0)
                                    <div class="stats-value">
                                        <span class="value-title">Montant atteind : <span class="value"> {{number_format($item_crowd->caisse->montant,0,',',' ')}}F </span></span>
                                        <span class="stats-percentage">{{$pourcentage}}%</span>
                                    </div>
                                    <div class="stats-bar" data-value="{{$pourcentage}}">
                                        <div class="bar-line"></div>
                                    </div>
                                @endif
                            </div>
                            <span class="date"><i class="far fa-calendar-alt"></i> {{date('d-m-Y',strtotime($item_crowd['created_at']))}}</span>

                            <h3 class="text-center">
                                <a class="btn btn-dark" href="{{route('details_projet',[$item_crowd->id])}}">Decouvrir le projet</a>
                            </h3>
                        </div>
                    </div>
                </div>
                @endforeach

                {{--<div class="col-12">
                    <div class="view-more-btn text-center mt-40">
                        {{ $liste_waricrowd->links()}}
                    </div>
                </div>--}}
            </div>
        </div>
    </section>
    <!--====== Project Area End ======-->

@endsection
