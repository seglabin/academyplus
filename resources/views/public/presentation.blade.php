<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Academy Plus</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    @include('includes.css')

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top" style="background-color: #2d302fff;">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.webp" alt=""> -->
                <i class="bi bi-buildings"></i>
                <h1 class="sitename">Academy Plus</h1>
            </a>
            <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <!-- /Hero Section -->

        <!-- About Section -->
        <!-- /About Section -->




        <!-- 🌟 SECTION 3 : Avantages -->
        <section id="stats" class="stats section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-center mb-4 fw-semibold">Pourquoi choisir Academy Plus ?</h3>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="achievements-gallery" data-aos="fade-up" data-aos-delay="700">
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="achievement-item">
                                        <img src="assets/img/education/education-1.webp" alt="Achievement"
                                            class="img-fluid">
                                        <div class="achievement-content">
                                            <h4>📊 Tableau de bord clair et intuitif.</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel
                                                ultricies
                                                magna.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="achievement-item">
                                        <img src="assets/img/education/education-2.webp" alt="Achievement"
                                            class="img-fluid">
                                        <div class="achievement-content">
                                            <h4>💰 Gestion simplifiée des paiements et scolarité.</h4>
                                            <p>Maecenas finibus convallis turpis, non facilisis justo egestas in. Nulla
                                                facilisi.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="achievement-item">
                                        <img src="assets/img/education/education-3.webp" alt="Achievement"
                                            class="img-fluid">
                                        <div class="achievement-content">
                                            <h4>⚙️ Administration centralisée et fluide.</h4>
                                            <p>Fusce consectetur, enim eget aliquet volutpat, lacus nulla semper velit,
                                                et
                                                luctus.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="achievement-item">
                                        <img src="assets/img/education/education-3.webp" alt="Achievement"
                                            class="img-fluid">
                                        <div class="achievement-content">
                                            <h4>📱Accessible depuis tout appareil.</h4>
                                            <p>Fusce consectetur, enim eget aliquet volutpat, lacus nulla semper velit,
                                                et
                                                luctus.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /Avantages Section -->


        <!-- Featured Programs Section -->
        @include('public.includes.featured-programs')
        <!-- /Featured Programs Section -->

        <!-- Students Life Block Section -->
        <!-- /Students Life Block Section -->

        <!-- Testimonials Section -->
        <!-- /Testimonials Section -->

        <!-- Stats Section -->
        <!-- /Stats Section -->

        <!-- Recent News Section -->
        <!-- /Recent News Section -->

        <!-- Events Section -->
        <!-- /Events Section -->

    </main>

    <footer id="footer" class="footer position-relative dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">NiceSchool</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Hic solutasetp</h4>
                    <ul>
                        <li><a href="#">Molestiae accusamus iure</a></li>
                        <li><a href="#">Excepturi dignissimos</a></li>
                        <li><a href="#">Suscipit distinctio</a></li>
                        <li><a href="#">Dilecta</a></li>
                        <li><a href="#">Sit quas consectetur</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Nobis illum</h4>
                    <ul>
                        <li><a href="#">Ipsam</a></li>
                        <li><a href="#">Laudantium dolorum</a></li>
                        <li><a href="#">Dinera</a></li>
                        <li><a href="#">Trodelas</a></li>
                        <li><a href="#">Flexo</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">MyWebsite</strong> <span>All Rights
                    Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    @include('includes.js')
</body>

</html>