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

<div class="modal fade" id="modalPaiement{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Liste des paiements de {{ $libapprenant }}
                            </h4>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <section id="admissions" class="admissions section">
                            <div class="container" data-aos="fade-up" data-aos-delay="100">

                                <div class="admissions-steps " style="padding:0px;">
                                    
                                    <div class="steps-wrapper ">
                                        @foreach ($paiements as $p)

                                            <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                                                <div class="step-number">{{ $loop->index + 1 }}</div>                                                
                                                   <div class="col-md-2"><h4>{{$p->datepaiement }}</h4></div> 
                                                    <div class="col-md-2"><h4>{{$p->montant }}</h4></div>
                                                    <div class="col-md-6"><h4>{{$p->deposant }}</h4></div>                                                    
                                                
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <center> <button type="button" class="btn btn-outline-secondary btnarrondi w-20 mr-auto"
                                    data-dismiss="modal"> Fermer</button></center>
                        </section>

                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>