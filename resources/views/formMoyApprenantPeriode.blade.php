@php


$config = session('config') ? session('config') : '';
$lecas = "";
$lienAjout = "";
$lienModif = "";
$lienSuppr = "";
$disabled = '';
$roleEncours = (session('roleEncours')!=null)? session('roleEncours'):null;

$codeRoleEncours = $roleEncours!= null?$roleEncours->code:null;

switch ($config) {
case 'moyenne-periode-apprenant':
$lecas =  "Moyenne d'un apprenant par session académique";
break;

}
//dd($donnees);
$a =  null;
//dd($leget );

$lib = "moyenne périodique de la  " ;
$lib .= (($laclassannesco!= null)?$laclassannesco->libclasse():'');
$lib .= " pour le ".infoTableParId('sessionacademiques',$idsession,'libelle').' ' ;
$lib .= " / ". (($lannesco!= null)?$lannesco->libannee():'');
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'liste', "lecas" => $lecas])

@section('content')

<!-- <form id='myform' action="" method="POST" enctype="multipart/form-data"> -->
@csrf
@if($config == 'moyenne-periode-apprenant')
<input type="hidden" id='idenreg1' name='idenreg1' value="{{$idenreg}}">
@endif
<div class="row">
    @switch($config) 


    @case('moyenne-periode-apprenant')
    @case('moyenne-generale-periode')
    @php
    $disabled = ($config =='moyenne-generale-periode')?'disabled':'';
    @endphp

    <div class="col-md-3 mb-2">
        <label class="lelabel" for="">Abonnements</label>
        @php    
        if(in_array($codeRoleEncours,array('ADMIN')))  { 

        echo chargerCombo($abonnements, 'id', 'designation', 'idabonnement', 'Choisir un abonnement','',"onChangeGet('$config')",$idabonnement);
        }else{
        @endphp
        <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnementEncours}}">
        <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
               value="{{$abonnementEncours->designation }}">
        @php
        }        
        @endphp
    </div>

    <div class="col-md-2 mb-2">
        <label class="lelabel" for="">Année scolaire </label>
        @php              
        echo chargerCombo($annescolaires, 'id', 'libannee', 'idanneescolaire', 'Choisir une année scolaire','',"onChangeGet('$config')",$idanneescolaire);
        @endphp
    </div>

    <div class="col-md-2 mb-2">
        <label class="lelabel" for="">Classe Année scolaire</label>
        @php              
        echo chargerCombo($classannescos, 'id', 'libclasse', 'idclassannesco', 'Choisir une année scolaire','',"onChangeGet('$config')",$idclassannesco);
        @endphp
    </div>

    <div class="col-md-2 mb-2">
        <label class="lelabel" for="">Session académique</label>
        @php              
        echo chargerCombo($sessionacad, 'id', 'libelle', 'idsession', 'Choisir une session académique','',"onChangeGet('$config')",$idsession);
        @endphp
    </div>
    @if($config == 'moyenne-periode-apprenant')     
    <input type="hidden" id='majMoyperiod' name='majMoyperiod' value="0">
    <input type="hidden" id='iddetailsmoyenne' name='iddetailsmoyenne' value="{{ $iddetailsmoyenne }}">   
    <div class="col-md-3 mb-2">
        <label class="lelabel" for="">Apprenant (*) </label>
        @php              //
        echo chargerCombo($apprenants, 'id', 'libapprenant', 'idinscription', 'Choisir un apprenant','',"onChangeGet('$config')",$idinscription);
        @endphp
    </div>
    @endif
    @php



    @endphp


    <!--<div class="col-md-12 mb-2">-->
        <div class="col-md-9 mb-2">
            <label class=" lelabel" for="">Libellé</label>
            <input type="text" {{ $disabled }} readonly class="form-control rounded-4 "
                   id="libelle" name="libelle"
                   value="{{strtoupper(($lib))}}">
        </div>
        <div class="col-md-3 mb-2"> 
           
        </div>
        <br>
    <!--</div>-->
    <div class="col-md-12 mb-2">
        @php

        @endphp

        @if($config =='moyenne-periode-apprenant')
        @include('includes.tabloMoyPeriodApprenant')
        @endif
        @if($config =='moyenne-generale-periode')
        @include('includes.tabloMoyGeneralePeriode')
        @endif

    </div>
    @php
    //$config = 'moyenne-periode';
    @endphp
    @break

    @endswitch
    @if($disabled == '')

    <br>
    <div class="mb-3 row d-flex justify-content-center">
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-info w-20 mr-auto btnarrondi "
                    onclick="valider('{{ $config }}');">Enregistrer</button>
        </div>
        <div class="col-md-6"></div>

    </div>
    @endif    
</div>

@endsection


<script>
    function majMoyperiode() {
    // alert(23);
    $('#majMoyperiod').val(1);
    }

    function valider(cas) {
    var chps = '';
    var labels = "";
    var act = '';
    var ok = true; idenreg1
            document.getElementById('idenreg').value = document.getElementById('idenreg1').value;
    switch (cas) {
    case 'moyenne-periode-apprenant':
            chps = 'idsession|idinscription';
    labels = "La session académique|l'apprenant ";
    act = '/enregistrer-moyenne-periode-apprenant';
    break;
    }

    if (controleVide(chps, labels)) {
    // alert(act);
    document.forms["myform"].method = 'POST';
    document.forms["myform"].action = act;
    document.forms["myform"].submit();
    }
    }

    function actualiseMoyenne() {
    let n = document.getElementById('taille').value;
    let somcoef = 0;
    let somMoy = 0;
    for (let i = 0; i < n; i++) {
    let moycoef = parseFloat($('#moy' + i).val()) * parseFloat($('#coef' + i).val());
    $('#moycoef' + i).val(moycoef.toFixed(2));
    somcoef += parseFloat($('#coef' + i).val());
    somMoy += moycoef;
    }
// alert(somMoy + '  ' + somcoef);
    let moy = somcoef > 0? (somMoy / somcoef): - 1;
    $('#total').val(somMoy.toFixed(2));
    $('#moyperiod').val(moy.toFixed(2));
    }


function lancherPDF() {
    let fichier = 'print/impression.php';
    // alert('Merci Seigneur Jésus!');
    window.open(fichier, '_blank');

}
</script>