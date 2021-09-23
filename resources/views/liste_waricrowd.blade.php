@extends('base_front')

@section('content')

    <div class="col-auto">
        <div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> +
								<span class="heading-shadow-text">Soutenez ou faites financer votre projet </span>
							</span>
            <h2 class="title text-center">WARICROWDS</h2>
        </div>
    </div>

    <div class="container">
        <form>
            <div class="row">
             <div class="col-md-3 text-center">
                <h3>Categorie</h3>
                <select name="id_categorie">
                    @if($la_categorie !=null)
                        <option value="{{$la_categorie->id}}">{{$la_categorie->titre}}</option>
                    @else
                        <option value>(selectionner)</option>
                        <option value="0">Tout</option>
                    @endif
                    @foreach($liste_categorie as $item)
                        <option value="{{$item['id']}}">{{$item->titre}}</option>
                    @endforeach
                </select>
                 <br/>
                 <button type="submit" class="btn btn-dark">Trier</button>
             </div>
            {{--<div class="col-md-3">
                <h3>date de publication</h3>
                <input type="date" name="date_publication" value="{{$date_publication}}" />
            </div>
            <div class="col-md-3">
                <h3>Nom du projet</h3>
                <input type="text" name="mot_cle" value="{{$mot_cle}}" />
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-dark">Trier</button>
            </div>
                --}}
         </div>
        </form>
    </div>
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
                                <a href="{{route('details_projet',[$item_crowd->id])}}">{{$item_crowd->categorie->titre}}</a>
                            </div>
                       {{--     <div class="author">
                                <img src="assets/img/author-thumbs/01.jpg" alt="Thumb">
                                <a href="#">James W. Barrows</a>
                            </div>--}}
                            <h5>
                                <a href="{{route('details_projet',[$item_crowd->id])}}">{{Str::limit($item_crowd['titre'], $limit = 120, $end = '...')}}</a>
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