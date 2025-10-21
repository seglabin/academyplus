@php
    //dd($matieres);
    $coltitre = "N°|Apprenants";
    $coldata = "num|libapprenant";
@endphp


<table id="letabloz" class="table table-bordered table-striped  " scrol>
    <thead>
        <tr>
            <th style="width: 15px;">N°</th>
            <th>Apprenants</th>
            @foreach ($matieres as $k => $m)
                @php
                    $coltitre .= "|" . $m->abreviation . '|Coef';
                    $coldata .= "|m" . $k . "|coef" . $k;
                @endphp
                <th>{{ $m->abreviation }}</th>
                <th>Coef</th>
            @endforeach
            <th>Tot. Coef</th>
            <th>Tot. Moy</th>
            <th>Moyenne</th>
            <th>Rang</th>
        </tr>
    </thead>
    <tbody>
        @php
            $coltitre .= "|Tot. Coef|Tot. Moy|Moyenne|Rang";
            $coldata .= "|totcoef|totmoy|moy|rang";
            $i = 0;
            $donneeimprim = array();

        @endphp
        @foreach ($donnees as $d)
                    @php
                        $ln = array();
                        $ln['num'] = $i + 1;
                        $ln['libapprenant'] = $d->libapprenant;
                    @endphp
                    <input type="hidden" id="id{{ $i }}" name="id{{ $i }}" value="{{ $d->id }}">
                    <tr>
                        <td>
                            {{$i + 1}}
                        </td>
                        <td>
                            {{$d->libapprenant}}
                        </td>
                        @php
                            $somcoef = 0;
                            $somMoycoef = 0;
                        @endphp

                        @foreach ($matieres as $k => $m)
                            @php
                                $v = 'm' . $k;
                                $vc = 'coef' . $k;
                                $ln[$v] = $d->$v;
                                $ln[$vc] = $d->$vc;

                            @endphp
                            <td>
                                {{$d->$v}}
                            </td>
                            <td>
                                {{$d->$vc}}
                            </td>
                        @endforeach
                        @php //totcoef|totmoy|moy|rang
                            $ln['totcoef'] = $d->somcoef;
                            $ln['totmoy'] = $d->somMoycoef;
                            $ln['moy'] = $d->moy;
                            $ln['rang'] = $d->rang;
                            array_push($donneeimprim, $ln);
                        @endphp
                            <
            td>                {{$d->somcoef}}
                    </td>
                           <td>                {{$d->somMoycoef}}
                    </td>
                    <td>                 
                    {{ $d->moy }}
                </td>            <td>                 
                                    {{ $d->rang }}
                  </td>
                            </tr>
                            @php
                                $i++;                
                            @endphp
        @endforeach
       
        @php 
            session(['donneeimprim' => $donneeimprim]);
            session(['coltitre' => $coltitre]);
            session(['coldata' => $coldata]);

        @endphp
        <input type="hidden" id="taille" name="taille" value="{{ $i }}">
    </tbody>
</table>
