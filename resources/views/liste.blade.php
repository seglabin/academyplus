@php
$config = session('config') ? session('config') : '';
$lecas = "";
$lienAjout = "";
$lienModif = "";
$lienSuppr = "";
$tires = array();
$cols = array();

$menusUser = (session('menusUser') != null) ? session('menusUser') : null;

$userEncours = (session('userEncours')!=null)? session('userEncours'):null;
$anEncours = (session('anEncours')!=null)? session('anEncours'):null;
$abonnementEncours = (session('abonnementEncours')!=null)? session('abonnementEncours'):null;
$roleEncours = (session('roleEncours')!=null)? session('roleEncours'):null;

$idsession = isset($idsession)?$idsession:null;

$idanEncours = $anEncours!= null?$anEncours->id:null;
$idabonnementEncours = $abonnementEncours!= null?$abonnementEncours->id:null;
$codeRoleEncours = $roleEncours!= null?$roleEncours->code:null;

   $coltitre = "";// "N°";
    $coldata =  "";// "num";
    $donneeimprim = array();
 


//echo $config;
switch ($config) {
case 'role':
$lecas = "Liste des profil-utilisateurs";
$lienAjout = "/ajout-role";
$coltitre .= "Code|Désignation";
$coldata .= "code|name";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);

$lienModif = "modifier-role/";
$lienSuppr = "supprimer-role/";
break;

case 'personne':
$lecas = "Liste des informations personnelles";
$lienAjout = "/ajout-personne"; // `datenais`, `lieunais`, `contactparent`

$coltitre .= "NPI|Nom|Prénoms|Contact parent|Né(e) le|Né(e) à |Sexe|Nationalité";
$coldata .= "npi|nom|prenoms|contactparent|datenais|lieunais|libsexe|libnationalite";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-personne/";
$lienSuppr = "supprimer-personne/";
break;

case 'session-academique':
$lecas = "Liste des sessions académiques";
$lienAjout = "/ajout-session-academique";
$coltitre .= "Libellé|Secteur";
$coldata .= "libelle|libsecteur";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-session-academique/";
$lienSuppr = "supprimer-session-academique/";
break;

case 'coefficient':
$lecas = "Liste des coefficients par classe et par matière";
$lienAjout = "/ajout-coefficient";
$coltitre .= "Matière|Classe|Type de matière|Coefficient|Ordre sur le bulletin";
$coldata .= "libmatiere|libclas|libtypematiere|coef|rang";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-coefficient/";
$lienSuppr = "supprimer-coefficient/";
break;

case 'matiere':
$lecas = "Liste des matières";
$lienAjout = "/ajout-matiere";
$coltitre .= "Libellé|Abréviation";
$coldata .= "libelle|abreviation";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-matiere/";
$lienSuppr = "supprimer-matiere/";
break;

case 'utilisateur':
$lecas = "Liste des utilisateurs de la plateforme";
$lienAjout = "/ajout-utilisateur"; //libpersonne  librole  libabonnement    libtype
$coltitre .= "Login|Infos personnelle|Profil|Type|Abonnement";
$coldata .= "login|libpersonne|librole|libtype|libabonnement";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-utilisateur/";
$lienSuppr = "supprimer-utilisateur/";
break;

case 'classetype':
$lecas = "Liste des classe - types";
$lienAjout = "/ajout-classetype";
$coltitre .= "Secteur|Niveau|Sigle|Désignation";
$coldata .= "secteur|niveau|sigle|libelle";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-classetype/";
$lienSuppr = "supprimer-classetype/";
break;

case 'apprenant':
$lecas = "Liste des apprenants";
$lienAjout = "/ajout-apprenant";
$coltitre .= "Matricule|NPI|Nom|Prénoms|contactparent|Classe actuelle|Tot. à payer|Tot. Payé|Reste à payer";
$coldata .= "matricule|npi|nom|prenoms|contactparent|classeactuelle|totscolarite|totpaye|reste";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-apprenant/";
$lienSuppr = "supprimer-apprenant/";
break;

case 'classannesco':
$lecas = "Liste des classes par année scolaire";
$lienAjout = "/ajout-classannesco";
$coltitre .= "Classe|Année scolaire|Abonnement|Groupe";
$coldata .= "libelle|libannee|designation|groupe";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-classannesco/";
$lienSuppr = "supprimer-classannesco/";
break;

case 'anneescolaire':
$lecas = "Liste des années scolaires";
$lienAjout = "/ajout-anneescolaire";
$coltitre .= "Année de début";
$coldata .= "andebut";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-anneescolaire/";
$lienSuppr = "supprimer-anneescolaire/";
break;

case 'abonnement':
$lecas = "Liste des abonnements";
$lienAjout = "/ajout-abonnement";
$coltitre .= "Désignation|Mail|Contact|Secteur|Expire le";
$coldata .= "designation|email|contact|libsecteur|datexpiration";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-abonnement/";
$lienSuppr = "supprimer-abonnement/";
break;

case 'paiement':
$lecas = "Liste des paiements";
$lienAjout = "/ajout-paiement";
$coltitre .= "Date paiement|Apprenant|Montant payé|Motif|Déposant";
$coldata .= "datepaiement|libapprenant|montant|libmotif|deposant";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-paiement/";
$lienSuppr = "supprimer-paiement/";
break;

case 'paramfrais':
$lecas = "Liste des paramétrages de frais de scolarité";
$lienAjout = "/ajout-paramfrais";
$tires = array('');
$cols = array('');
$coltitre .= "Classe|Frais de scolarité|Frais d'inscription|Frais de réinscription";
$coldata .= "libelle|fraiscolarite|fraisinscrip|fraisreinscrit";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-paramfrais/";
$lienSuppr = "supprimer-paramfrais/";
break;

case 'evaluation':
$lecas = "Liste des évaluations";
$lienAjout = "/ajout-evaluation";
$coltitre .= "Date évaluation|Libellé|Classe|Matière";
$coldata .= "datevaluation|libelle|libclas|libmatiere";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-evaluation/";
$lienSuppr = "supprimer-evaluation/";
break;

case 'composition':
$lecas = "Liste des évaluations au primaire";
$lienAjout = "/ajout-composition";
$tires = array();
$cols = array();
$coltitre .= "Date évaluation|Libellé|Classe'";
$coldata .= "datecompo|libelle|libclas";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-composition/";
$lienSuppr = "supprimer-composition/";
break;

case 'moyenne-periode':
$lecas = "Liste des moyennes par matière et par session académique";
$lienAjout = "/ajout-moyenne-periode";
$coltitre .= "Matière|Libellé";
$coldata .= "libmatiere|libelle";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-moyenne-periode/";
$lienSuppr = "supprimer-moyenne-periode/";
break;

case 'permission':
$lecas = "Liste des fonctionnalités";
$lienAjout = "/ajout-permission";
$coltitre .= "Libellé|Description";
$coldata .= "libelle|description";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-permission/";
$lienSuppr = "supprimer-permission/";
break;

case 'element':
$lecas = $titre;
$lienAjout = "/ajout-element";
$coltitre .= "Désignation";
$coldata .= "libelle";
$tires = explode('|',$coltitre);
$cols = explode('|',$coldata);
$lienModif = "modifier-element/";
$lienSuppr = "supprimer-element/";
break;

}

$coltitre = "N°|".$coltitre;
$coldata =  "num|".$coldata;

//dd($cols);
@endphp

@extends('layout', ["page_title" => Session('title'), "caspage" => 'liste', "lecas" => $lecas, "lienAjout" => $lienAjout])

@section('content')

<!-- <form class="row" method="GET" id='myform' name='myform' action=""> -->
<!-- @csrf -->

<input type="hidden" id="liensuppr" value="{{ $lienSuppr }}">
<div class="card-body">
    <div class="panel-body">
        @if (in_array($config,array('apprenant','paiement','coefficient','classannesco','paramfrais','evaluation')))
        <div class="row">
            <div class="col-md-4 mb-2">
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
            @if (!(in_array($config,array('coefficient'))))
            <div class="col-md-3 mb-2">
                <label class="lelabel" for="">Année scolaire </label>
                @php              
                echo chargerCombo($annescolaires, 'id', 'libannee', 'idanneescolaire', 'Choisir une année scolaire','',"onChangeGet('$config')",$idanneescolaire);
                @endphp
            </div>
            @endif
            @if (!(in_array($config,array('coefficient','classannesco','paramfrais'))))
            <div class="col-md-4 mb-2">
                <label class="lelabel" for="">Classe Année scolaire</label>
                @php              
                echo chargerCombo($classannescos, 'id', 'libclasse', 'idclassannesco', 'Choisir une année scolaire','',"onChangeGet('$config')",$idclassannesco);
                @endphp
            </div>
            @endif
            @if (in_array($config,array('apprenant')))
                <div class="col-md-1 mb-2">
                  <label class="lelabel" for=""> </label>
                    <a href="#" onclick="imprimerCarte();" class="btn btn-info" target="_blank"> Cartes</a>
                </div>
            @endif

        </div>
        @endif


        @if (in_array($config,array('composition','moyenne-periode')))
        <div class="row">
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
            <div class="col-md-3 mb-2">
                <label class="lelabel" for="">Année scolaire </label>
                @php              
                echo chargerCombo($annescolaires, 'id', 'libannee', 'idanneescolaire', 'Choisir une année scolaire','',"onChangeGet('$config')",$idanneescolaire);
                @endphp
            </div>
          
            <div class="col-md-3 mb-2">
                <label class="lelabel" for="">Classe Année scolaire</label>
                @php              
                echo chargerCombo($classannescos, 'id', 'libclasse', 'idclassannesco', 'Choisir une année scolaire','',"onChangeGet('$config')",$idclassannesco);
                @endphp
            </div>           
          
          <div class="col-md-3 mb-2">
              <label class="lelabel" for="">Section académique</label>
              @php              
              echo chargerCombo($sessionacad, 'id', 'libelle', 'idsession', 'Choisir une session académique','',"onChangeGet('$config')",$idsession);
              @endphp
          </div>           
        </div>
        @endif

        

        <table id="letablo" class="table table-bordered table-striped appliqueDT " scrol>
            <thead>
                <tr>
                    <th style="width: 15px;">N°</th>
                    <!-- @if ($config == 'classannesco') 
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Abonnement</th>
                    @endif -->
                    @foreach ($tires as $t)
                    <th>{{ $t }}</th>
                    @endforeach
                    @if ($config == 'anneescolaire')
                    @php
                    $coltitre .= "|Libellé";
                    $coldata .= "|libannee";
                    @endphp
                    @php
                    $coltitre .= "";
                    $coldata .= "";
                    @endphp
                    <th>Libellé</th>
                    @endif
                   
                    @if ($config == 'matiere')
                     @php
                    $coltitre .= "|Maternel|Primaire|Secondaire|Universitaire";
                    $coldata .= "|maternel|primaire|secondaire|universitaire";
                    @endphp
                    <th>Maternel</th>
                    <th>Primaire</th>
                    <th>Secondaire</th>
                    <th>Universitaire</th>
                    @endif

                    <th style="width: 120px;">Détails</th>
                </tr>
            </thead>
            <tbody>
                @php
                $j = 0;
                @endphp
                @foreach ($donnees as $i => $d)
                @php
                    $ln = array();
                    $ln['num'] = $j + 1;                    
                @endphp
                <tr>
                    @php
                    $j++;
                    @endphp
                    <td>
                        {{$j}}
                    </td>                                
                    @foreach ($cols as $c)
                    <td>
                        @php
                        $ln[$c] = $d->$c;
                        @endphp
                        {{$d->$c}}
                    </td>
                    @endforeach
                    @if ($config == 'anneescolaire')
                    @php
                        $ln['libannee'] = $d->libannee();
                    @endphp
                    <td> {{$d->libannee()}} </td>
                    @endif 
                    @if ($config == 'matiere') 
                    @php
                        $ln['maternel'] = $d->maternel;
                        $ln['primaire'] = $d->primaire;
                        $ln['secondaire'] = $d->secondaire;
                        $ln['universitaire'] = $d->universitaire;
                    @endphp
                    <td> <input class="center" type="checkbox" onclick="return false"  {{($d->maternel == 1)?"checked = true" : ''}}  /> </td>
                    <td> <input type="checkbox" onclick="return false"  {{($d->primaire == 1)?"checked = true" : ''}}  /> </td>
                    <td> <input type="checkbox" onclick="return false" {{($d->secondaire == 1)?"checked = true" : ''}}  /> </td>
                    <td> <input type="checkbox" onclick="return false" {{($d->universitaire == 1)?"checked = true" : ''}}  /> </td>
                    @endif
                   
                    <td>
                        <div class="flex justify-center items-center">
                            @if(is_array($menusUser) && in_array(3, $menusUser))
                            <a class="flex items-center mr-3" href="/{{$lienModif . $d->id}}" title="Modifier "><img
                                    src="{{asset('assets/img/iconbutton/modif.png')}}"
                                    style="width: 24px;  height: 24px;" /> </a>
                            @endif

                            @if ($config == 'composition')
                            <a class="flex items-center mr-3" href="/details-composition/{{ $d->id}}" title="Détails "> <i class="bi bi-eye"></i> </a>
                            @endif
                            @if ($config == 'utilisateur')
                            @if(is_array($menusUser) && in_array(1, $menusUser))
                            <a class="flex items-center text-danger" href="#" data-toggle="modal"
                               data-target="#modalAffectation{{ $i }}"
                               title="Affectation "> <i class="bi bi-diagram-3-fill"></i>  </a>
                            @endif
                            @if(is_array($menusUser) && in_array(3, $menusUser))
                            <a class="flex items-center " href="#" data-toggle="modal"
                               data-target="#modalReinitPassword"onclick="afficheModalReinit({{$d->id}});"
                               title="Réinitialiser mot de passe "> <img src="{{asset('assets/img/reinitpwd.png')}}"
                                                                      alt="Réinitialiser mot de passe" style="width: 24px;  height: 24px;" /> </a>
                            @endif  

                            @if(is_array($menusUser) && in_array(3, $menusUser))
                            <a class="flex items-center " href="#" data-toggle="modal"
                               data-target="#modalChangeLogin"onclick="afficheModalChangeLogin({{$d->id}},'{{$d->login}}');"
                               title="Modification de login "> <img src="{{asset('assets/img/correction.png')}}"
                                                                 alt="Modification de login" style="width: 24px;  height: 24px;" /> </a>
                            @endif  

                            @endif


                            @if(is_array($menusUser) && in_array(2, $menusUser))
                            <a class="flex items-center text-danger" href="#" onclick="supprimer({{$d->id}});"
                               title="Suprimer "> <img src="{{asset('assets/img/iconbutton/annuler.png')}}"
                                                    alt="Supprimer" style="width: 24px;  height: 24px;" /> </a>
                            @endif    

                            @if ($config == 'apprenant')
                            @php
                             $ln['sexe'] = $d->sexe;
                             $ln['photo'] = $d->photo;
                            @endphp
                            <a class="flex items-center text-danger" href="#" data-toggle="modal"
                               data-target="#modalInscription{{ $i }}"
                            title="Inscription "> <img src="{{asset('assets/img/favicon.png')}}"
                                                       alt="Inscription" style="width: 24px;  height: 24px;" /> </a>

                            <a class="flex items-center text-danger" href="#" data-toggle="modal"
                               data-target="#modalPaiement{{ $i }}"
                               title="Les paiements de l'apprenant "> <i class="bi bi-diagram-3-fill"></i>  </a>
                            @endif


                        </div>
                    </td>

                    @if ($config=='apprenant')
                    <!-- Modal -->                   
                    <!-- Modal Inscription apprenant-->
                    @include('includes.modalInscription', ['libapprenant' => $d->libapprenant, 'idinscription' => $d->idinscription])
                    <!-- Fin Inscription apprenant -->
                    <!-- Modal Paiement apprenant-->
                    @include('includes.modalPaiementApprenant', ['libapprenant' => $d->libapprenant, 'idinscription' => $d->idinscription])
                    <!-- Fin Paiement apprenant -->
                    @endif
                    @if ($config=='utilisateur')
                    <!-- Modal Affectation -->
                    @include("includes.modalAffectation", ['libenseignant' => $d->libpersonne, 'idenseignant' => $d->id])
                    <!-- Fin Modal Affectation -->



                    @endif


                </tr>
                @php
                array_push($donneeimprim, $ln);
                @endphp
                @endforeach
            </tbody>
        </table>
        @php 
            session(['donneeimprim' => $donneeimprim]);
            session(['coltitre' => $coltitre]);
            session(['coldata' => $coldata]);
        @endphp

    </div>
</div>

<!-- </form> -->

@endsection

<script>
    function actualiser() {
    document.forms["myform"].submit();
    }

    function supprimer(id) {
    var rep = confirm("Voulez vous vraiment supprimer cet enregistrement?", okLabel = "oui");
    if (rep) {
    act = '/' + document.getElementById('liensuppr').value + id; //alert(act);
    document.forms["myform"].method = 'GET';
    document.forms["myform"].action = '/' + document.getElementById('liensuppr').value + id;
    document.forms["myform"].submit();
    }
    }


    function afficheModal(cas) {
    // let btn = $('#'+cas);
    let btn = document.getElementById(cas);
    btn.setAttribute("data-toggle", "modal");
    btn.setAttribute("data-target", "#modalAffectation");
    // alert(btn);
    }

    function afficheModalReinit(id) {  //alert(cas);        
    document.getElementById('iduserReinit').value = id;
    }

    function afficheModalPaiement(id) {  //alert(cas);        
    document.getElementById('iduserReinit').value = id;
    }

    function afficheModalChangeLogin(id, login) {  //alert(cas);        
    document.getElementById('iduserChgLogin').value = id;
    document.getElementById('loginchange').value = login;
    document.getElementById('ancienLogin').value = login;
    }

    function validerAffectation(i) {
        let  chps = 'dateaffetation' + i + '|idenseignant' + i + '|idclassannesco' + i;
        let labels = "la date d'affectation|l'enseignant|la classe attribuée";
        let act = '/enregistrer-affectation';
        if (controleVide(chps, labels)) {
        // alert(act);
        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'num';
        newInput.id = 'num';
        newInput.value = i;
        document.forms["formModal" + i].append(newInput);
        document.forms["formModal" + i].method = 'POST';
        document.forms["formModal" + i].action = act;
        document.forms["formModal" + i].submit();
        }

    }

    function validerinscriptionModale(i) {
        let  chps = 'idclassannesco' + i ;
        let labels = "la classe année scolaire";
        let act = '/enregistrer-inscription';
        if (controleVide(chps, labels)) {
        //  alert(act); 
        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'num';
        newInput.id = 'num';
        newInput.value = i;
        document.forms["myformModal" + i].append(newInput);
        document.forms["myformModal" + i].method = 'POST';
        document.forms["myformModal" + i].action = act;
        document.forms["myformModal" + i].submit();
        }

    }

    function supprAffectation(id) {
    var rep = confirm("Voulez vous vraiment supprimer cet enregistrement?", okLabel = "oui");
        if (rep) {
        act = '/supprimer-affectation/' + id; //alert(act);
        document.forms["myform"].method = 'GET';
        document.forms["myform"].action = act;
        document.forms["myform"].submit();
        }
    }

    function retirerAffectation(id) {
    var rep = confirm("Voulez vous vraiment retirer cette classe à cet enseignant?", okLabel = "oui");
        if (rep) {
        act = '/retirer-affectation/' + id; //alert(act);
        document.forms["myform"].method = 'GET';
        document.forms["myform"].action = act;
        document.forms["myform"].submit();
        }
    }



</script>