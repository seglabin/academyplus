@php
    use Illuminate\Support\Facades\DB;


    $libmotif = ", COALESCE((SELECT libelle FROM elements e WHERE e.id = m.idmotif),' ') AS libmotif ";

    $rekete = " SELECT m.* " . $libmotif;
    $rekete .= " ";
    $rekete .= " FROM mvtfinanciers m WHERE idpayeur = '" . $idinscription . "' AND payeur = 'inscriptions' ";
    $rekete .= " ORDER BY datemvt ";
    
    $rekE = " SELECT SUM(montant) tot FROM mvtfinanciers mv  WHERE typemvt = 'E' AND idpayeur = '" . $idinscription . "' AND PAYEUR = 'inscriptions' GROUP BY idpayeur  ";
    $totE = collect(DB::select($rekE));
    $totE = $totE != null && count($totE) > 0 ? $totE->first()->tot : 0;
    $rekS = " SELECT SUM(montant) tot FROM mvtfinanciers mv  WHERE typemvt = 'S' AND idpayeur = '" . $idinscription . "' AND PAYEUR = 'inscriptions' GROUP BY idpayeur  ";
    $totS = collect(DB::select($rekS));
    $totS = $totS != null && count($totS) > 0 ? $totS->first()->tot : 0;    

    $solde = $totE - $totS;
   
    $mvts = collect(DB::select($rekete));

@endphp

<div class="modal fade" id="modalDetailsCotisation{{ $i }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Détails des cotisations de {{ $libapprenant }}
                                <br>
                                <b>Solde cotisation : {{ $solde }}</b>
                            </h4>

                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- <section id="admissions" class="admissions section">
                            <div class="container" style="padding: 0%; margin: 0%;"  data-aos="fade-up" data-aos-delay="100"> -->
                        <table class="table table-bordered table-striped appliqueDT " scrol>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Montant (FCFA)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mvts as $p)
                                    <tr>
                                        <td>{{ formatDateFrancais($p->datemvt) }}</td>
                                        <td>{{ $p->libmotif }}</td>
                                        <td style="text-align: right;">{{ number_format($p->montant, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <center> <button type="button" class="btn btn-outline-secondary btnarrondi w-20 mr-auto"
                            data-dismiss="modal"> Fermer</button></center>
                    <!-- </section> -->

                    <!-- </div> -->
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>