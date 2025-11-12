@extends('layout', ["page_title" => Session('title'), "bg_title" => Session('bg')])
@section('content')
    <section id="hero" class="hero section dark-background">
<style>
    .titreabon{
        font-size: 40px;
        font-style:oblique;
        font-weight:850;
    }
</style>
        @php
            $anEncours = (session('anEncours') != null) ? session('anEncours') : null;
            $abonnementEncours = (session('abonnementEncours') != null) ? session('abonnementEncours') : null;
            $img = ($abonnementEncours != null && $abonnementEncours->logo != null) ? $abonnementEncours->logo : null;
        @endphp
        <div class="hero-container">
            <video autoplay="" muted="" loop="" playsinline="" class="video-background">
                <source src="{{ asset('assets/img/education/video-2.mp4')}}" type="video/mp4">
            </video>
            <div class="overlay"></div>
            <div class="container">

                <div class="row hero-content" style="margin-top:none; ">
                    <div class="col-md-1">
                        @if($img != null)
                            <!-- <img src="assets/img/logo.webp" alt="KK"> -->
                            <img class="imgAbonne" src="{{ asset('storage/images/abonnements/'. $img )}} " alt="KK">
                        @else

                        @endif
                    </div>
                    <div class="col-md-9">
                        <h2 class="titreabon">{{ (($abonnementEncours)?$abonnementEncours->designation:'')  }}</h2>
                    </div>
                    <div class="col-md-2">
                        <span  class="btn btn-success">
                        <b>Année scolaire : </b> 
                         @csrf
                        @php       
                            $idanEncours = (session('idanEncours')!=null)? session('idanEncours'):null;
                            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
                            $annescolaires = collect(DB::select($rekan)); 
                            $config = "accueil";
                        echo chargerCombo($annescolaires, 'id', 'libannee', 'idanSela', 'Choisir une année scolaire','',"changeAnneeSel('$config')",$idanEncours);
                        @endphp                 
                    </span>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
                        <div class="hero-content">
                            <h1>Academy Plus</h1>
                            <p>Facilite la gestion de votre votre école</p>
                            <div class="cta-buttons">
                                <a href="#" class="btn-primary">Start Your Journey</a>
                                <a href="#" class="btn-secondary">Découvrir l'application</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
                        <div class="stats-card">
                            <div class="stats-header">
                                <h3>Fonctionnalités</h3>
                                <div class="decoration-line"></div>
                            </div>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h4>Evaluation</h4>
                                        <p>Graduate Employment</p>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h4>Paiements</h4>
                                        <p>International Partners</p>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h4>Inscription</h4>
                                        <p>Student-Faculty Ratio</p>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h4>120+</h4>
                                        <p>Degree Programs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="event-ticker">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-md-6 col-xl-4 col-12 ticker-item">
                        <span class="date">NOV 15</span>
                        <span class="title">Open House Day</span>
                        <a href="#" class="btn-register">Register</a>
                    </div>
                    <div class="col-md-6 col-12 col-xl-4  ticker-item">
                        <span class="date">DEC 5</span>
                        <span class="title">Application Workshop</span>
                        <a href="#" class="btn-register">Register</a>
                    </div>
                    <div class="col-md-6 col-12 col-xl-4 ticker-item">
                        <span class="date">JAN 10</span>
                        <span class="title">International Student Orientation</span>
                        <a href="#" class="btn-register">Register</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection