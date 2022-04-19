@extends('base_front')

@section('content')
    <section class="faq-section section-gap">
        <div class="container">

			<div class="common-heading text-center mb-30">
				<span class="tagline">
					<!--<i class="fas fa-plus"></i> FAQ-->
					<span class="heading-shadow-text"><!--FAQ--></span>
				</span>
				<h2 class="title">Foire Aux Questions</h2>
			</div>

            <div class="row justify-content-center">
              <div class="tab-content" id="faqTabContent">
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="accordion" id="accordionFaqOne">
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="true" data-target="#accordion-1-1">
                                            Peut-on faire confiance à Waribana ?
                                        </h5>
                                        <div id="accordion-1-1" class="collapse show" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Oui ! Waribana est un site géré par la société RECYPLAST,
                                                 une société régie par la loi ivoirienne et enregistrée auprès du tribunal de commerce sous le numéro de 
                                                 RCCM CI-ABJ-2018-B-23928 et le N•CC : 1916993D,
                                                 Elle est domiciliée en Côte d’Ivoire.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-2">
                                            Combien de temps dure une tontine ?
                                        </h5>
                                        <div id="accordion-1-2" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                La durée d'une tontine dépend du nombre de participants et de la période choisie.
                                                 Par exemple une tontine mensuelle de 5 participants va durer 5 mois.
                                                 Une tontine hebdomadaire de 6 participants va durer 6 semaines par exemple.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-3">
                                            La Tontine est-elle interdite en Côte d’Ivoire ?
                                        </h5>
                                        <div id="accordion-1-3" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                La tontine est parfaitement légale.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-4">
                                            Quels sont les moyens utilisés pour le transfert d'argent ?
                                        </h5>
                                        <div id="accordion-1-4" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Le paiement des cotisations régulières des tontines de fait par le compte Waribank. L’approvisionnement du compte Waribank se fait par carte de crédit, par mobile money et par virement bancaire.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-5">
                                            Puis-changer de carte bancaire au cours d'une tontine ?
                                        </h5>
                                        <div id="accordion-1-5" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Absolument. Vous avez la possibilité de changer de carte à n'importe quel moment.
                                                 Les prélèvements se feront ainsi sur la nouvelle carte que vous aurez choisie.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-6">
                                            Où je peux recevoir l'argent collecté des tontines ?
                                        </h5>
                                        <div id="accordion-1-6" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                L’argent collecté est envoyé sur votre compte Waribank qui  peut être ensuite transféré selon vos choix (mobile money, virement bancaire ou directement dans un guichet Waribank)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-7">
                                            Comment je peux ajouter des participants à ma tontine ?
                                        </h5>
                                        <div id="accordion-1-7" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Vous pouvez ajouter des participants à des tontines soit en leur 
                                                envoyant un lien soit par mail, par SMS, par Whatsapp, Facebook, Messenger, Twitter à partir de votre espace personnel.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-8">
                                            Est-ce qu'une personne anonyme peut créer des tontines sur Waribana ?
                                        </h5>
                                        <div id="accordion-1-8" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Non malheureusement. Toute personne souhaitant créer des tontines sur Waribana doit fournir une pièce d'identité valable.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-9">
                                            Pourquoi des pièces personnelles me sont demandées après l'ouverture d'un compte ?
                                        </h5>
                                        <div id="accordion-1-9" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                Les pièces personnelles sont demandées pour des raisons de sécurité usurpation d'identité,
                                                 lutte anti-blanchiment, lutte contre le financement terroriste. 
                                                Cela permettra de sécuriser vos fonds et être en légalité vis-à-vis de la législation ivoirienne.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-10">
                                            Les tontines sont-elles garanties en cas d'impayé par un membre de la tontine ?
                                        </h5>
                                        <div id="accordion-1-10" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                L'objectif de Waribana est de proposer des tontines entre des proches.
                                                 Des personnes qui se connaissent entre elles et qui se font confiance. Cependant, Waribana, ne peut donc pas se porter garante en cas d'impayé.
                                                 C'est à l'utilisateur que revient la responsabilité de choisir les personnes avec qui il souhaite lancer des tontines.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-11">
                                            Qu'est ce qui se passe en cas d'impayé de la part d'un membre ?
                                        </h5>
                                        <div id="accordion-1-11" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                En cas d'impayé, le site fournit une attestation de situation financière de la personne qui n'a pas payé et les autres membres. 
                                                L'attestation spécifie le montant dû pour chaque personne, la date de paiement, l'identité de la personne n'ayant pas pu payer.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-title" data-toggle="collapse" aria-expanded="false" data-target="#accordion-1-12">
                                            Qu'est-ce que l'indice Waribana ?
                                        </h5>
                                        <div id="accordion-1-12" class="collapse" data-parent="#accordionFaqOne">
                                            <div class="accordion-content">
                                                L'indice de confiance est un indice attestant de la capacité historique d'un individu à rembourser sa tontine. 
                                                Il varie entre 0 et 10. Une personne qui vient de créer son compte aura un score de 5. 
                                                Si l'indice de confiance est élevé, cela veut dire que la personne n'a pas eu de difficultés à rembourser sa tontine.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </section>
@endsection
