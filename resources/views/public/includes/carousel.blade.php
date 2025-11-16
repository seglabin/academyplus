<link rel="stylesheet" href="{{ asset('assets/decouvrir/bootstrap.min.css')}}"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

    <style>
        .titreslide{
            color: #f3f7f4ff;
            font-weight : 500;
            font-size: 40px;
        }

        .descriptionslide{
             color: #08905d;
             /* color: #f3f7f4ff; */
             text-align:left;
             font-size: 20px;
        }

        .divcaption{
             background-color: rgba(198, 197, 192, 0.8);
             /* background-color: rgba(0, 0, 0, 0.5); */
             padding: 10px;
             
        }
    </style>


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    <!-- Ajoutez d'autres indicateurs si nécessaire -->
  </ol>
  <div class="carousel-inner" >
    <div class="carousel-item active">
      <img class="d-block w-100" src="{{ asset('assets/decouvrir/img/tableau de bord.jpeg')}}" alt="Slide 1">
    <div class="carousel-caption d-none d-md-block divcaption">
                <div class="achievement-content">
                    <h4 class="titreslide">📊 Tableau de bord clair et intuitif.</h4>
                    <!-- <p> -->
                    <div class="key-highlights descriptionslide" >
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Naviguez facilement grâce à un tableau de bord clair et intuitif.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Visualisez vos statistiques, vos activités et vos performances en un seul regard.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Une interface pensée pour la simplicité et l’efficacité.</span>
                        </div>
                    </div>
                    <!-- </p> -->
                </div>

            </div>
    </div>

    <div class="carousel-item">
      <img class="d-block w-100" src="{{ asset('assets/decouvrir/img/gestion simplifie scolarite.jpeg')}}" alt="Slide 2">
   <div class="carousel-caption d-none d-md-block divcaption">
                <div class="achievement-content">
                    <h4 class="titreslide" >💰 Gestion simplifiée des paiements et scolarité.</h4>
                    <!-- <p> -->
                    <div class="key-highlights descriptionslide">
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Simplifiez la gestion des paiements et de la scolarité.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Suivez les frais, les reçus et les notifications en temps réel.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Un système sécurisé et automatisé pour une tranquillité d’esprit totale.</span>
                        </div>
                    </div>
                    <!-- </p> -->
                </div>

            </div>
    </div>

    <div class="carousel-item">
      <img class="d-block w-100" src="{{ asset('assets/decouvrir/img/administration.jpeg')}}" alt="Slide 3">
   <div class="carousel-caption d-none d-md-block divcaption">
                <div class="achievement-content">
                    <h4 class="titreslide">⚙️ Administration centralisée et fluide.</h4>
                    <!-- <p> -->
                    <div class="key-highlights descriptionslide" >
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Centralisez vos données et simplifiez votre gestion.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>L’administration devient fluide, rapide et connectée.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Tout ce dont vous avez besoin est désormais à portée de main.</span>
                        </div>
                    </div>
                    <!-- </p> -->
                </div>

            </div>
    </div>

    <div class="carousel-item">
      <img class="d-block w-100" src="{{ asset('assets/decouvrir/img/accessible.jpeg')}}" alt="Slide 4">
   <div class="carousel-caption d-none d-md-block divcaption">
                <div class="achievement-content">
                    <h4 class="titreslide">📱Accessible depuis tout appareil.</h4>
                    <!-- <p> -->
                    <div class="key-highlights descriptionslide" >
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Accédez à Academy Plus où que vous soyez.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Compatible avec tous vos appareils – ordinateur, tablette ou smartphone.</span>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Votre espace d’apprentissage, toujours disponible et connecté.</span>
                        </div>
                    </div>
                    <!-- </p> -->
                </div>

            </div>
    </div>
    <!-- Ajoutez d'autres diapositives ici -->
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Précédent</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Suivant</span>
  </a>
</div>



<script src="{{ asset('assets/decouvrir/jquery-3.2.1.slim.min.js')}}"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script> -->
<script src="{{ asset('assets/decouvrir/popper.min.js')}}"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script> -->
<script src="{{ asset('assets/decouvrir/bootstrap.min.js')}}"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script> -->