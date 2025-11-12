@php
use Illuminate\Support\Facades\DB;

@endphp
<div class="modal fade" id="modalPaiementScolarite{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Paiement de frais de scolarité {{ $libapprenant }}
                            </h4>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                                                
                        <form id='formModalPaiement{{ $i }}' action = "" method="GET">
                            @csrf                                                                       
                                <input type="hidden" id='idanneescolaire{{$i }}' name='idanneescolaire{{$i }}' value="{{ $idanneescolaire }}">
                                <input type="hidden" id='idabonnement{{$i }}' name='idabonnement{{$i }}' value="{{ $idabonnement }}">
                                <input type="hidden" id='idenreg{{$i }}' name='idenreg{{$i }}' value="">
                                <input type="hidden" id='idinscription{{$i }}' name='idinscription{{$i }}' value="{{ $d != null ? $d->idinscription : '' }}">
                                <input type="hidden" id='idmotif{{$i }}' name='idmotif{{$i }}' value="9">
                                <!-- Motif scolarité -->
                                <div class="row">                                    
                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Date paiement</label>

                                        <input type="date" class="form-control rounded-4 "
                                               id="datepaiement{{$i }}" name="datepaiement{{$i }}"
                                               value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Montant payé</label>
                                        <input type="text" class="form-control rounded-4 @error('montantP') is-invalid @enderror"
                                               placeholder="Entrez le montant payé" onkeyup="typemontant(this);"  id="montantP{{ $i }}" name="montantP{{ $i }}"
                                               value="">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Déposant</label>
                                        <input type="text" class="form-control rounded-4 @error('deposant') is-invalid @enderror"
                                               placeholder="Entrez le déposant" onkeyup="enMajuscule('deposant{{ $i }}');"  id="deposant{{ $i }}" name="deposant{{ $i }}"
                                               value="">
                                    </div>

                                </div>
                                <div class=" row ">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary w-20 mr-auto"
                                                onclick="validerPaiementModale({{ $i }});">Valider</button>
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
