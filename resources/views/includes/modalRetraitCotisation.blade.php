@php
use Illuminate\Support\Facades\DB;




/*$rekE = " SELECT idpayeur, SUM(montant) totE  FROM mvtfinanciers WHERE typemvt = 'E' AND idpayeur = '" . $idinscription . "'  AND PAYEUR = 'inscriptions' GROUP BY idpayeur ";
$rekS = "  SELECT idpayeur, SUM(montant) totS  FROM mvtfinanciers WHERE typemvt = 'S' AND idpayeur = '" . $idinscription . "'  AND PAYEUR = 'inscriptions' GROUP BY idpayeur ";

$ent = collect(DB::select($rekE));
$sot = collect(DB::select($rekS));
$E = $ent != null && count($ent) > 0 ? $ent->first()->totE : 0;
$S = $sot != null && count($sot) > 0 ? $sot->first()->totS : 0;
$solde = $E - $S;*/
//dd($affectations);
@endphp

<div class="modal fade" id="modalRetraitCotisation{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Retrait de cotisation {{ $libapprenant }}
                            <br> 
                            Solde cotisation actuel : {{ number_format($solde,0,',',' ') }} FCFA
                            </h4>
                        </div>
                    </div>

                    <div class="panel-body">

                        <form id='formModalCotisation{{ $i }}' action = "" method="GET">
                            @csrf                                                                       
                                <input type="hidden" id='solde{{$i }}' name='solde{{$i }}' value="{{ $solde }}">
                                <input type="hidden" id='idanneescolaire{{$i }}' name='idanneescolaire{{$i }}' value="{{ $idanneescolaire }}">
                                <input type="hidden" id='idabonnement{{$i }}' name='idabonnement{{$i }}' value="{{ $idabonnement }}">
                                <input type="hidden" id='idenreg{{$i }}' name='idenreg{{$i }}' value="">
                                <input type="hidden" id='idpayeur{{$i }}' name='idpayeur{{$i }}' value="{{ $idinscription}}">
                                <input type="hidden" id='payeur{{$i }}' name='payeur{{$i }}' value="inscriptions">
                                <input type="hidden" id='idmotif{{$i }}' name='idmotif{{$i }}' value="19">
                                <!-- Motif Retrait -->
                                <input type="hidden" id='typemvt{{$i }}' name='typemvt{{$i }}' value="S">
                                <div class="row">                                    
                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Date cotisation (*)</label>

                                        <input type="datetime-local" class="form-control rounded-4 "
                                               id="datemvt{{$i }}" name="datemvt{{$i }}"
                                               value="{{ date('Y-m-d H:i:s') }}">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Montant cotisé (*)</label>
                                        <input type="text" class="form-control rounded-4 @error('montant') is-invalid @enderror"
                                               placeholder="Entrez le montant cotisé" onkeyup="typemontant(this);"  id="montant{{ $i }}" name="montant{{ $i }}"
                                              onchange="controlerMontantRetrait('{{ $i }}');"  value="">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Référence carte ou pièce</label>
                                        <input type="text" class="form-control rounded-4 @error('reference') is-invalid @enderror"
                                               placeholder="Entrez la référence" onkeyup="enMajuscule('reference{{ $i }}');"  id="reference{{ $i }}" name="reference{{ $i }}"
                                               value="">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label class=" lelabel" for="">Observations</label>
                                        <textarea class="form-control rounded-4 @error('reference') is-invalid @enderror" name="observations{{ $i }}" id="observations{{ $i }}" cols="3"  onkeyup="enMajuscule('observations{{ $i }}',0);"></textarea>                                       
                                    </div>

                                </div>
                                <div class=" row ">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary w-20 mr-auto"
                                                onclick="validerCotisationModale({{ $i }});">Valider</button>
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-secondary w-20 mr-auto"
                                                data-dismiss="modal"> Annuler</button>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>                             
                        </form>

                    </div>
                </div>

            </div>           
        </div>
    </div>
</div>

<script>
    function controlerMontantRetrait(i){
        let solde = parseFloat(document.getElementById('solde'+i).value);
        let montant = parseFloat(document.getElementById('montant'+i).value.replace(/ /g, ''));
        if(montant > solde){
            alert('Le montant du retrait ne peut pas être supérieur au solde de la cotisation ('+solde+')');
            document.getElementById('montant'+i).value = '';
            document.getElementById('montant'+i).focus();
        }
    }

</script>