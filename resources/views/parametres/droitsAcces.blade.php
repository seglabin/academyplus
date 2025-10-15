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
        background-image: url({{ asset('assets/img/slide/bg0.jpg')}}
    );
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



$module = (session('module') != null) ? session('module') : 'listeProfil';
$idanEncours = (session('idanEncours') != null) ? session('idanEncours') : null;
$idclasEncours = (session('idclassannescosEncours') != null) ? session('idclassannescosEncours') : null;
$idabonnementEncours = (session('idabonnementEncours') != null) ? session('idabonnementEncours') : null;
switch ($module) {
case 'listeProfil':                
$lecas = "Gestion des droits d'accès par profil";
break;
case 'adddroitacces':                
$lecas = "Ajout des droits d'accès à : ".($lenregistrement!=null?$lenregistrement->name:'');
break;
case 'detailsdroitacces':                
$lecas = "Liste des droits d'accès du profil : ".($lenregistrement!=null?$lenregistrement->name:'');
break;
}
//dd($module);   adddroitacces  detailsdroitacces
$n = 0;


@endphp

<div class="container-fluid mt-3">

    <div class=" panel panel-success setup-content active ">
        <input type="hidden" id="module" name="module" value="{{ $module }}">
        <div class="row"> 
       @if (in_array($module,array('adddroitacces','detailsdroitacces')))
        <div class="col-md-2 m">
            <div class="card-tools" style="position:left;">
                <a class="btn btn-primary btnarrondi" href="#" onclick="afficheDroitAcces();"
                   style="position:right;"> <i class="bi bi-arrow-left-circle"></i> Retour</a>
            </div>
        </div>
        @endif

        @if ( $module =='adddroitacces')
        <div class="col-md-4 m">
            @if(is_array($menusUser) && in_array(1, $menusUser))
            <div class="card-tools" style="position:right;">
                <a class="btn btn-outline-success btnarrondi" href="#" onclick="validerDroitacces('{{ $idenreg }}', 'adddroitacces');"
                   style="position:right;"> <i class="bi  bi-plus-circle"></i> Valider les valeurs cochées</a>
            </div>
        @endif
        </div>
        @endif
        @if ( $module =='detailsdroitacces')
        <div class="col-md-4 m">
            @if(is_array($menusUser) && in_array(2, $menusUser))
            <div class="card-tools" style="position:right;">
                <a class="btn btn-outline-warning btnarrondi" href="#" onclick="validerDroitacces('{{ $idenreg }}', 'retraitdroitacces');"
                   style="position:right;"> <i class="bi  bi-plus-circle"></i> Retirer les valeurs cochées</a>
            </div>
            @endif
        </div>
        @endif
        </div>
        @switch($module)
        @case('listeProfil')
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>Profils</strong></th> 
                        <th style="width: 95px"><strong>Action</strong></th>
                    </tr>  
                </thead>
                <tbody>
                    @foreach ($donnees as $i => $d)
                    <tr>
                        <td>{{$d->name}}</td>
                        <td> 
                                    <div class="flex justify-center items-center">
                                        @if(is_array($menusUser) && in_array(1, $menusUser))
                                        <a class="flex items-center mr-3" onclick="module('adddroitacces','{{  $d->id }}');" href="#" title="Attribuer droits"><i class="bi  bi-plus-circle"></i> </a>                                                
                                        @endif
                                        <a class="flex items-center mr-3" onclick="module('detailsdroitacces','{{  $d->id }}');" href="#" title="Voir détails "><i class="bi  bi-eye"></i> </a>                                                
                                        
                                            </div>
                                </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
        @break
        @case('adddroitacces')
        @case('detailsdroitacces')
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>N°</strong></th> 
                        <th><strong>Fonctionnalité</strong></th> 
                        <th><strong>Description</strong></th> 
                        <th style="width: 120px"><strong for="chktout">Cocher tous <input onclick="cocherTout();" type="checkbox" name="chktout" id="chktout" value="0"> </strong></th>
                    </tr>  
                </thead>
                <tbody>
                    @foreach ($donnees as $i => $d)
                    <tr>
                        <td>{{$i +1}}</td>
                        <td>{{$d->libelle}}</td>
                        <td>{{$d->description}}</td>
                        <td> 
                                    <div class="flex justify-center items-center">
                                        <input id="idpermission{{ $i }}" name="idpermission{{ $i }}" type="hidden" value="{{ $d->id }}">
                                        <input onclick="cocher({{ $i }});" type="checkbox" name="chk{{ $i }}" id="chk{{ $i }}" value="0">
                                    </div>
                                </td>
                    </tr>
                    @php $n++; @endphp
                    @endforeach

                </tbody>
            </table> 
            <input id="taille" name="taille" type="hidden" value="{{ $n }}">
        </div>
        @break
        @endswitch

    </div>
</div>
<!-- </section> -->
@endsection

<script>
function cocher(i) {
    let v = document.getElementById('chk'+i).checked;
    $('#chk'+i).val(v);
    // alert(eta);
}

function cocherTout() {
    let v = document.getElementById('chktout').checked;
    let n = document.getElementById('taille').value;
    for (let i = 0; i < n; i++) {
        $('#chk'+i).val(v);
        document.getElementById('chk'+i).checked = v;        
    }
    
}

    function module(module,id) {
    
    $('#idenreg').val(id);
    document.forms["myform"].method = 'GET';
    document.getElementById('module').value = module;
    document.getElementById('myform').submit();
    }


    function supprimer(id, module, lienSuppr) { //alert(module + '  ' + lienSuppr);
    var rep = confirm("Voulez vous vraiment supprimer cet enregistrement?", okLabel = "oui");
    if (rep) {
    document.getElementById('module').value = module; //'listeApprenant';
    document.forms["myform"].action = '/' + lienSuppr + '/' + id; //'/supprimer-apprenant/' + id;
    document.forms["myform"].method = 'GET';
    document.forms["myform"].submit();
    }
    }

    function validerDroitacces(id, module) { //alert(id);
    $('#idenreg').val(id);
    $('#module').val(module);
    document.forms["myform"].method = 'GET';
    document.forms["myform"].action = '/valider-droitsAcces';
    document.forms["myform"].submit();
    }

</script>