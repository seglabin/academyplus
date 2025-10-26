
@php
use App\Models\apprenant;
use App\Models\personne;
use App\Models\element;
use Illuminate\Support\Facades\DB;

$config = session('config') ? session('config') : '';
//$idenreg = session('idenreg') ? session('idenreg') : '';
$a = $lenregistrement;// ($idenreg != null) ? apprenant::find($idenreg) : null;
$p = null;
//dd($a);
$npi = '';
$idpersonne = '';
$photo = '';
$idap = 0;
if ($a!= null) {
$p =personne::find($a->idpersonne);
//dd($p);
$photo = 'storage/images/apprenants/' . $p->photo;     
$idap =  $a->id;     
$idpersonne =  $a->idpersonne;     
$npi =  $p->npi;     
}


$sexes = element::where('nomtable', 'sexe')
->orderBy('libelle')->get();

$nationalites = element::where('nomtable', 'nationalite')
->orderBy('libelle')->get();

$rek = " SELECT * FROM inscriptions WHERE idclassannesco = '".$idclasEncours."' ";
$rek .= " AND idapprenant = '".$idap."' ";
$rek .= " ORDER BY id DESC LIMIT 1";
$ins = collect( DB::select($rek))->first();
//dd($ins);

@endphp


<input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclasEncours}}">
<input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnementEncours}}">
<input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanEncours}}">
<input type="hidden" id='idpersonne' name='idpersonne' value="{{$idpersonne}}">
<input type="hidden" id='idinscription' name='idinscription' value="{{($ins != null) ? $ins->id:0}}">
<div class="card " style="padding: 20px">
    <div class="row">
        <div class="col-md-10 mb-2">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class=" lelabel" for="">NPI</label>

                    <div class="custom-search">

                        <input type="text" class="custom-search-input"
                               placeholder="Entrez NPI" onchange="" onKeyup="enMajuscule('npi');" id="npi" name="npi"
                               value="{{(isset($leget['npi'])&&$leget['npi']!=null)?$leget['npi']:($npi)}}">
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

                <div class="col-md-3 mb-2">
                    <label class="lelabel" for="">Nationalité</label>
                    @php    
                    echo chargerCombo($nationalites, 'id', 'libelle', 'idnationalite', 'Choisir une nationalité','','',(isset($leget['idnationalite'])&&$leget['idnationalite']!=0)?$leget['idnationalite']:(($a != null) ? $a->idnationalite : old('idnationalite')));
                    @endphp
                </div>    
                <div class="col-md-2 mb-2">
                    <label class="lelabel" for="">Sexe (*)</label>
                    @php              
                    echo chargerCombo($sexes, 'id', 'libelle', 'idsexe', 'Choisir le sexe','',"",(isset($leget['idsexe'])&&$leget['idsexe']!=0)?$leget['idsexe']:(($p != null) ? $p->idsexe : old('idsexe')));
                    @endphp
                </div>    
                <div class="col-md-2 mb-2">
                    <label class=" lelabel" for="">Contact parent (*)</label>
                    <input type="text" class="form-control rounded-4 @error('contactparent') is-invalid @enderror"
                           placeholder="Entrez le contact parent" onKeyup="typetelephone(this);" id="contactparent" name="contactparent"
                           value="{{(isset($leget['contactparent'])&&$leget['contactparent']!=null)?$leget['contactparent']:(($p != null) ? $p->contactparent : old('contactparent'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Nom (*)</label>
                    <input type="text" class="form-control rounded-4 @error('nom') is-invalid @enderror"
                           placeholder="Entrez le nom" onKeyup="enMajuscule('nom');" id="nom" name="nom"
                           value="{{(isset($leget['nom'])&&$leget['nom']!=null)?$leget['nom']:(($p != null) ? $p->nom : old('nom'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Prénoms (*)</label>
                    <input type="text" class="form-control rounded-4 @error('prenoms') is-invalid @enderror"
                           placeholder="Entrez le prénom" onKeyup="enMajuscule('prenoms', 1);" id="prenoms" name="prenoms"
                           value="{{(isset($leget['prenoms'])&&$leget['prenoms']!=null)?$leget['prenoms']:(($p != null) ? $p->prenoms : old('prenoms'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Date de naissance (*)</label>
                    <input type="date" class="form-control rounded-4 @error('datenais') is-invalid @enderror"
                           placeholder="Entrez la date de naissance"  id="datenais" name="datenais"
                           value="{{(isset($leget['datenais'])&&$leget['datenais']!=null)?$leget['datenais']:(($p != null) ? $p->datenais: old('datenais'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Lieu de naissance (*)</label>
                    <input type="text" class="form-control rounded-4 @error('lieunais') is-invalid @enderror"
                           placeholder="Entrez le lieu de naissance"  onKeyup="enMajuscule('lieunais', 0);"  id="lieunais" name="lieunais"
                           value="{{(isset($leget['lieunais'])&&$leget['lieunais']!=null)?$leget['lieunais']:(($p != null) ? $p->lieunais: old('lieunais'))}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Date d'inscription</label>
                    <input type="date" class="form-control rounded-4 @error('dateinscrip') is-invalid @enderror"
                           id="dateinscrip" name="dateinscrip"
                           value="{{($ins != null) ? $ins->dateinscrip: date('Y-m-d')}}">
                </div>

                <div class="col-md-4 mb-2">
                    <label class=" lelabel" for="">Réduction sur frais d'inscription</label>
                    <input type="text" class="form-control rounded-4 @error('reduction') is-invalid @enderror"
                           placeholder="Entrez la réduction sur l'inscription" onkeyup="typemontant(this);"  id="reduction" name="reduction"
                           value="{{ ($ins != null) ? $ins->reduction: old('reduction') }} ">
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-success w-20 mr-auto btnarrondi "
                                onclick="valider('{{ $config }}');">Enregistrer</button>
                    </div>
                    <div class="col-md-6"></div>

                </div>

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
                                        <span class="fileupload-exists btn-small btn-warning" title="Changer"><i class="bi bi-camera"></i></span><input type="file" name="photo" id="photo" value="{{(isset($leget['photo'])&&$leget['photo']!=null)?$leget['photo']:(($a != null) ? $a->photo : old('photo'))}}" /></span>
                                    <span class="btn btn-small btn-danger " data-dismiss="fileupload" title="Supprimer"> <i class="bi bi-trash"></i></span> 
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>
</div>
<script>

    function valider(cas) {
    var chps = '';
    var labels = "";
    var act = '';
    chps = 'idsexe|nom|prenoms|contactparent|datenais|lieunais|dateinscrip';
    labels = "le sexe|le nom|le prénom|le contact parent|la date de naissance|le lieu de naissance|la date d'inscription";
    act = '/enregistrer-apprenant';
        if (controleVide(chps, labels)) {
        // alert(act);
        document.forms["myform"].method = 'POST';
        document.forms["myform"].action = act;
        document.forms["myform"].submit();
        }
    }
</script>