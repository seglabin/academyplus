<section id="featured-programs" class="featured-programs section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Ce que vous pouvez faire avec <span>Academy Plus?</span></h2>
        <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
    </div><!-- End Section Title -->
    @php
        $haut1 = '250px';
    @endphp
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
            <ul class="program-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">Toutes fonctionnalités</li>
                <li data-filter=".filter-bachelor">Gestion scolaire</li>
                <li data-filter=".filter-master">Profils</li>
                <li data-filter=".filter-Paiements">Paiementss</li>
            </ul>

            <div class="row g-4 isotope-container">
                <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="100">
                    <div class="program-item">
                        <div class="program-badge">Gestion scolaire</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/Inscription.jpeg')}}"
                                        class="img-fluid" alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Inscription</h3>
                                    <!-- <div class="program-highlights">
                                        <span><i class="bi bi-clock"></i> 4 Years</span>
                                        <span><i class="bi bi-people-fill"></i> 120 Credits</span>
                                        <span><i class="bi bi-calendar3"></i> Fall &amp; Spring</span>
                                    </div> -->
                                    <p>
                                        Enregistrement des inscriptions d'apprenant dans une classe
                                        <!-- <ul>
                                        <li></li>
                                    </ul> -->

                                    </p>
                                    <!-- <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="200">
                    <div class="program-item">
                        <div class="program-badge">Gestion scolaire</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="assets/img/education/education-3.webp" class="img-fluid" alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <br>
                                    <h3>Edition de Cartes</h3>
                                    <p>Vous pouvez, en quelques clicks, editer les cartes scolaires de vos apprenants
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="300">
                    <div class="program-item">
                        <div class="program-badge">Gestion scolaire</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="assets/img/education/education-5.webp" class="img-fluid" alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Evaluation</h3>

                                    <p>
<ul>
                                        <li>Enregistrer facilement les notes des différentes évaluations</li>
                                        <li>Génerer automatiquement des moyennes</li>
                                        <li>Edition des bulletins</li>
                                    </ul>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-master" data-aos="zoom-in" data-aos-delay="100">
                    <div class="program-item">
                        <div class="program-badge">Profils</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/apprenants.jpeg')}}" class="img-fluid"
                                        alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Apprenants</h3>
                                    <p>
                                    <ul>
                                        <li>Accédez à vos cours, résultats et ressources à tout moment.</li>
                                        <li>Une expérience d’apprentissage fluide et interactive, pensée pour votre
                                            réussite.</li>

                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-master" data-aos="zoom-in" data-aos-delay="200">
                    <div class="program-item">
                        <div class="program-badge">Profils</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/enseignants.jpeg')}}" class="img-fluid" alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Enseignant</h3>

                                    <p>
                                    <ul>
                                        <li>Gérez vos classes, vos notes et vos programmes en toute simplicité.</li>
                                        <li>Academy Plus vous aide à enseigner, planifier et interagir avec vos
                                            étudiants plus efficacement.</li>
                                    </ul>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-master" data-aos="zoom-in" data-aos-delay="200">
                    <div class="program-item">
                        <div class="program-badge">Profils</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/administration.jpeg')}}" class="img-fluid"
                                        alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Administration</h3>
                                    <p>
                                    <ul>
                                        <li>Supervisez l’ensemble des opérations scolaires depuis une seule plateforme.
                                        </li>
                                        <li>Centralisez la gestion des étudiants, enseignants et paiements pour un
                                            contrôle total.</li>
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-Paiements" data-aos="zoom-in" data-aos-delay="100">
                    <div class="program-item">
                        <div class="program-badge">Paiements</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/scolarité.jpeg')}}"
                                        class="img-fluid" alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Frais de scolarité</h3>
                                    <p>
                                    <ul>
                                        <li>Simplifiez le paiement de vos frais scolaires grâce à notre système en ligne.
                                        </li>
                                        <li>Academy Plus vous permet de régler vos frais en toute sécurité, où que vous soyez, sans files d’attente ni complications.</li>
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

                <div class="col-lg-6 isotope-item filter-Paiements" data-aos="zoom-in" data-aos-delay="100">
                    <div class="program-item">
                        <div class="program-badge">Paiements</div>
                        <div class="row g-0" style="height:{{ $haut1 }};">
                            <div class="col-md-5">
                                <div class="program-image-wrapper">
                                    <img src="{{ asset('assets/decouvrir/img/cotisations.jpeg')}}" class="img-fluid"
                                        alt="Program">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="program-content">
                                    <h3>Cotisations</h3>
                                    <p>
                                    <ul>
                                        <li>Permettre aux parents de faire de cotisations journalier pour faciliter ses
                                        paiements.
                                        </li>
                                        <li>Suivez vos cotisations, effectuez vos paiements et soutenez vos projets étudiants en toute transparence.</li>
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Program Item -->

            </div>
        </div>

    </div>

</section>