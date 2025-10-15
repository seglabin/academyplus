<div class="modal fade" id="modalInscription{{ $i }}">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inscription de {{ $d->nom ." ".$d->prenoms }}</h4>

            </div>
            <div class="modal-body">
                
                @php
                //$c = $client ; lesclassesAnnesco($iduser, $idrole, $idabonnement, $idan)
                
                if(count($classannescos) == 0){
                $u = Auth::user();
                //dd($u);
                $idan = (session('idanEncours')!=null)? session('idanEncours'):null;
                $classannescos = lesclassesAnnesco($u->id, $u->idrole, $idabonnement, $idan);
                }
                $c = null;
                @endphp
                <form id='myformModal{{ $i }}' action = "" method="GET">
                    @csrf
                    <div class="card-body">                                            
                        <input type="hidden" id='idenreg{{$i }}' name='idenreg{{$i }}' value="">
                        <input type="hidden" id='idapprenant{{$i }}' name='idapprenant{{$i }}' value="{{ $d != null ? $d->id : '' }}">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="lelabel" for="">Classe Année scolaire</label>
                                @php              
                                echo chargerComboSimple($classannescos, 'id', 'libclasse', 'idclassannesco'.$i, 'Choisir une année scolaire','',"",$idclassannesco);
                                @endphp
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class=" lelabel" for="">Date d'inscription</label>
                                <input type="date" class="form-control rounded-4 "
                                       id="dateinscrip{{$i }}" name="dateinscrip{{$i }}"
                                       value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class=" lelabel" for="">Réduction sur frais</label>
                                <input type="text" class="form-control rounded-4 @error('reduction') is-invalid @enderror"
                                       placeholder="Entrez la réduction sur l'inscription" onkeyup="typemontant(this);"  id="reduction{{ $i }}" name="reduction{{ $i }}"
                                       value="">
                            </div>

                        </div> 
                    </div> 
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <!--<div class=" row d-flex justify-content-center">-->

                <!--</div>-->
                <div class=" row ">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary w-20 mr-auto"
                                onclick="validerinscriptionModale({{ $i }});">Valider</button>
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
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>