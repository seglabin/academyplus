@php
use Illuminate\Support\Facades\DB;


$libmotif = ", COALESCE((SELECT libelle FROM elements e WHERE e.id = p.idmotif),' ') AS libmotif ";
$rekete = " SELECT p.* ".$libmotif;
$rekete .= " ";
$rekete .= " FROM paiements p WHERE idinscription = '" . $idinscription . "' ";
$rekete .=" ORDER BY datepaiement ";
// dd($rekete);
$paiements = collect(DB::select($rekete));
//dd($affectations);
@endphp

<div class="modal fade" id="modalCotisationApprenant{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Cotisation {{ $libapprenant }}
                            </h4>
                        </div>
                    </div>

                    <div class="panel-body">

                        <form id='formModalCotisation{{ $i }}' action = "" method="GET">
                            @csrf                                                                       
                                <input type="hidden" id='idanneescolaire{{$i }}' name='idanneescolaire{{$i }}' value="{{ $idanneescolaire }}">
                                <input type="hidden" id='idabonnement{{$i }}' name='idabonnement{{$i }}' value="{{ $idabonnement }}">
                                <input type="hidden" id='idenreg{{$i }}' name='idenreg{{$i }}' value="">
                                <input type="hidden" id='idpayeur{{$i }}' name='idpayeur{{$i }}' value="{{ $d != null ? $d->idinscription : '' }}">
                                <input type="hidden" id='payeur{{$i }}' name='payeur{{$i }}' value="inscriptions">
                                <input type="hidden" id='idmotif{{$i }}' name='idmotif{{$i }}' value="18">
                                <!-- Motif -->
                                <input type="hidden" id='typemvt{{$i }}' name='typemvt{{$i }}' value="E">
                                <div class="row">                                    
                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Date cotisation</label>

                                        <input type="datetime-local" class="form-control rounded-4 "
                                               id="datemvt{{$i }}" name="datemvt{{$i }}"
                                               value="{{ date('Y-m-d H:i:s') }}">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Montant cotisé</label>
                                        <input type="text" class="form-control rounded-4 @error('montant') is-invalid @enderror"
                                               placeholder="Entrez le montant cotisé" onkeyup="typemontant(this);"  id="montant{{ $i }}" name="montant{{ $i }}"
                                               value="">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Référence carte ou pièce</label>
                                        <input type="text" class="form-control rounded-4 @error('reference') is-invalid @enderror"
                                               placeholder="Entrez la référence" onkeyup="enMajuscule('reference');"  id="reference{{ $i }}" name="reference{{ $i }}"
                                               value="">
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
