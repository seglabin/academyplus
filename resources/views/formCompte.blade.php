@php


$config = session('config') ? session('config') : '';
$lecas = "";
$lienAjout = "";
$lienModif = "";
$lienSuppr = "";

switch ($config) {
case 'utilisateur':
$lecas = ($lenregistrement) ? "Modification d'un utilisateur" : "Ajout d'un utilisateur";
break;

}

$a = ($lenregistrement) ? $lenregistrement : null;
$idenreg = $a != null? $a->id:'';
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'form', "lecas" => $lecas])

@section('content')

<!-- <form id='myform' action="" method="POST" enctype="multipart/form-data"> -->
@csrf

<input type="hidden" id='idenrega' name='idenrega' value="{{($a != null) ? $a->id : null}}">
<div class="row">
    @switch($config) 

    @case('utilisateur')
<div class="col-md-4 mb-2">
        <label class="lelabel" for="">Infos personnels</label>
      <div class="btn-group btn-group-toggle"  style="width:100%;">
      @php
        echo chargerCombo($personnes, 'id', 'libpersonne', 'idpersonne', 'Choisir une personne','','',($a != null) ? $a->idpersonne : old('idpersonne'));
        @endphp
    <a class="flex items-center text-danger" href="#" data-toggle="modal"
                               data-target="#modalPersonne"
                            title="Inscription "> <img src="{{asset('assets/img/favicon.png')}}"
                                                       alt="Ajouter une personne" style="width: 28px;  height: 28px;" /> </a>
       </div>
                                                       @include('includes.modalPersonne')
    </div>
    <div class="col-md-4 mb-2">
        <label class="lelabel" for="">Abonnements</label>
        @php
        echo chargerCombo($abonnements, 'id', 'designation', 'idabonnement', 'Choisir un abonnement','','',($a != null) ? $a->idabonnement : old('idabonnement'));
        @endphp
    </div>

    <div class="col-md-4 mb-2">
        <label class="lelabel" for="">Profil (*)</label>
        @php

        echo chargerCombo($roles, 'id', 'name', 'idrole', 'Choisir un profil','','',($a != null) ? $a->idrole : old('idrole'));
        @endphp
    </div>

    <div class="col-md-3 mb-2">
        <label class="lelabel" for="">Type d'utilisateur (*)</label>
        @php

        echo chargerCombo($typusers, 'id', 'libelle', 'idtypuser', "Choisir un type d'utilisateur",'','',($a != null) ? $a->idtypuser : old('idtypuser'));
        @endphp
    </div>

    

    <div class="col-md-3 mb-2">
        <label class=" lelabel" for="">Email</label>
        <input type="text" class="form-control rounded-4 @error('email') is-invalid @enderror"
               placeholder="Entrez l'email" onKeyup="" id="email" name="email"
               value="{{($a != null) ? $a->email : old('email')}}">
    </div>

    @if($idenreg =='')
    <div class="col-md-3 mb-2">
        <label class=" lelabel" for="">Identifiant d'accès (*)</label>
        <input type="text" class="form-control rounded-4 @error('login') is-invalid @enderror"
               placeholder="Entrez l'identifiant" onKeyup="enMinuscule('login')" id="login" name="login"
               value="{{($a != null) ? $a->login : old('login')}}">
    </div>
    <div class="col-md-3 mb-2">
        <label class=" lelabel" for="">Mot de passe (*)</label>
        <input type="password" class="form-control rounded-4 @error('password') is-invalid @enderror"
               placeholder="Entrez le mot de passe" id="password" name="password"
               value="{{($a != null) ? $a->password : old('password')}}">
    </div>
    @else 
    <input type="hidden" id='login' name='login' value="{{($a != null) ? $a->login : null}}">
    @endif


    @break

    @case('roles')
    @break

    @endswitch

</div>
<br>
<div class="mb-3 row d-flex justify-content-center">
    <div class="col-md-4"></div>
    <div class="col-md-2">
        <button type="button" class="btn btn-outline-info w-20 mr-auto btnarrondi "
                onclick="valider('{{ $config }}');">Enregistrer</button>
    </div>
    <div class="col-md-6"></div>

</div>
<!-- </form> -->

@endsection


<script>


    function valider(cas) {
    var chps = '';
    var labels = "";
    var act = '';
    var ok = true;
    switch (cas) {
    case 'utilisateur':
            // alert('Merci');
            chps = 'idrole|idtypuser';
    labels = "le profil|le type d'utilisateur";
    act = '/enregistrer-utilisateur';
    document.getElementById('idenreg').value = document.getElementById('idenrega').value;
    //alert(document.getElementById('idenreg').value);
    if (document.getElementById('idenreg').value == ''){
    chps += '|login|password';
    labels += "|l'identifiant|le mot de passe";
    }

    break;
    }

    if (controleVide(chps, labels)) {
    // alert(chps);
    document.forms["myform"].method = 'POST';
    document.forms["myform"].action = act;
    document.forms["myform"].submit();
    }
    }
</script>