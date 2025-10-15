

@php
use App\Models\apprenant;
use App\Models\element;
use Illuminate\Support\Facades\DB;

$config = session('config') ? session('config') : '';
//$idenreg = session('idenreg') ? session('idenreg') : '';
$a = $lenregistrement;// ($idenreg != null) ? apprenant::find($idenreg) : null;
$photo = '';
$idap = 0;
if ($a) {
$photo = 'storage/images/apprenants/' . $a->photo;     
$idap =  $a->id;     
}


$sexes = element::where('nomtable', 'sexe')
->orderBy('libelle')->get();

$nationalites = element::where('nomtable', 'nationalite')
->orderBy('libelle')->get();

/*$rek = " SELECT * FROM inscriptions WHERE idclassannesco = '".$idclasEncours."' ";
$rek .= " AND idapprenant = '".$idap."' ";
$rek .= " ORDER BY id DESC LIMIT 1";
$ins = collect( DB::select($rek))->first();*/
//dd($ins);

@endphp


<input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclasEncours}}">
<input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnementEncours}}">
<input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanEncours}}">
<div class="card " style="padding: 20px">

    <div class="row">

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

<script>

    function valider(cas) { 
        //alert(cas);
    var chps = '';
    var labels = "";
    var act = '';
    chps = 'idinscription|idmotif|montant';
    labels = "l'apprenant|le motif|le montant payé";
    act = '/enregistrer-paiement';
    if (controleVide(chps, labels)) {
    // alert(act);
    document.forms["myform"].method = 'POST';
    document.forms["myform"].action = act;
    document.forms["myform"].submit();
    }
    }
</script>