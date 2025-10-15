@php


    $config = session('config') ? session('config') : '';
    $lecas = "";
    $lienAjout = "";
    $lienModif = "";
    $lienSuppr = "";

    switch ($config) {
        case 'role':
            $lecas = ($lenregistrement) ? "Modification d'un profil utilisateur" : "Ajout d'un profil utilisateur";
            break;
        case 'permission':
            $lecas = ($lenregistrement) ? "Modification d'une fonctionnalité" : "Ajout d'une fonctionnalité";
            break;
        case 'matiere':
            $lecas = ($lenregistrement) ? "Modification d'une matière" : "Ajout d'une matière";
            break;
        case 'anneescolaire':
            $lecas = ($lenregistrement) ? "Modification d'une année scolaire" : "Ajout d'une année scolaire";
            break;
        case 'classetype':
            $lecas = ($lenregistrement) ? "Modification d'une classe type" : "Ajout d'une classe type";
            break;
        case 'abonnement':
            $lecas = ($lenregistrement) ? "Modification d'un abonnement" : "Ajout d'un abonnement";
            break;
        case 'personne':
            $lecas = ($lenregistrement) ? "Modification d'une personne" : "Ajout d'une personne";
            break;
        case 'session-academique':
            $lecas = ($lenregistrement) ? "Modification d'une session académique" : "Ajout d'une session académique";
            break;
        case 'element':
            $lecas = $titre;
            break;
    }

    $a = ($lenregistrement) ? $lenregistrement : null;
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'form', "lecas" => $lecas])

@section('content')

    <!-- <form id='myform' action="" method="GET" enctype="multipart/form-data"> -->
        @csrf

        <input type="hidden" id='idenreg' name='idenreg' value="{{($a != null) ? $a->id : null}}">
        <div class="row">
        @switch($config) 
            @case('role')
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Code (*)</label>
                    <input type="text" class="form-control rounded-4 @error('code') is-invalid @enderror"
                        onkeyup="enMajuscule('code',0)" placeholder="Entrez le code" id="code" name="code"
                        value="{{($a != null) ? $a->code : old('code')}}">
                </div>

                <div class="col-md-8 mb-2">
                    <label class=" lelabel" for="">Désignation (*)</label>
                    <input type="text" class="form-control rounded-4 @error('designation') is-invalid @enderror"
                        placeholder="Entrez la désignation" onKeyup="enMajuscule('name', 1);" id="name" name="name"
                        value="{{($a != null) ? $a->name : old('name')}}">
                </div>
            @break
            @case('permission')
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Libellé (*)</label>
                    <input type="text" class="form-control rounded-4"
                        onkeyup="enMajuscule('libelle',1)" placeholder="Entrez le libelle" id="libelle" name="libelle"
                        value="{{($a != null) ? $a->libelle : old('libelle')}}">
                </div>

                <div class="col-md-8 mb-2">
                    <label class=" lelabel" for="">Description</label>
                    <input type="text" class="form-control rounded-4 "
                        placeholder="Entrez la description" onKeyup="enMajuscule('description', 1);" id="description" name="description"
                        value="{{($a != null) ? $a->description : old('description')}}">
                </div>
            @break

            @case('classetype')
                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Niveau hiérarchique (*)</label>
               @php
               echo chargerCombo($niveaux, 'id', 'libelle', 'niveau', 'Choisir un niveau','','',($a != null) ? $a->niveau : old('niveau'));
               @endphp
                </div>

                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Secteur (*)</label>
               @php
               echo chargerCombo($secteurs, 'sigle', 'libelle', 'secteur', 'Choisir un secteur','','',($a != null) ? $a->secteur : old('secteur'));
               @endphp
                </div>

                <div class="col-md-6 mb-2">
                    <label class=" lelabel" for="">Désignation (*)</label>
                    <input type="text" class="form-control rounded-4 @error('libelle') is-invalid @enderror"
                        placeholder="Entrez la désignation" onKeyup="enMajuscule('libelle', 1);" id="libelle" name="libelle"
                        value="{{($a != null) ? $a->libelle : old('libelle')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Abréviation (*)</label>
                    <input type="text" class="form-control rounded-4 @error('sigle') is-invalid @enderror"
                        placeholder="Entrez le sigle" onKeyup="enMajuscule('sigle', 0);" id="sigle" name="sigle"
                        value="{{($a != null) ? $a->sigle : old('sigle')}}">
                </div>
            @break

            @case('session-academique')
        
                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Secteur (*)</label>
               @php
               echo chargerCombo($secteurs, 'id', 'libelle', 'idsecteur', 'Choisir un secteur','','',($a != null) ? $a->idsecteur : old('idsecteur'));
               @endphp
                </div>

                <div class="col-md-6 mb-2">
                    <label class=" lelabel" for="">Libellé (*)</label>
                    <input type="text" class="form-control rounded-4 @error('libelle') is-invalid @enderror"
                        placeholder="Entrez la désignation" onKeyup="enMajuscule('libelle', 0);" id="libelle" name="libelle"
                        value="{{($a != null) ? $a->libelle : old('libelle')}}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Rang (*)</label>
                    <input type="number" class="form-control rounded-4 @error('rang') is-invalid @enderror"
                        placeholder="Entrez le rang" id="rang" name="rang"
                        value="{{($a != null) ? $a->rang : old('rang')}}">
                </div>
            @break

            @case('anneescolaire')
                <div class="col-md-4 mb-2">
                    <label class="lelabel" for="">Année début (*)</label>
                    <input type="number" class="form-control rounded-4 @error('andebut') is-invalid @enderror"
                     placeholder="Entrez l'année de début" id="andebut" name="andebut"
                        value="{{($a != null) ? $a->andebut : old('andebut')}}" required>
                </div>

            @break

            @case('personne')
                
        @case('ajout-personne')
        @case('modifier-personne')
        <div class="col-md-10 mb-2">
            <div class="row">
                
                <div class="col-md-3 mb-2">
                    <label class=" lelabel" for="">NPI</label>
                    <div class="custom-search">
                        <input type="text" class="custom-search-input"
                               placeholder="Entrez NPI" onchange="" onKeyup="enMajuscule('npi');" id="npi" name="npi"
                               value="{{(isset($leget['npi'])&&$leget['npi']!=null)?$leget['npi']:(($a != null) ? $a->npi : old('npi'))}}">
                        <div class="input-group-append">
                            <button class="custom-search-botton btn btn-outline-success " type="button" onclick="onChangeGet('{{$config}}')"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-2">
                    <label class="lelabel" for="">Nationalité</label>
                    @php

                    echo chargerCombo($nationalites, 'id', 'libelle', 'idnationalite', 'Choisir une nationalité','','',(isset($leget['idnationalite'])&&$leget['idnationalite']!=0)?$leget['idnationalite']:(($a != null) ? $a->idnationalite : old('idnationalite')));
                    @endphp
                </div>

                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Sexe (*)</label>
                    @php              
                    echo chargerCombo($sexes, 'id', 'libelle', 'idsexe', 'Choisir le sexe','',"",(isset($leget['idsexe'])&&$leget['idsexe']!=0)?$leget['idsexe']:(($a != null) ? $a->idsexe : old('idsexe')));
                    @endphp
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Contact parent (*)</label>
                    <input type="text" class="form-control rounded-4 @error('contactparent') is-invalid @enderror"
                           placeholder="Entrez le contact parent" onKeyup="typetelephone(this);" id="contactparent" name="contactparent"
                           value="{{(isset($leget['contactparent'])&&$leget['contactparent']!=null)?$leget['contactparent']:(($a != null) ? $a->contactparent : old('contactparent'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Nom (*)</label>
                    <input type="text" class="form-control rounded-4 @error('nom') is-invalid @enderror"
                           placeholder="Entrez le nom" onKeyup="enMajuscule('nom');" id="nom" name="nom"
                           value="{{(isset($leget['nom'])&&$leget['nom']!=null)?$leget['nom']:(($a != null) ? $a->nom : old('nom'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Prénoms (*)</label>
                    <input type="text" class="form-control rounded-4 @error('prenoms') is-invalid @enderror"
                           placeholder="Entrez le prénom" onKeyup="enMajuscule('prenoms', 1);" id="prenoms" name="prenoms"
                           value="{{(isset($leget['prenoms'])&&$leget['prenoms']!=null)?$leget['prenoms']:(($a != null) ? $a->prenoms : old('prenoms'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Date de naissance (*)</label>
                    <input type="date" class="form-control rounded-4 @error('datenais') is-invalid @enderror"
                           placeholder="Entrez la date de naissance"  id="datenais" name="datenais"
                           value="{{(isset($leget['datenais'])&&$leget['datenais']!=null)?$leget['datenais']:(($a != null) ? $a->datenais: old('datenais'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Lieu de naissance (*)</label>
                    <input type="text" class="form-control rounded-4 @error('lieunais') is-invalid @enderror"
                           placeholder="Entrez le lieu de naissance"  onKeyup="enMajuscule('lieunais', 0);"  id="lieunais" name="lieunais"
                           value="{{(isset($leget['lieunais'])&&$leget['lieunais']!=null)?$leget['lieunais']:(($a != null) ? $a->lieunais: old('lieunais'))}}">
                </div>
                
            </div>
        </div>
        <div class="col-md-2 mb-2">

            <div class="control-group "> 
                <div class="form-group" >
                    <label ><strong>Photo de la personne </strong></label>
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
                                        <span class="fileupload-exists btn-small btn-warning" title="Changer"><i class="bi bi-camera"></i></span><input type="file" name="photo" id="photo" value="{{(isset($leget['photo'])&&$leget['photo']!=null)?$leget['photo']:(($a != null) ? $a->photo : old('photo'))}}" /></span>
                                    <span class="btn btn-small btn-danger " data-dismiss="fileupload" title="Supprimer"> <i class="bi bi-trash"></i></span> 
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        @php
            $config = 'personne';
        @endphp
            @break

            @case('matiere')
                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Libellé (*)</label>
                    <input type="text" class="form-control rounded-4 @error('libelle') is-invalid @enderror"
                        placeholder="Entrez le libellé" onKeyup="enMajuscule('libelle', 1);" id="libelle" name="libelle"
                        value="{{($a != null) ? $a->libelle : old('libelle')}}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Abréviation (*)</label>
                    <input type="text" class="form-control rounded-4 "
                        placeholder="Entrez l'abréviation" onKeyup="enMajuscule('abreviation');" id="abreviation" name="abreviation"
                        value="{{($a != null) ? $a->abreviation : old('abreviation')}}">
                </div>

                <div class="col-md-6">                             
                            <div class="row">
                                <div class="col-md-12">
                                    <label ><strong>Niveau Académique(*)</strong></label> 
                                </div>
                            </div>
                             <br> 
                            <div class="row">
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <?php
                                        $maternel = ($a != null) ? $a->maternel : 0;
                                        $chkdesmaternel = $maternel == 1 ? "checked = true" :  old('maternel');
                                        ?>
                                        <label  for="chkmaternel"><strong>Maternel</strong>
                                        <input type="hidden" id='maternel' name='maternel' value="{{ $maternel }}">
                                            <input type="checkbox" {{$chkdesmaternel }} onchange="renvoievalcoche('chkmaternel', 'maternel');"  id="chkmaternel" />
                                        </label>
                                    </div> 
                                </div>

                                <div class="col-md-3"> 
                                    <div class="form-group" >
                                        <?php
                                        $primaire = ($a != null) ? $a->primaire : 0;
                                        $chkdesprimaire = $primaire == 1 ? "checked = true" : '';
                                        ?>
                                        <label  for="chkprimaire"><strong>Primaire</strong>
                                        <input type="hidden" id='primaire' name='primaire' value="{{ $primaire }}">
                                            <input type="checkbox" <?php echo $chkdesprimaire; ?>  onchange="renvoievalcoche('chkprimaire', 'primaire');"  id="chkprimaire" />
                                        </label>
                                    </div> 
                                </div>

                                <div class="col-md-3"> 
                                    <div class="form-group" >
                                        <?php
                                        $secondaire = ($a != null) ? $a->secondaire : 0;
                                        $chkdessecondaire = $secondaire == 1 ? "checked = true" : '';
                                        ?>
                                        <label  for="chksecondaire"><strong>Secondaire</strong>
                                        <input type="hidden" id='secondaire' name='secondaire' value="{{ $secondaire }}">
                                            <input type="checkbox" <?php echo $chkdessecondaire; ?>  onchange="renvoievalcoche('chksecondaire', 'secondaire');"  id="chksecondaire" />
                                        </label>
                                    </div> 
                                </div>

                                <div class="col-md-3"> 
                                    <div class="form-group" >
                                        <?php
                                        $universitaire = ($a != null) ? $a->universitaire : 0;
                                        $chkdesuniversitaire = $universitaire == 1 ? "checked = true" : '';
                                        ?>
                                        <label  for="chkuniversitaire"><strong>Universitaire</strong>
                                        <input type="hidden" id='universitaire' name='universitaire' value="{{ $universitaire }}">
                                            <input type="checkbox" <?php echo $chkdesuniversitaire; ?>  onchange="renvoievalcoche('chkuniversitaire', 'universitaire');"  id="chkuniversitaire" />
                                        </label>
                                    </div> 
                                </div> 
                            </div>
                        </div>                 

            @break

            @case('element')
                <div class="col-md-6 mb-2">
                    <input type="hidden" id='nomtable' name='nomtable' value="{{$nomtable }}">
                    <label class="lelabel" for="">Désignation (*)</label>
                    <input type="text" class="form-control rounded-4 @error('libelle') is-invalid @enderror"
                        onkeyup="enMajuscule('libelle',1)" placeholder="Entrez la désignation" id="libelle" name="libelle"
                        value="{{($a != null) ? $a->libelle : old('libelle')}}" required>
                </div>
                @if(in_array($nomtable,array('motif')))
                <div class="col-md-6 mb-2">
                    <label class="lelabel" for="">Cas de</label>
                    <input type="text" class="form-control rounded-4 @error('lecas') is-invalid @enderror"
                        onkeyup="enMajuscule('lecas')" placeholder="Entrez le cas" id="lecas" name="lecas"
                        value="{{($a != null) ? $a->lecas : old('lecas')}}" required>
                </div>
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
        switch (cas) {
            case 'role':   
                chps = 'code|name';  
                labels = "le code|la désignation";     
                act = '/enregistrer-role';      
                break;
                
            case 'personne':   
                       // alert('Merci');
            chps = 'npi|idsexe|nom|prenoms|contactparent|datenais|lieunais';
            labels = "N° NPI |le sexe|le nom|le prénom|le contact parent|la date de naissance|le lieu de naissance";
                act = '/enregistrer-personne';      
                break;

            case 'session-academique':   
                chps = 'idsecteur|libelle|rang';  
                labels = "le secteur|la désignation|le rang";     
                act = '/enregistrer-session-academique';      
                break;

            case 'element':   
                chps = 'libelle';  
                labels = "La désignation";     
                act = '/enregistrer-element';      
                break;

            case 'anneescolaire':   
                chps = 'andebut';  
                labels = "l'année de début";  
                act = '/enregistrer-anneescolaire'; 
                        
                break;

            case 'classetype':   
                chps = 'niveau|secteur|libelle|sigle';  
                labels = "le niveau hiérarchique|le secteur|la désignation|l'abréviation";  
                act = '/enregistrer-classetype';                         
                break;           

                case 'matiere':
                // alert('Merci');
                chps = 'libelle|abreviation';
                labels = "le libellé de la matière|l'abréviation";
                act = '/enregistrer-matiere';
            break;
        
                case 'permission':
                // alert('Merci');
                chps = 'libelle';
                labels = "le libellé de la fonctionnalité";
                act = '/enregistrer-permission';
            break;
        
        }

        if (controleVide(chps, labels)) { 
            document.forms["myform"].method = 'POST';
            document.forms["myform"].action = act;
            document.forms["myform"].submit();
        }
    }
</script>