@php


$config = session('config') ? session('config') : '';
$lecas = "";
$lienAjout = "";
$lienModif = "";
$lienSuppr = "";

switch ($config) {
case 'classannesco':
$lecas = ($lenregistrement) ? "Modification d'une classe pour une année scolaire" : "Ajout d'une classe pour une année scolaire";
break;
case 'coefficient':
$lecas = ($lenregistrement) ? "Modification d'un coefficient" : "Ajout d'un coefficient";
break;
case 'paramfrais':
$lecas = ($lenregistrement) ? "Modification d'un paramétrage de frais" : "Ajout d'un paramétrage de frais";
break;

}

$a = ($lenregistrement) ? $lenregistrement : null;
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'form', "lecas" => $lecas])

@section('content')

<!-- <form id='myform' action="" method="POST" enctype="multipart/form-data"> -->
    @csrf

    <input type="hidden" id='idenreg' name='idenreg' value="{{($a != null) ? $a->id : null}}">
    <div class="row">
        @switch($config) 

        @case('classannesco')

        <div class="col-md-4 mb-2">
            <label class=" lelabel" for="">Abonnement</label>
            <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
            <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                   value="{{$labonnement->designation }}">
        </div>
        <div class="col-md-4 mb-2">
            <input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanneescolaire}}">
            <label class=" lelabel" for="">Année scolaire</label>
            <input type="text" disabled class="form-control rounded-4 @error('lannesco') is-invalid @enderror"
                   value="{{($lannesco!= null)?$lannesco->libannee():'' }}">
        </div>
        

        <div class="col-md-4 mb-2">
            <label class="lelabel" for="">Classe type (*)</label>
            @php              
            echo chargerCombo($classetypes, 'id', 'libelle', 'idclasse', 'Choisir une classe type','','',($a != null) ? $a->idclasse : old('idclasse'));
            @endphp
        </div>                

        <div class="col-md-2 mb-2">
            <label class=" lelabel" for="">Groupe</label>
            <input type="text" class="form-control rounded-4 "
                   placeholder="Entrez le groupe" onKeyup="enMajuscule('groupe');" id="groupe" name="groupe"
                   value="{{($a != null) ? $a->groupe : old('groupe')}}">
        </div>

        @break


        @case('abonnement')
        <div class="col-md-10 mb-2">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Départements</label>
                    @php
                    echo chargerCombo($departemsnts, 'id', 'libelle', 'iddepartement', 'Choisir un département','','changeLocalite();',$iddepartement);
                    @endphp
                </div>

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Communes</label>
                    @php
                    echo chargerCombo($communes, 'id', 'libelle', 'idCommune', 'Choisir une commune','','changeLocalite();',$idCommune);
                    @endphp
                </div>

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Arrondissements</label>
                    @php
                    echo chargerCombo($arronds, 'id', 'libelle', 'idarrond', 'Choisir un arrondissement','','changeLocalite();',$idarrond);
                    @endphp
                </div>

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Localités (*)</label>
                    @php
                     $idlocalite =($a != null)? $a->idlocalite:'';
                    echo chargerCombo($quartiers, 'id', 'libelle', 'idlocalite', 'Choisir une localité','','',$idlocalite);
                    @endphp
                </div>

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Secteurs (*)</label>
                    @php
                    
                     $idsecteur = ($a != null)?$a->idsecteur:'';
                    echo chargerCombo($secteurs, 'id', 'libelle', 'idsecteur', 'Choisir un secteur','','',$idsecteur);
                    @endphp
                </div>

                <div class="col-md-6 mb-2">
                    <label class=" lelabel" for="">Désignation (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez la désignation" onKeyup="enMajuscule('designation');" id="designation" name="designation"
                           value="{{($a != null) ? $a->designation : old('designation')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Contact (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez le contact" onKeyup="typetelephone(this);" id="contact" name="contact"
                           value="{{($a != null) ? $a->contact : old('contact')}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Identifiant d'accès (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez l'identifiant" onKeyup="enMinuscule('identifiant')" id="identifiant" name="identifiant"
                           value="{{($a != null) ? $a->identifiant : old('identifiant')}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Email</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez l'email" onKeyup="" id="email" name="email"
                           value="{{($a != null) ? $a->email : old('email')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Date d'expiration</label>
                    <input type="date" class="form-control rounded-4 "
                           placeholder="Entrez la date d'expiration" onKeyup="" id="datexpiration" name="datexpiration"
                           value="{{($a != null) ? $a->datexpiration: old('datexpiration')}}">
                </div>
                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Titre du signataire</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez le titre du signataire" onKeyup="enMajuscule('titredirecteur',1);" id="titredirecteur" name="titredirecteur"
                           value="{{($a != null) ? $a->titredirecteur : old('titredirecteur')}}">
                </div>
                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Le Directeur/La Directrice</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez les infos du signataire" onKeyup="enMajuscule('directeur',1);" id="directeur" name="directeur"
                           value="{{($a != null) ? $a->directeur : old('directeur')}}">
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">

            <div class="control-group "> 
                <div class="form-group" >
                    <label ><strong>Logo abonné </strong></label>
                    <div class="control-group "> 
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="  fileupload-preview thumbnail " style="width: 120px; height: 120px;">
                                <img src="{{ asset($photo)}}" />                                                       
                            </div>
                            <div>
                                <?php if ($photo != '') { ?>
                                    <span class="btn btn-file btn-small btn-warning"><span class="fileupload-new"><i class="bi bi-camera-fill icon-white"></i></span> 
                                    <?php } else { ?>
                                        <span class="btn btn-file btn-small btn-success" title="Choisir"><span class="fileupload-new"><i class="bi bi-camera"></i></span> 
                                        <?php } ?>
                                        <span class="fileupload-exists btn-small btn-warning" title="Changer"><i class="bi bi-camera"></i></span><input type="file" name="logo" id="logo" value="{{($a != null) ? $a->logo : old('logo')}}" /></span>
                                    <span class="btn btn-small btn-danger " data-dismiss="fileupload" title="Supprimer"> <i class="bi bi-trash"></i></span> 
                            </div>
                        </div>
                    </div>
                </div>                                                 
            </div>
        </div>
        @break

        @case('coefficient')
        @php
        $lienchg = $idenreg == null?'ajout-coefficient':''; //
        @endphp
                <div class="col-md-4 mb-2">
                    <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
                    <label class=" lelabel" for="">Abonnement</label>
                    <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                    value="{{$labonnement->designation }}">
                </div>
                
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Classe (*)</label>
                    @php
                    $idclasse = (session('idclasSel') != null) ? session('idclasSel'):(($a != null)?$a->idclasse:old('idclasse'));
                     //$idclasse = ($a != null)?$a->idclasse:old('idclasse');
                    echo chargerCombo($classetypes, 'id', 'libelle', 'idclasse', 'Choisir une classe','',"onChangeGet('$lienchg')",$idclasse);
                    @endphp
                </div>                
               

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Type de Matière (*)</label>
                    @php
                     $idtypematiere = ($a != null)?$a->idtypematiere:old('idtypematiere');
                    echo chargerCombo($typematieres, 'id', 'libelle', 'idtypematiere', 'Choisir un type de matière','','',$idtypematiere);
                    @endphp
                </div>                
               
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Matière (*)</label>
                    @php
                     $idmatiere = ($a != null)?$a->idmatiere:old('idmatiere');
                    echo chargerCombo($matieres, 'id', 'libelle', 'idmatiere', 'Choisir une matière','','',$idmatiere);
                    @endphp
                </div>                
               
                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Coefficient (*)</label>
                    <input type="number" class="form-control rounded-4 "
                           placeholder="Entrez le coefficient" id="coef" name="coef"
                           value="{{($a != null) ? $a->coef : 1}}">
                </div>
               
                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Ordre sur le bulletin </label>
                    <input type="number" class="form-control rounded-4 "
                           placeholder="Entrez l'ordre" id="rang" name="rang"
                           value="{{($a != null) ? $a->rang : old('rang')}}">
                </div>

        @break

        @case('paramfrais')
        
                <div class="col-md-4 mb-2">
                    <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
                    <label class=" lelabel" for="">Abonnement</label>
                    <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                           value="{{$labonnement->designation }}">
                </div>
        
                <div class="col-md-4 mb-2">
                    <input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanneescolaire}}">
                    <label class=" lelabel" for="">Année scolaire</label>
                    <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                           value="{{$lannesco->libannee() }}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Classe (*)</label>
                    @php
                     $idclasse = ($a != null)?$a->idclassetype:old('idclassetype');
                    echo chargerCombo($classetypes, 'id', 'libelle', 'idclassetype', 'Choisir une classe','','',$idclasse);
                    @endphp
                </div>                
               

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Frais de scolarité (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Frais de scolarité" onkeyup="typemontant(this);" id="fraiscolarite" name="fraiscolarite"
                           value="{{($a != null) ? $a->fraiscolarite : old('fraiscolarite')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Frais d'inscription (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Frais d'inscription" onkeyup="typemontant(this);" id="fraisinscrip" name="fraisinscrip"
                           value="{{($a != null) ? $a->fraisinscrip : old('fraisinscrip')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Frais de réinscription (*)</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Frais de réinscription" onkeyup="typemontant(this);" id="fraisreinscrit" name="fraisreinscrit"
                           value="{{($a != null) ? $a->fraisreinscrit : old('fraisreinscrit')}}">
                </div>
               

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Tranche à l'inscription</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Tranche à l'inscription" onkeyup="typemontant(this);" id="trancheinscrip" name="trancheinscrip"
                           value="{{($a != null) ? $a->trancheinscrip : old('trancheinscrip')}}">
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">1ère Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="1ère Tranche" onkeyup="typemontant(this);" id="tranchecheance1" name="tranchecheance1"
                                value="{{($a != null) ? $a->tranchecheance1 : old('tranchecheance1')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">1ère Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance1" name="echeance1"
                                value="{{($a != null) ? $a->echeance1 : old('echeance1')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">2ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="2ème Tranche" onkeyup="typemontant(this);" id="tranchecheance2" name="tranchecheance2"
                                value="{{($a != null) ? $a->tranchecheance2 : old('tranchecheance2')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">2ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance2" name="echeance2"
                                value="{{($a != null) ? $a->echeance2 : old('echeance2')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">3ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="3ème Tranche" onkeyup="typemontant(this);" id="tranchecheance3" name="tranchecheance3"
                                value="{{($a != null) ? $a->tranchecheance3 : old('tranchecheance3')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">3ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance3" name="echeance3"
                                value="{{($a != null) ? $a->echeance3 : old('echeance3')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">4ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="4ème Tranche" onkeyup="typemontant(this);" id="tranchecheance4" name="tranchecheance4"
                                value="{{($a != null) ? $a->tranchecheance4 : old('tranchecheance4')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">4ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance4" name="echeance4"
                                value="{{($a != null) ? $a->echeance4 : old('echeance4')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">5ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="5ème Tranche" onkeyup="typemontant(this);" id="tranchecheance5" name="tranchecheance5"
                                value="{{($a != null) ? $a->tranchecheance5 : old('tranchecheance5')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">5ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance5" name="echeance5"
                                value="{{($a != null) ? $a->echeance5 : old('echeance5')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">6ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="6ème Tranche" onkeyup="typemontant(this);" id="tranchecheance6" name="tranchecheance6"
                                value="{{($a != null) ? $a->tranchecheance6 : old('tranchecheance6')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">6ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance6" name="echeance6"
                                value="{{($a != null) ? $a->echeance6 : old('echeance6')}}">
                        </div>
                    </div>
                </div>

                <div class=" col-md-4 mb-2 " >
                    <div class="row cadreTranche" >
                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">7ème Tranche</label>
                            <input type="text" class="form-control rounded-4 "
                                placeholder="7ème Tranche" onkeyup="typemontant(this);" id="tranchecheance7" name="tranchecheance7"
                                value="{{($a != null) ? $a->tranchecheance7 : old('tranchecheance7')}}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class=" lelabel" for="">7ème Echéance</label>
                            <input type="date" class="form-control rounded-4 "
                                id="echeance7" name="echeance7"
                                value="{{($a != null) ? $a->echeance7 : old('echeance7')}}">
                        </div>
                    </div>
                </div>

               
        @break


        @endswitch

    </div>
    <br>
    <div class="mb-3 row d-flex justify-content-center">
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-info w-20 mr-auto btnarrondi "
                    onclick="valider('{{ $config }}');">Enregistrerss</button>
        </div>
        <div class="col-md-6"></div>

    </div>
<!-- </form> -->

@endsection


<script>

function changeLocalite() {
    document.forms["myform"].method = 'GET';
    document.forms["myform"].submit();
}

    function valider(cas) { //alert(cas);
    var chps = '';
    var labels = "";
    var act = '';
    var ok = true;
    switch (cas) {
    case 'classannesco':
            chps = 'idabonnement|idanneescolaire|idclasse';
    labels = "l'abonnement|l'année scolaire|la classe type";
    act = '/enregistrer-classannesco';
    break;
    case 'abonnement':   
                //alert('Merci');
                chps = 'idlocalite|idsecteur|designation|contact|identifiant';  
                labels = "la localité|le secteur|la désignation|le contact|l'identifiant";  
                //  chps = '';labels = '';
                act = '/enregistrer-abonnement';                         
                break;
    case 'coefficient':
            chps = 'idabonnement|idclasse|idmatiere';
    labels = "l'abonnement|la classe type|la matière";
    act = '/enregistrer-coefficient';
    break;
    case 'paramfrais':
        chps = 'idabonnement|idanneescolaire|idclassetype|fraiscolarite';
        labels = "l'abonnement|l'année scolaire|la classe type|Frais de scolarité";
        // alert(chps);
    act = '/enregistrer-paramfrais';
    break;
    }

    if (controleVide(chps, labels)) {
    //  alert(chps);
        //fraiscolarite	fraisinscrip	fraisreinscrit	trancheinscrip	tranchecheance1	
                // tranchecheance2	tranchecheance3	tranchecheance4	tranchecheance5	tranchecheance6	
                // tranchecheance7	echeance1	echeance2	echeance3	echeance4	echeance5	
    if(cas =='paramfrais'){
        var fraisco = parseInt(sansEspace($('#fraiscolarite').val()));
         
        var tot = parseInt(sansEspace($('#trancheinscrip').val())) + parseInt(sansEspace($('#tranchecheance1').val()));
        tot += parseInt(sansEspace($('#tranchecheance2').val())) + parseInt(sansEspace($('#tranchecheance3').val()));
        tot += parseInt(sansEspace($('#tranchecheance4').val())) + parseInt(sansEspace($('#tranchecheance5').val()));
        tot += parseInt(sansEspace($('#tranchecheance7').val())) + parseInt(sansEspace($('#tranchecheance7').val()));
        if (fraisco != tot) {
            alert("la répartition des frais " + tot + " est différente  du frais de scolarité " + fraisco);
            ok = false;
        }
    }

        if(ok){
            document.forms["myform"].method = 'POST';
            document.forms["myform"].action = act;
            document.forms["myform"].submit();
        }
    }
    }
</script>