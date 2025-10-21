@php
    //dd($matieres);
    $coltitre = "N°|Matière|Moy. Interro|Devoir 1|Devoir 2|Moyenne|Coef|Moy. Coef";
    $coldata = "num|libelle|moyinterro|dev1|dev2|moy|coef|moycoef";
    $donneeimprim = array();
@endphp


<table id="letabloz" class="table table-bordered table-striped  " scrol>
    <thead>
        <tr>
            <th style="width: 15px;">N°</th>
            <th>Matière</th>
            <th>Moy. Interro</th>
            <th>Devoir 1</th>
            <th>Devoir 2</th>
            <th>Moyenne</th>
            <th>Coef</th>
            <th>Moy. Coef</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 0;
            $somcoef = 0;
            $somMoycoef = 0;
        @endphp
        @foreach ($donnees as $d)
            @php
                $ln = array();
                $ln['num'] = $i + 1;
                $ln['libelle'] = $d->libelle;
                $ln['moyinterro'] = $d->moyinterro;
                $ln['dev1'] = $d->dev1;
                $ln['dev2'] = $d->dev2;
                $ln['moy'] = $d->moy;
                $ln['coef'] = $d->coef;
                $ln['moycoef'] = $d->moycoef;
                array_push($donneeimprim, $ln);
            @endphp
            <input type="hidden" id="id{{ $i }}" name="id{{ $i }}" value="{{ $d->id }}">
            <input type="hidden" id="idmatiere{{ $i }}" name="idmatiere{{ $i }}" value="{{ $d->idmatiere }}">
            <tr>
                <td>
                    {{$i + 1}}
                </td>
                <td>
                    {{$d->libelle}}
                </td>

                <td>
                    <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number"
                        id="moyIntero{{ $i }}" name="moyIntero{{ $i }}" onchange="actualiseMoyenne();  majMoyperiode();"
                        value="{{ round(floatval($d->moyinterro != null ? $d->moyinterro : -1), 2)}}">
                </td>
                <td>
                    <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number"
                        id="dev1_{{ $i }}" name="dev1_{{ $i }}" onKeyup="controleNote(this);"
                        onchange="majMoyperiode();calculMoyPeriodeMatiere('{{ $i }}'); actualiseMoyenne()"
                        value="{{ round(floatval($d->dev1 != null ? $d->dev1 : -1), 2)}}">
                </td>
                <td>
                    <input style="width:85px;" class="form-control rounded-4 " {{ $disabled }} type="number"
                        id="dev2_{{ $i }}" name="dev2_{{ $i }}" onKeyup="controleNote(this);"
                        onchange="majMoyperiode(); calculMoyPeriodeMatiere('{{ $i }}'); actualiseMoyenne();"
                        value="{{ round(floatval($d->dev2 != null ? $d->dev2 : -1), 2)}}">
                </td>

                <td>
                    <input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="moy{{ $i }}"
                        name="moy{{ $i }}" value="{{ round(floatval($d->moy), 2)}}">
                </td>
                <td>
                    <input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="coef{{ $i }}"
                        name="coef{{ $i }}" value="{{ round(floatval($d->coef), 2)}}">
                </td>
                <td>
                    <input style="width:85px;" class="form-control rounded-4 " type="number" disabled readonly
                        id="moycoef{{ $i }}" name="moycoef{{ $i }}" value="{{ round(floatval($d->moycoef), 2)}}">
                </td>

            </tr>
            @php
                $i++;
                $somcoef += $d->coef;
                $somMoycoef += $d->moycoef;
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="totcoef"
                    name="totcoef" value="{{ round(floatval($somcoef)) }}"></td>
            <td><input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="total"
                    name="total" value="{{ round(floatval($somMoycoef), 2) }}"></td>
        </tr>
        <tr>
            @php
                $moyT = $somMoycoef / ($somcoef != 0 ? $somcoef : 1);
            @endphp
            <td></td>
            <td>Moyenne périodique</td>
            <td></td>
            <td></td>
            <td></td>
            <td><input style="width:85px;" class="form-control rounded-4 " type="number" readonly id="moyperiod"
                    name="moyperiod" value="{{ round(floatval($moyT), 2) }}"></td>
        </tr>
        <input type="hidden" id="taille" name="taille" value="{{ $i }}">
    </tbody>
</table>
@php 

   $ln['num'] = '';
    $ln['libelle'] = "Total";
    $ln['moyinterro'] = '';
    $ln['dev1'] = '';
    $ln['dev2'] = '';
    $ln['moy'] = '';
    $ln['coef'] = $somcoef;
    $ln['moycoef'] = $somMoycoef;
    array_push($donneeimprim, $ln);
    
   $ln['num'] = '';
    $ln['libelle'] = "Moyenne périodique";
    $ln['moyinterro'] = '';
    $ln['dev1'] = '';
    $ln['dev2'] = '';
    $ln['moy'] = round(floatval($moyT), 2);
    $ln['coef'] = '';
    $ln['moycoef'] = '';
    array_push($donneeimprim, $ln);


    session(['donneeimprim' => $donneeimprim]);
    session(['coltitre' => $coltitre]);
    session(['coldata' => $coldata]);

@endphp