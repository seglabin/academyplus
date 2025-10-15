@extends('layout', ["page_title" => Session('title'), "bg_title" => Session('bg')])
@section('content')

    <!-- Featured Programs Section -->
    <section id="featured-programs" class="featured-programs section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Academy Plus</h2>
            <h3>Facilite la gestion de votre votre école</h3>

        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <ul class="program-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">Fonctionnalités</li>
                    <li data-filter=".filter-acteur">Acteurs</li>
                    <li data-filter=".filter-evaluation">Evaluations</li>
                    <li data-filter=".filter-certificate">Finances</li>
                </ul>

                <div class="row g-4 isotope-container">
                    <div class="col-lg-6 isotope-item filter-acteur" data-aos="zoom-in" data-aos-delay="100">
                        <div class="program-item">
                            <div class="program-badge">acteur's Degree</div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="program-image-wrapper">
                                        <img src="assets/img/education/education-1.webp" class="img-fluid" alt="Program">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="program-content">
                                        <h3>Apprenants</h3>
                                        <p>Acéder à la liste des apprenants par classe et par année scolaire
                                            <br>
                                            On pourra selon ses droits :
                                        <div class="highlight-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span> Ajouter un apprenant</span>
                                        </div>
                                        <div class="highlight-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span> Mettre à jour les informations d'un apprenant</span>
                                        </div>
                                        <div class="highlight-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span> Inscrire ou réinscrire un apprenant</span>
                                        </div>

                                        <a href="#" class="program-btn"><span>Learn More</span> <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Program Item -->

                    <div class="col-lg-6 isotope-item filter-acteur" data-aos="zoom-in" data-aos-delay="200">
                        <div class="program-item">
                            <div class="program-badge">acteur's Degree</div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="program-image-wrapper">
                                        <img src="assets/img/education/education-3.webp" class="img-fluid" alt="Program">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="program-content">
                                        <h3>Enseignants</h3>
                                        <p>On présente ici le personnel enseignant.</p>
                                        <div class="highlight-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span> Liste des enseignants avec leur classes et matières</span>
                                        </div>

                                        <a href="#" class="program-btn"><span>Learn More</span> <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Program Item -->


                    <div class="col-lg-6 isotope-item filter-evaluation" data-aos="zoom-in" data-aos-delay="100">
                        <div class="program-item">
                            <div class="program-badge">Evaluation's Degree</div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="program-image-wrapper">
                                        <img src="assets/img/education/education-7.webp" class="img-fluid" alt="Program">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="program-content">
                                        <h3>Cours</h3>
                                        <h3>Maternel et primaire</h3>
                                        <div class="program-highlights">
                                            <span><i class="bi bi-clock"></i> 2 Years</span>
                                            <span><i class="bi bi-people-fill"></i> 60 Credits</span>
                                            <span><i class="bi bi-calendar3"></i> Spring Only</span>
                                        </div>
                                        <p>Aenean imperdiet, erat vel consequat mollis, nunc risus aliquam nunc, eget
                                            condimentum urna dui et metus.</p>
                                        <a href="#" class="program-btn"><span>Learn More</span> <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Program Item -->

                    <div class="col-lg-6 isotope-item filter-evaluation" data-aos="zoom-in" data-aos-delay="200">
                        <div class="program-item">
                            <div class="program-badge">Evaluation's Degree</div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="program-image-wrapper">
                                        <img src="assets/img/education/education-9.webp" class="img-fluid" alt="Program">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="program-content">
                                        <h3>Cours</h3>
                                        <h3>Secondaires et universitaires</h3>
                                        <div class="program-highlights">
                                            <span><i class="bi bi-clock"></i> 2 Years</span>
                                            <span><i class="bi bi-people-fill"></i> 64 Credits</span>
                                            <span><i class="bi bi-calendar3"></i> Fall &amp; Spring</span>
                                        </div>
                                        <p>Praesent tincidunt, massa et porttitor imperdiet, lorem ex ultricies ipsum, a
                                            tempus metus eros non tortor.</p>
                                        <a href="#" class="program-btn"><span>Learn More</span> <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Program Item -->

                    <div class="col-lg-6 isotope-item filter-certificate" data-aos="zoom-in" data-aos-delay="100">
                        <div class="program-item">
                            <div class="program-badge">Certificate</div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="program-image-wrapper">
                                        <img src="assets/img/education/education-2.webp" class="img-fluid" alt="Program">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="program-content">
                                        <h3>Data Science</h3>
                                        <div class="program-highlights">
                                            <span><i class="bi bi-clock"></i> 6 Months</span>
                                            <span><i class="bi bi-people-fill"></i> 24 Credits</span>
                                            <span><i class="bi bi-calendar3"></i> Year-round</span>
                                        </div>
                                        <p>Mauris sed erat in mi vestibulum commodo. Donec a purus at justo facilisis
                                            imperdiet tnteger pell</p>
                                        <a href="#" class="program-btn"><span>Learn More</span> <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Program Item -->

                </div>
            </div>

        </div>

    </section>
    <!-- /Featured Programs Section -->

@endsection