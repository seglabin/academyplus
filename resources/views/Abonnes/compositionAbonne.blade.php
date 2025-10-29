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
        $idap = $a->id;
    }


    $sexes = element::where('nomtable', 'sexe')
        ->orderBy('libelle')->get();

    $nationalites = element::where('nomtable', 'nationalite')
        ->orderBy('libelle')->get();


    //dd($ins);

@endphp


<input type="hidden" id='idclassannesco' name='idclassannesco' value="{{$idclasEncours}}">
<input type="hidden" id='idabonnement' name='idabonnement' value="{{$idabonnementEncours}}">
<input type="hidden" id='idanneescolaire' name='idanneescolaire' value="{{$idanEncours}}">
<div class="card " style="padding: 20px">

    <div class="row">

        <div class="col-md-2 mb-2">
            <div class="card-tools" style="position:left;">
                <a class="btn btn-outline-info btnarrondi" href="#" onclick="history.go( - 1);" style="position:left;"> <i
                        class="bi bi-arrow-left"></i> Retour</a>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <label class=" lelabel" for="">Libellé (*)</label>
            <input type="text" class="form-control rounded-4 " placeholder="Entrez le libellé"
                onKeyup="enMajuscule('libelle', 0);" id="libelle" name="libelle"
                value="{{($a != null) ? $a->libelle : old('libelle')}}">
        </div>

        <div class="col-md-2 mb-2">
            <label class=" lelabel" for="">Date évaluation (*)</label>
            <input type="date" class="form-control rounded-4 " id="datecompo" name="datecompo"
                value="{{($a != null) ? $a->datecompo : date('Y-m-d')}}">
        </div>

        <div class="col-md-1 mb-2">
            <label class=" lelabel" for="">Barême</label>
            <input type="number" class="form-control rounded-4 " placeholder="Entrez le barême" id="barem" name="barem"
                value="{{($a != null) ? $a->barem : 20}}">
        </div>

        <div class="col-md-12 mb-2">
            <table id="letabloz" class="table table-bordered table-striped  " scrol>
                <thead>
                    <tr>
                        <th style="width: 15px;">N°</th>
                        <th>Apprenant</th>
                        @foreach($matieres as $m)
                            <th>{{ $m->abreviation }}</th>
                        @endforeach
                        <th>Total</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($donnees as $d)
                        <input type="hidden" id="id{{ $i }}" name="id{{ $i }}" value="{{ $d->id }}">
                        <input type="hidden" id="idinscription{{ $i }}" name="idinscription{{ $i }}"
                            value="{{ $d->idinscription }}">
                        <tr>
                            <td>
                                {{$i + 1}}
                            </td>
                            @php
                                $total = 0;
                            @endphp
                            <td>
                                {{$d->libapprenant}}
                            </td>
                            @foreach($matieres as $j => $m)
                                @php
                                    $v = "m" . $j + 1;
                                    $va = ($d->$v != null) ? floatval($d->$v) : 0;
                                    $total += ($va > 0) ? floatval($va) : 0;
                                 @endphp
                                <td>
                                    <input style="width:65px;" type="number" id="{{ $v }}_{{ $i }}" name="{{ $v }}_{{ $i }}"
                                        onKeyup="controleNote(this);" onchange="calculMoyenne('{{ $i }}');"
                                        value="{{ $d->$v != null ? $d->$v : -1}}">
                                </td>
                            @endforeach
                            @if($j < 12)
                                @for($k = $j + 2; $k <= 12; $k++)
                                    <input style="width:65px;" type="hidden" id="m{{ $k }}_{{ $i }}" name="m{{ $k }}_{{ $i }}"
                                        value="-1">
                                @endfor

                            @endif
                            <td>
                                <input style="width:65px;" type="number" readonly id="total{{ $i }}"
                                    name="total{{ $i }}" value="{{ round($total, 3)}}">
                            </td>
                            <td>
                                <input style="width:65px;" type="number" readonly id="moyenne{{ $i }}"
                                    name="moyenne{{ $i }}" value="{{ round(floatval($d->moyenne), 3)}}">
                            </td>

                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <input type="hidden" id="taille" name="taille" value="{{ $i }}">
                </tbody>
            </table>
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
        chps = 'libelle|datecompo';
        labels = "libellé|date d'évaluation";
        act = '/enregistrer-composition';
        if (controleVide(chps, labels)) {
            // alert(act);
            document.forms["myform"].method = 'POST';
            document.forms["myform"].action = act;
            document.forms["myform"].submit();
        }
    }
</script>