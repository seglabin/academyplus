@extends('layout', ["page_title" => Session('title'), "bg_title" => Session('bg')])
@section('content')

    <style>
        .button-container {
            display: flex;
            margin: 0 10px;
            /* Espacement entre les boutons */
            /* justify-content: center; */
            /* Alignement horizontal au centre */
            /* Ou, pour espacer les boutons :
                                                                 justify-content: space-around;
                                                                 justify-content: space-between;
                                                                 justify-content: space-evenly;
                                                              */
        }

        .button-container a {
            margin: 0 10px;
            /* Espacement entre les boutons */
        }

        .menuabonne {

            /* padding: 5px; */
            /* height: 30px; */
        }

        .m1 {
            width: 100%;
            /* height: 60px; */
            /* background-color:aquamarine; */
            background-image: url({{ asset('assets/img/slide/bg0.jpg')}} );
        }

        .active {
            color: white;
            bg-success;
        }


        .m2 {
            display: flex;
            align-items: center;
            /* Centre verticalement les éléments enfants */
            justify-content: center;
            /* Centre horizontalement les éléments enfants */
            /* height: 200px; Hauteur de la div conteneur, à adapter */
        }

        .btnm {
            /* Ajoutez ici les styles de vos boutons */
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .m {
            padding: none;
            margin: 4px;
        }
    </style>


    <!-- <section id="listeAbonne" class=" section "> -->
    @php

        $donnee = array();
        $vue = '';
        $actAppr = '';
        $actInscrip = '';
        $actPaiement = '';
        $actCompo = '';
        $caspage = 'listeC';
        $lecas = 'liste';
        $menusUser = (session('menusUser') != null) ? session('menusUser') : null;


        $module = (session('module') != null) ? session('module') : 'listeClasse';
        $idanEncours = (session('idanEncours') != null) ? session('idanEncours') : null;
        $idclasEncours = (session('idclassannescosEncours') != null) ? session('idclassannescosEncours') : null;
        $idabonnementEncours = (session('idabonnementEncours') != null) ? session('idabonnementEncours') : null;
        switch ($module) {
            case 'listeApprenant':
                $vue = 'Abonnes.liste';
                $lecas = "Liste des apprenants";
                $actAppr = 'active';
                break;

            case 'inscriptionAbonne':
                $vue = 'Abonnes.inscriptionAbonne';
                $lecas = "Inscription d'un apprenant";
                $actInscrip = 'active';
                break;

            case 'paiementAbonne':
                $vue = 'Abonnes.paiementAbonne';
                $lecas = "Enregistrement de paiement d'un apprenant";
                $actPaiement = 'active';
                break;

            case 'compositionAbonne':
                $vue = 'Abonnes.compositionAbonne';
                $lecas = "Enregistrement de composition au primaire";
                $actCompo = 'active';
                break;

            case 'listePaiementAbonnement':
                $vue = 'Abonnes.liste';
                $lecas = "Liste des paiements";
                $actPaiement = 'active';
                $modAjout = "paiementAbonne";
                break;

            case 'listeCompositionAbonne':
                $vue = 'Abonnes.liste';
                $lecas = "Liste des compositions au primaire";
                $modAjout = "compositionAbonne";
                $actCompo = 'active';
                break;
        }



    @endphp

    <div class="container-fluid mt-3">

        <div class=" panel panel-success setup-content active ">
            <!-- <form action="" id="formClasse" name="formClasse" method="get"> -->
            <input type="hidden" id="module" name="module" value="{{ $module }}">
            <!-- <input type="hidden" id="module" name="module" value=""> -->
            <div class="m">
                <div class="row ">
                    <div class="col-md-1 m">
                        <a class="btn btn-outline-success btnarrondi {{ $actAppr }}" href="#"
                            onclick="module('listeApprenant');"></i>
                            Apprenants</a>
                    </div>
                    @if(is_array($menusUser) && in_array(26, $menusUser))
                        <div class="col-md-1 m">
                            <a class="btn btn-outline-success btnarrondi {{ $actInscrip }}" href="#"
                                onclick="module('inscriptionAbonne');"></i>
                                Inscription</a>
                        </div>
                    @endif
                    @if(is_array($menusUser) && in_array(9, $menusUser))
                        <div class="col-md-1 m">
                            <a class="btn btn-outline-success btnarrondi {{ $actPaiement }} " href="#"
                                onclick="module('listePaiementAbonnement');"></i>
                                Paiements</a>
                        </div>
                    @endif
                    @if(is_array($menusUser) && (in_array(7, $menusUser) || in_array(8, $menusUser)))
                        <div class="col-md-1 m">
                            <a class="btn btn-outline-success btnarrondi {{ $actCompo }} " href="#"
                                onclick="module('listeCompositionAbonne');"></i>
                                Evaluations</a>
                        </div>
                    @endif
                    @if(is_array($menusUser) && in_array(27, $menusUser))
                        <div class="col-md-1 m">
                            <!-- <a class="btn btn-outline-success btnarrondi " href="#" onclick="module('moyenneApprenant');"></i>
                                    Moyennes</a> -->
                        </div>
                    @endif

                    <div class="col-md-1 m">
                        <a class="btn btn-outline-success btnarrondi {{ $actCompo }} " href="#"
                            onclick="imprimer('{{ $module }}');"> <i class="bi bi-print"> </i>
                            Imprimer</a>
                    </div>
                </div>
            </div>
            @if (in_array($module, array('listePaiementAbonnement', 'listeCompositionAbonne')))
                <div class="m">
                    @if(is_array($menusUser) && (in_array(1, $menusUser) || in_array(28, $menusUser)))
                        <div class="card-tools" style="position:right;">
                            <a class="btn btn-outline-primary btnarrondi" href="#" onclick="module('{{ $modAjout }}');"
                                style="position:right;"> <i class="bi  bi-plus-circle"></i> Ajouter</a>
                        </div>
                    @endif
                </div>

            @endif
            @if ($vue != '')
                @include($vue)
            @endif
            <!-- </form> -->





        </div>
    </div>
    <!-- </section> -->
@endsection
<script>
    function imprimer() {
        document.forms["myform"].action = '/imprimer'; //'/' + lienSuppr + '/' + id;
        document.forms["myform"].method = 'GET';
        document.forms["myform"].submit();

    }

    function module(module) {

        // alert(document.getElementById('idclassannescosEncours').value);
        // document.getElementById('idclassannescosEncours').value = id;
        //alert(session('idclassannescosEncours'));
        $('#idenreg').val(0);
        document.forms["myform"].method = 'GET';
        document.getElementById('module').value = module;
        document.getElementById('myform').submit();
    }


    function supprimer(id, module, lienSuppr) { //alert(module + '  ' + lienSuppr);
        var rep = confirm("Voulez vous vraiment supprimer cet enregistrement?", okLabel = "oui");
        if (rep) {
            document.getElementById('module').value = module;//'listeApprenant';
            document.forms["myform"].action = '/' + lienSuppr + '/' + id; //'/supprimer-apprenant/' + id;
            document.forms["myform"].method = 'GET';
            document.forms["myform"].submit();
        }
    }

    function modifier(id, module) { //alert(id);
        $('#idenreg').val(id);
        $('#module').val(module);
        document.forms["myform"].method = 'GET';
        document.forms["myform"].action = '/classeAbonne';
        document.forms["myform"].submit();
    }

</script>