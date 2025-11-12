@php


$config = session('config') ? session('config') : '';
$lecas = "";
$lienAjout = "";
$lienModif = "";
$lienSuppr = "";
$disabled = '';

switch ($config) {
case 'ajout-apprenant':
case 'modifier-apprenant':
$lecas = ($lenregistrement) ? "Modification d'un apprenant" : "Ajout d'un apprenant";
break;

case 'ajout-paiement':
case 'modifier-paiement':
$lecas = ($lenregistrement) ? "Modification d'un paiement" : "Ajout d'un paiement";
break;

case 'ajout-evaluation':
case 'modifier-evaluation':
$lecas = ($lenregistrement) ? "Modification d'une évaluation" : "Ajout d'une évaluation";
break;

case 'ajout-composition':
$lecas = "Ajout d'une évaluation au primaire";
break;
case 'modifier-composition':
$lecas = "Modification d'une évaluation au primaire";
break;
case 'details-composition':
$lecas = strtoupper("Détails ".(($lenregistrement) ? $lenregistrement->libelle : ""));
break;

case 'ajout-moyenne-periode':
case 'modifier-moyenne-periode':
$lecas = "Calcul de moyenne par matière par session académique";
break;
case 'details-moyenne-periode':
$lecas = "Détails de moyenne par matière par session académique";
break;

}

$a = ($lenregistrement) ? $lenregistrement : null;
//dd($leget );
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'form', "lecas" => $lecas])

@section('content')

<!-- <form id='myform' action="" method="POST" enctype="multipart/form-data"> -->
    @csrf

    <input type="hidden" id='idenreg1' name='idenreg1' value="{{($a != null) ? $a->id : null}}">
    <div class="row">
        @switch($config) 

        @case('ajout-apprenant')
        @case('modifier-apprenant')
        <div class="col-md-10 mb-2">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
                    <input type="hidden" id='idpersonne' name='idpersonne' value="{{(isset($leget['idpersonne'])&&$leget['idpersonne']!=null)?$leget['idpersonne']:(($lapersonne != null) ? $lapersonne->id : old('idpersonne'))}}">
                    <label class=" lelabel" for="">Abonnement</label>
                    <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                           value="{{$labonnement->designation }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class=" lelabel" for="">NPI</label>
                    <div class="custom-search">
                        <input type="text" class="custom-search-input"
                               placeholder="Entrez NPI" onchange="" onKeyup="enMajuscule('npi');" id="npi" name="npi"
                               value="{{(isset($leget['npi'])&&$leget['npi']!=null)?$leget['npi']:(($lapersonne != null) ? $lapersonne->npi : old('npi'))}}">
                        <div class="input-group-append">
                            <button class="custom-search-botton btn btn-outline-success " type="button" onclick="onChangeGet('{{$config}}')"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                </div>
                <div class="col-md-3 mb-2">
                    <label class=" lelabel" for="">N° EDUCMASTER</label>
                    <div class="custom-search">
                        <input type="text" class="custom-search-input"
                               placeholder="Entrez N° EDUCMASTER"  onchange="" onKeyup="enMajuscule('matricule');" id="matricule" name="matricule"
                               value="{{(isset($leget['matricule'])&&$leget['matricule']!=null)?$leget['matricule']:(($a != null) ? $a->matricule : old('matricule'))}}">
                        <div class="input-group-append">
                            <button class="custom-search-botton btn btn-outline-success" type="button" onclick="onChangeGet('{{$config}}')" ><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-2 mb-2">
                    <input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanneescolaire}}">
                    <label class=" lelabel" for="">Année scolaire</label>
                    <input type="text" disabled class="form-control rounded-4 @error('lannesco') is-invalid @enderror"
                           value="{{($lannesco!= null)?$lannesco->libannee():'' }}">
                </div>

                <div class="col-md-4 mb-2">
                    <input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclassannesco}}">
                    <label class=" lelabel" for="">Classe</label>
                    <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                           value="{{($laclassannesco!= null)?$laclassannesco->libclasse():'' }}">
                </div>

                <div class="col-md-3 mb-2">
                    <label class="lelabel" for="">Nationalité</label>
                    @php

                    echo chargerCombo($nationalites, 'id', 'libelle', 'idnationalite', 'Choisir une nationalité','','',(isset($leget['idnationalite'])&&$leget['idnationalite']!=0)?$leget['idnationalite']:(($lapersonne != null) ? $lapersonne->idnationalite : old('idnationalite')));
                    @endphp
                </div>

                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Sexe (*)</label>
                    @php              
                    echo chargerCombo($sexes, 'id', 'libelle', 'idsexe', 'Choisir le sexe','',"",(isset($leget['idsexe'])&&$leget['idsexe']!=0)?$leget['idsexe']:(($lapersonne != null) ? $lapersonne->idsexe : old('idsexe')));
                    @endphp
                </div>

                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Contact parent (*)</label>
                    <input type="text" class="form-control rounded-4 @error('contactparent') is-invalid @enderror"
                           placeholder="Entrez le contact parent" onKeyup="typetelephone(this);" id="contactparent" name="contactparent"
                           value="{{(isset($leget['contactparent'])&&$leget['contactparent']!=null)?$leget['contactparent']:(($lapersonne != null) ? $lapersonne->contactparent : old('contactparent'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Nom (*)</label>
                    <input type="text" class="form-control rounded-4 @error('nom') is-invalid @enderror"
                           placeholder="Entrez le nom" onKeyup="enMajuscule('nom');" id="nom" name="nom"
                           value="{{(isset($leget['nom'])&&$leget['nom']!=null)?$leget['nom']:(($lapersonne != null) ? $lapersonne->nom : old('nom'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Prénoms (*)</label>
                    <input type="text" class="form-control rounded-4 @error('prenoms') is-invalid @enderror"
                           placeholder="Entrez le prénom" onKeyup="enMajuscule('prenoms', 1);" id="prenoms" name="prenoms"
                           value="{{(isset($leget['prenoms'])&&$leget['prenoms']!=null)?$leget['prenoms']:(($lapersonne != null) ? $lapersonne->prenoms : old('prenoms'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Date de naissance (*)</label>
                    <input type="date" class="form-control rounded-4 @error('datenais') is-invalid @enderror"
                           placeholder="Entrez la date de naissance"  id="datenais" name="datenais"
                           value="{{(isset($leget['datenais'])&&$leget['datenais']!=null)?$leget['datenais']:(($lapersonne != null) ? $lapersonne->datenais: old('datenais'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Lieu de naissance (*)</label>
                    <input type="text" class="form-control rounded-4 @error('lieunais') is-invalid @enderror"
                           placeholder="Entrez le lieu de naissance"  onKeyup="enMajuscule('lieunais', 0);"  id="lieunais" name="lieunais"
                           value="{{(isset($leget['lieunais'])&&$leget['lieunais']!=null)?$leget['lieunais']:(($lapersonne != null) ? $lapersonne->lieunais: old('lieunais'))}}">
                </div>

                @if($a== null)
                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Date d'inscription</label>
                    <input type="date" class="form-control rounded-4 @error('dateinscrip') is-invalid @enderror"
                           id="dateinscrip" name="dateinscrip"
                           value="{{(isset($leget['dateinscrip'])&&$leget['dateinscrip']!=null)?$leget['dateinscrip']:(($a != null) ? $a->dateinscrip: date('Y-m-d'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Réduction sur frais d'inscription</label>
                    <input type="text" class="form-control rounded-4 @error('reduction') is-invalid @enderror"
                           placeholder="Entrez la réduction sur l'inscription" onkeyup="typemontant(this);"  id="reduction" name="reduction"
                           value="{{(isset($leget['reduction'])&&$leget['reduction']!=null)?$leget['reduction']:(($a != null) ? $a->reduction: old('reduction'))}}">
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-2 mb-2">

            <div class="control-group "> 
                <div class="form-group" >
                    <label ><strong>Photo apprenant </strong></label>
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
                                        <span class="fileupload-exists btn-small btn-warning" title="Changer"><i class="bi bi-camera"></i></span><input type="file" name="photo" id="photo" value="{{(isset($leget['photo'])&&$leget['photo']!=null)?$leget['photo']:(($lapersonne != null) ? $lapersonne->photo : old('photo'))}}" /></span>
                                    <span class="btn btn-small btn-danger " data-dismiss="fileupload" title="Supprimer"> <i class="bi bi-trash"></i></span> 
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        @php
        $config = 'apprenant';
        @endphp

        @break


        @case('ajout-paiement')
        @case('modifier-paiement')
        <div class="col-md-4 mb-2"> 
            <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
            <label class=" lelabel" for="">Abonnement</label>
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
            <input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclassannesco}}">
            <label class=" lelabel" for="">Classe</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($laclassannesco!= null)?$laclassannesco->libclasse():'' }}">
        </div>

        <div class="col-md-4 mb-2">
            <label class="lelabel" for="">Apprenant (*) </label>
            @php           
            echo chargerCombo($apprenants, 'id', 'libapprenant', 'idinscription', 'Choisir un apprenant','',"",($a != null) ? $a->idinscription: old('idinscription'));
            @endphp
        </div>

        <div class="col-md-4 mb-2">
            <label class="lelabel" for="">Motif (*) </label>
            @php              
            echo chargerCombo($motifs, 'id', 'libelle', 'idmotif', 'Choisir un motif de paiement','',"",($a != null) ? $a->idmotif: old('idmotif'));
            @endphp
        </div>

        <div class="col-md-2 mb-2">
            <label class=" lelabel" for="">Montant payé (*)</label>
            <input type="text" class="form-control rounded-4 @error('montant') is-invalid @enderror"
                   placeholder="Entrez le montant" onkeyup="typemontant(this);"  id="montant" name="montant"
                   value="{{($a != null) ? $a->montant: old('montant')}}">
        </div>
        <div class="col-md-2 mb-2">
            <label class=" lelabel" for="">Date paiement</label>
            <input type="date" class="form-control rounded-4 @error('datepaiement') is-invalid @enderror"
                   id="datepaiement" name="datepaiement"
                   value="{{($a != null) ? $a->datepaiement: date('Y-m-d')}}">
        </div>

        <div class="col-md-4 mb-2">
            <label class=" lelabel" for="">Déposant</label>
            <input type="text" class="form-control rounded-4 @error('deposant') is-invalid @enderror"
                   placeholder="Entrez le déposant"  onKeyup="enMajuscule('deposant', 0);"  id="deposant" name="deposant"
                   value="{{($a != null) ? $a->deposant: old('deposant')}}">
        </div>

        @php
        $config = 'paiement';
        @endphp
        @break

        @case('ajout-evaluation')
        @case('modifier-evaluation')
        <div class="col-md-4 mb-2">
            <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
            <label class=" lelabel" for="">Abonnement</label>
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
            <input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclassannesco}}">
            <label class=" lelabel" for="">Classe</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($laclassannesco!= null)?$laclassannesco->libclasse():'' }}">
        </div>

        <div class="col-md-3 mb-2">
            <label class="lelabel" for="">Matière (*) </label>
            @php              
            echo chargerCombo($matieres, 'id', 'libelle', 'idmatiere', 'Choisir une matière','',"",($a != null) ? $a->idmatiere: old('idmatiere'));
            @endphp
        </div>
        
                <div class="col-md-6 mb-2">
                    <label class=" lelabel" for="">Libellé</label>
                    <input type="text" class="form-control rounded-4 "
                           placeholder="Entrez le libellé"  onKeyup="enMajuscule('libelle', 0);"  id="libelle" name="libelle"
                           value="{{($a != null) ? $a->libelle: old('libelle')}}">
                </div>
                
                        <div class="col-md-2 mb-2">
                            <label class=" lelabel" for="">Date évaluation</label>
                            <input type="date" class="form-control rounded-4 "
                                   id="datevaluation" name="datevaluation"
                                   value="{{($a != null) ? $a->datevaluation: date('Y-m-d')}}">
                        </div>

        <div class="col-md-1 mb-2">
            <label class=" lelabel" for="">Barême</label>
            <input type="number" class="form-control rounded-4 "
                   placeholder="Entrez le barême"  id="barem" name="barem"
                   value="{{($a != null) ? $a->barem: 20}}">
        </div>

        @php
        $config = 'evaluation';
        @endphp
        @break

        @case('ajout-composition')
        @case('modifier-composition')
        @case('details-composition')
        @php
       
        $disabled = ($config =='details-composition')?'disabled':'';
        $coltitre = "";
        $coldata =  "";
        $donneeimprim = array();
         

        //Tri des données par moyenne décroissante
        $data = $donnees->toArray();
       
        
        $colonneMoy = array_column($data, 'moyenne');
        $colonneNom = array_column($data, 'libapprenant');

        array_multisort($colonneMoy, SORT_DESC, $colonneNom, SORT_ASC, $data);
        $i = 1;
        foreach ($data as &$ligne) {
            $ligne->rang= $i.($i==1?'er':'ème'); 
            $moy = $ligne->moyenne;
            $rg =$i.($i==1?'er':'ème'); 
            if($i>1 && $ligne->moyenne == $data[$i-2]->moyenne  )
                {
                $ligne->rang= str_replace(" ex aequo", "", $data[$i-2]->rang) ." ex aequo";
                }
            $i++;        
           
        }
unset($ligne); // casser la référence après la boucle

 $colonneNom = array_column($data, 'libapprenant');

        array_multisort($colonneNom, SORT_ASC, $data);
$donnees = collect($data);

      //  dd($data);

        @endphp

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
            <label class=" lelabel" for="">Abonnement</label>
            <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                   value="{{$labonnement->designation }}">
        </div>
        <div class="col-md-3 mb-2">
            <input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanneescolaire}}">
            <label class=" lelabel" for="">Année scolaire</label>
            <input type="text" disabled class="form-control rounded-4 @error('lannesco') is-invalid @enderror"
                   value="{{($lannesco!= null)?$lannesco->libannee():'' }}">
        </div>

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclassannesco}}">
            <label class=" lelabel" for="">Classe</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($laclassannesco!= null)?$laclassannesco->libclasse():'' }}">
        </div>

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idsession' name='idsession' value="{{$idsession}}">
            <label class=" lelabel" for="">Session académique</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($lasession!= null)?$lasession->libelle:'' }}">
        </div>
                <div class="col-md-6 mb-2">
                    <label class=" lelabel" for="">Libellé</label>
                    <input type="text" {{ $disabled }} class="form-control rounded-4 "
                           placeholder="Entrez le libellé"  onKeyup="enMajuscule('libelle', 0);"  id="libelle" name="libelle"
                           value="{{($a != null) ? $a->libelle: old('libelle')}}">
                </div>
                
                        <div class="col-md-2 mb-2">
                            <label class=" lelabel" for="">Date évaluation</label>
                            <input type="date" {{ $disabled }} class="form-control rounded-4 "
                                   id="datecompo" name="datecompo"
                                   value="{{($a != null) ? $a->datecompo: date('Y-m-d')}}">
                        </div>

        <div class="col-md-1 mb-2">
            <label class=" lelabel" for="">Barême</label>
            <input type="number" {{ $disabled }} class="form-control rounded-4 "
            placeholder="Entrez le barême"  id="barem" name="barem"
            value="{{($a != null) ? $a->barem: 20}}">
        </div>
        @if (in_array($config, ['details-composition']))
            <div class="col-md-1 mb-2">
                <label class=" lelabel" for=""></label>
                <div class="btn-group btn-group-toggle" style="margin-top:25px;" data-toggle="buttons">                
                    <a class="btn btn-success btnarrondi" href="#" onclick="imprimerPDF();" target="_blank" > <i class="fa fa-print"></i> Imprimer</a>
                            
                </div>
            </div>        
        @endif
        
        <div class="col-md-12 mb-2">
            <table id="letabloz" class="table table-bordered table-striped  " scrol>
                @php 
                $coltitre = "N°|Apprenant";
                $coldata = "num|libapprenant";                
                @endphp
            <thead>
            <tr>
            <th style="width: 15px;">N°</th>
            <th >Apprenant</th>
            @foreach($matieres as $k=> $m)
            @php 
                $coltitre .= "|".$m->abreviation ; 
                $coldata .= "|m".$k+1 ; 
            @endphp
            <th >{{ $m->abreviation }}</th>
            @endforeach
            @php 
            $coltitre .= "|Total|Moyenne|Rang"; 
            $coldata .= "|total|moyenne|rang"; 
            @endphp
            <th >Total</th>
            <th >Moyenne</th>
            <th >Rang</th>
            </tr>
            </thead>
            <tbody>
                @php
                $i = 0;

                @endphp
                @foreach ($donnees as  $d)
                <input type="hidden" id="id{{ $i }}" name="id{{ $i }}" value="{{ $d->id }}">
                <input type="hidden" id="idinscription{{ $i }}" name="idinscription{{ $i }}" value="{{ $d->idinscription }}">
                @php
                    $ln = array();
                    $ln['num'] = $i + 1;                    
                    $ln['libapprenant'] = $d->libapprenant;                    
                @endphp
                <tr>
                        <td>
                            {{$i+1}}
                        </td> 
                        <td>
                            {{$d->libapprenant}}
                        </td> 
                        @php 
                        $tot = 0;
                        @endphp
                         @foreach($matieres as $j => $m)
                         @php
                         $v = "m".$j+ 1;
                         $tot += (($d->$v !=null?$d->$v :-1) > 0)?floatval($d->$v):0;
                         $ln[$v] = $d->$v !=null?$d->$v :-1;
                         @endphp
                        <td>
                            <input style="width:65px;" {{ $disabled }} type="number" id="{{ $v }}_{{ $i }}" name="{{ $v }}_{{ $i }}" onKeyup="controleNote(this);" onchange="calculMoyenne('{{ $i }}');" value="{{ $d->$v !=null?$d->$v :-1}}">
                        </td> 
                         @endforeach
                         @if($j < 12 )
                         @for($k = $j+2; $k<=12; $k++)
                            <input style="width:65px;" type="hidden" id="m{{ $k }}_{{ $i }}" name="m{{ $k }}_{{ $i }}" value="-1">
                         @endfor

                         @endif
                        <td>
                            <input style="width:65px;" type="number" readonly id="total{{ $i }}" name="total{{ $i }}" value="{{ round(floatval($tot) , 3)}}">
                        </td>                       
                        <td>
                            <input style="width:65px;" type="number" readonly id="moyenne{{ $i }}" name="moyenne{{ $i }}" value="{{ round(floatval($d->moyenne) , 3)}}">
                        </td>                       
                        <td>
                            <input style="width:65px;" type="text" readonly id="rang{{ $i }}" name="rang{{ $i }}" value="{{ $d->rang}}">
                        </td>                       
                        @php
                         $ln['total'] = round(floatval($tot) , 3); 
                         $ln['moyenne'] = round(floatval($d->moyenne) , 3); 
                         $ln['rang'] = $d->rang; 
                        @endphp
                    </tr>
                     @php
                $i++;
                array_push($donneeimprim, $ln);
                @endphp
                    @endforeach
                    <input type="hidden" id="taille" name="taille" value="{{ $i }}">
            </tbody>
            </table>
             @php 
//Tri des données par moyenne décroissante
$colonneMoy = array_column($donneeimprim, 'moyenne');
array_multisort($colonneMoy, SORT_DESC, $donneeimprim);


            session(['donneeimprim' => $donneeimprim]);
            session(['coltitre' => $coltitre]);
            session(['coldata' => $coldata]);
        @endphp
        </div>


        @php
        $config = 'composition';
        @endphp
        @break

        @case('ajout-moyenne-periode')
        @case('modifier-moyenne-periode')
        @case('details-moyenne-periode')
        @php
        $disabled = ($config =='details-moyenne-periode')?'disabled':'';
        @endphp

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnement}}">
            <label class=" lelabel" for="">Abonnement</label>
            <input type="text" disabled class="form-control rounded-4 @error('abonnement') is-invalid @enderror"
                   value="{{$labonnement->designation }}">
        </div>
        <div class="col-md-3 mb-2">
            <input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanneescolaire}}">
            <label class=" lelabel" for="">Année scolaire</label>
            <input type="text" disabled class="form-control rounded-4 @error('lannesco') is-invalid @enderror"
                   value="{{($lannesco!= null)?$lannesco->libannee():'' }}">
        </div>

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclassannesco}}">
            <label class=" lelabel" for="">Classe</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($laclassannesco!= null)?$laclassannesco->libclasse():'' }}">
        </div>

        <div class="col-md-3 mb-2">
            <input type="hidden" id='idsession' name='idsession' value="{{$idsession}}">
            <label class=" lelabel" for="">Session académique</label>
            <input type="text" disabled class="form-control rounded-4 @error('laclassannesco') is-invalid @enderror"
                   value="{{($lasession!= null)?$lasession->libelle:'' }}">
        </div>
                
        <div class="col-md-3 mb-2">
            <label class="lelabel" for="">Matière (*) </label>
            @php              //
            $idmat = isset($idmatieresel)?$idmatieresel: (($a != null) ? $a->idmatiere: old('idmatiere'));
            echo chargerCombo($matieres, 'id', 'libelle', 'idmatiere', 'Choisir une matière','',"onChangeGet('$config')",$idmat);
            @endphp
        </div>
        @php

            $lib = "Calcul de moyenne en " .infoTableParId('matieres',$idmat,'libelle');
            $lib .= " pour le ".(($lasession!= null)?$lasession->libelle:'').' ' ;
            $lib .= (($laclassannesco!= null)?$laclassannesco->libclasse():'');
            $lib .= " / ". (($lannesco!= null)?$lannesco->libannee():'');

        @endphp
        <div class="col-md-9 mb-2">
                    <label class=" lelabel" for="">Libellé</label>
                    <input type="text" readonly class="form-control rounded-4 "
                            id="libelle" name="libelle"
                           value="{{strtoupper($lib)}}">
                </div>
        <input type="hidden"  id="barem" name="barem" value="20">
                
        <div class="col-md-12 mb-2">
            <table id="letabloz" class="table table-bordered table-striped  " scrol>
            <thead>
            <tr>
            <th style="width: 15px;">N°</th>
            <th >Apprenant</th>
            @for ($i = 1; $i<=5; $i++ )  
            <th >{{ 'Interro '.$i }}</th>
            @endfor
            <th >Moy. Interro</th>
            <th >Devoir 1</th>
            <th >Devoir 2</th>
            <th >Moyenne</th>
            </tr>
            </thead>
            <tbody>
                @php
                $i = 0;


                @endphp
                @foreach ($donnees as  $d)
                <input type="hidden" id="id{{ $i }}" name="id{{ $i }}" value="{{ $d->id }}">
                <input type="hidden" id="idinscription{{ $i }}" name="idinscription{{ $i }}" value="{{ $d->idinscription }}">
                    
                <tr>
                        <td>
                            {{$i+1}}
                        </td> 
                        <td>
                            {{$d->libapprenant}}
                        </td> 
                         @for ($j = 1; $j<=5; $j++ )                         
                        
                         @php
                         $v = "intero".$j;
                         @endphp
                        <td>        
                            <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number" id="{{ $v }}_{{ $i }}" name="{{ $v }}_{{ $i }}" onKeyup="controleNote(this);" onchange="calculMoyInterro('{{ $i }}');" value="{{ $d->$v !=null?$d->$v :-1}}">
                        </td> 
                          @endfor
                        
                        <td>
                            <input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="moyIntero{{ $i }}" name="moyIntero{{ $i }}" value="{{ $d->moyinterro !=null? $d->moyinterro : -1 }}">
                        </td>                       
                        <td>        
                            <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number" id="dev1_{{ $i }}" name="dev1_{{ $i }}" onKeyup="controleNote(this);" onchange="calculMoyPeriodeMatiere('{{ $i }}');" value="{{ $d->dev1 !=null?$d->dev1 :-1}}">
                        </td> 
                        <td>        
                            <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number" id="dev2_{{ $i }}" name="dev2_{{ $i }}" onKeyup="controleNote(this);" onchange="calculMoyPeriodeMatiere('{{ $i }}');" value="{{ $d->dev2 !=null?$d->dev2 :-1}}">
                        </td> 
                        
                        <td>
                            <input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="moy{{ $i }}" name="moy{{ $i }}" value="{{ round(floatval($d->moy) , 3)}}">
                        </td>                       
                        
                    </tr>
                     @php
                $i++;
                @endphp
                    @endforeach
                    <input type="hidden" id="taille" name="taille" value="{{ $i }}">
            </tbody>
            </table>
        </div>
        @php
        $config = 'moyenne-periode';
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
<!-- </form> -->

@endsection


<script>

    function valider(cas) {
    var chps = '';
    var labels = "";
    var act = '';
    var ok = true; idenreg1
    document.getElementById('idenreg').value = document.getElementById('idenreg1').value;

    switch (cas) {
    case 'apprenant':
        chps = 'npi|matricule|idsexe|nom|prenoms|contactparent|datenais|lieunais';
        labels = "N° NPI |N° EDUCMASTER|le sexe|le nom|le prénom|le contact parent|la date de naissance|le lieu de naissance";
        act = '/enregistrer-apprenant';
        if (document.getElementById('dateinscrip').value == ''){
            chps += '|dateinscrip';
            labels += "|la date d'inscription";
        }
        //  alert('Merci ' + act);

    break;
    case 'paiement':
            // alert('Merci');
            chps = 'idinscription|idmotif|montant';
    labels = "l'apprenant pour qui on éffectue le paiement|le motif|le montant payé";
    act = '/enregistrer-paiement';
    break;
    case 'evaluation':
            // alert('Merci'); libelle	datevaluation	barem	idclassannesco	idmatiere	
            chps = 'idclassannesco|idmatiere|libelle';
    labels = "la classe|la matière|le libellé";
    act = '/enregistrer-evaluation';
    break;
    case 'composition':
            chps = 'idclassannesco|libelle|datecompo';
    labels = "la classe|le libellé|la date d'valuation";
    act = '/enregistrer-composition';
    break;
    case 'moyenne-periode':
            chps = 'idmatiere|libelle';
    labels = "la matière|le libellé";
    act = '/enregistrer-moyenne-periode';
    break;
    }

    if (controleVide(chps, labels)) {
    // alert(act);
    document.forms["myform"].method = 'POST';
    document.forms["myform"].action = act;
    document.forms["myform"].submit();
    }
    }
</script>