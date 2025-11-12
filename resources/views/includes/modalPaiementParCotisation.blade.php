@php
use Illuminate\Support\Facades\DB;


@endphp

<div class="modal fade" id="modalPaiementParCotisation{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Payer les frais de scolarité par la cotisation {{ $libapprenant }}
                            <br> 
                            Solde cotisation actuel : {{ number_format($solde,0,',',' ') }} FCFA
                            </h4>
                        </div>
                    </div>

                    <div class="panel-body">

                        <form id='formModalPaiementParCotisation{{ $i }}' action = "" method="GET">
                            @csrf                                                                       
                                <input type="hidden" id='solde{{$i }}' name='solde{{$i }}' value="{{ $solde }}">
                                <input type="hidden" id='idanneescolaire{{$i }}' name='idanneescolaire{{$i }}' value="{{ $idanneescolaire }}">
                                <input type="hidden" id='idabonnement{{$i }}' name='idabonnement{{$i }}' value="{{ $idabonnement }}">
                                <input type="hidden" id='idenreg{{$i }}' name='idenreg{{$i }}' value="">
                                <input type="hidden" id='idpayeur{{$i }}' name='idpayeur{{$i }}' value="{{ $idinscription}}">
                                <input type="hidden" id='payeur{{$i }}' name='payeur{{$i }}' value="inscriptions">
                                <input type="hidden" id='idmotif{{$i }}' name='idmotif{{$i }}' value="19">
                                <input type="hidden" id='deposant{{$i }}' name='deposant{{$i }}' value="COTISATION">
                                <!-- Motif Retrait -->
                                <input type="hidden" id='typemvt{{$i }}' name='typemvt{{$i }}' value="S">
                                <div class="row">                                    
                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Date paiement (*)</label>

                                        <input type="datetime-local" class="form-control rounded-4 "
                                               id="datemvt{{$i }}" name="datemvt{{$i }}"
                                               value="{{ date('Y-m-d H:i:s') }}">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Montant paiement (*)</label>
                                        <input type="text" class="form-control rounded-4 @error('montant') is-invalid @enderror"
                                               placeholder="Entrez le montant cotisé" onkeyup="typemontant(this);"  id="montantPC{{ $i }}" name="montantPC{{ $i }}"
                                              onchange="controlerMontantRetrait('{{ $i }}');"  value="">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class=" lelabel" for="">Référence carte ou pièce</label>
                                        <input type="text" class="form-control rounded-4 @error('reference') is-invalid @enderror"
                                               placeholder="Entrez la référence" onkeyup="enMajuscule('referencePC{{ $i }}');"  id="referencePC{{ $i }}" name="referencePC{{ $i }}"
                                               value="">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label class=" lelabel" for="">Observations</label>
                                        <textarea class="form-control rounded-4 @error('observations') is-invalid @enderror" name="observationsPC{{ $i }}" id="observationsPC{{ $i }}" cols="3"  onkeyup="enMajuscule('observationsPC{{ $i }}',1);"></textarea>                                       
                                    </div>

                                </div>
                                <div class=" row ">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary w-20 mr-auto"
                                                onclick="validerPaiementParCotisation({{ $i }});">Valider</button>
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
        let montant = parseFloat(document.getElementById('montantPC'+i).value.replace(/ /g, ''));
        if(montant > solde){
            alert('Le montant du retrait ne peut pas être supérieur au solde de la cotisation ('+solde+')');
            document.getElementById('montantPC'+i).value = '';
            document.getElementById('montantPC'+i).focus();
        }
    }

</script>