@php
    $tires = array();
    $cols = array();
    $coltitre = "";
    $coldata = "";
    $donneeimprim = array();

    switch ($module) {
        case 'listeApprenant':
            $modif = 'inscriptionAbonne';
            $coltitre .= "NPI|N° EDUCMASTER|Nom|Prénoms|Contact parent|Tot. à payer|Tot. Payé|Reste à payer";
            $coldata .= "npi|matricule|nom|prenoms|contactparent|totscolarite|totpaye|reste";
            $tires = explode('|', $coltitre);
            $cols = explode('|', $coldata);
            $lienSuppr = "supprimer-apprenant";
            break;
        case 'listePaiementAbonnement':
            $modif = 'paiementAbonne';
            $coltitre .= "Date paiement|Apprenant|Montant payé|Motif|Déposant";
            $coldata .= "datepaiement|libapprenant|montant|libmotif|deposant";
            $tires = explode('|', $coltitre);
            $cols = explode('|', $coldata);
            $lienSuppr = "supprimer-paiement";
            break;

        case 'listeCompositionAbonne':
            $modif = 'compositionAbonne';
            $coltitre .= "Date évaluation|Libellé";
            $coldata .= "datecompo|libelle";
            $tires = explode('|', $coltitre);
            $cols = explode('|', $coldata);
            $lienSuppr = "supprimer-composition";
            break;

    }

    $coltitre = "N°|" . $coltitre;
    $coldata = "num|" . $coldata;
@endphp

<table id="letablo" class="table table-bordered table-striped appliqueDT " scrol>
    <thead>
        <tr>
            <th style="width: 15px;">N°</th>
            @foreach ($tires as $t)
                <th>{{ $t }}</th>
            @endforeach
            <th> Actions </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donnees as $i => $d)
            @php
                $ln = array();
                $ln['num'] = $i + 1;                    
            @endphp
            <tr>
                <td>{{ ($i + 1) }}</td>
                @foreach ($cols as $c)
                    <td>
                        @php
                            $ln[$c] = $d->$c;
                        @endphp
                        {{$d->$c}}
                    </td>
                @endforeach
                <td>
                    <div class="flex justify-center items-center">
                        @if(is_array($menusUser) && (in_array(3, $menusUser) || in_array(29, $menusUser)))
                            <a class="flex items-center mr-3" href="#" onclick="modifier('{{ $d->id}}','{{ $modif}}')"
                                title="Modifier "><img src="{{asset('assets/img/iconbutton/modif.png')}}"
                                    style="width: 24px;  height: 24px;" />
                            </a>
                        @endif
                        @if ($module == 'listeCompositionAbonne')
                            <a class="flex items-center mr-3" href="/details-composition/{{ $d->id}}" title="Détails "> <i
                                    class="bi bi-eye"></i> </a>
                        @endif
                        @if(is_array($menusUser) && (in_array(2, $menusUser) || in_array(30, $menusUser)))
                            <a class="flex items-center text-danger" href="#"
                                onclick="supprimer('{{$d->id}}','{{ $module}}','{{ $lienSuppr}}');" title="Suprimer "> <img
                                    src="{{asset('assets/img/iconbutton/annuler.png')}}" alt="Supprimer"
                                    style="width: 24px;  height: 24px;" /> </a>
                        @endif
                    </div>
                </td>
            </tr>
            @php
                array_push($donneeimprim, $ln);
            @endphp
        @endforeach
    </tbody>
</table>
@php 
    session(['donneeimprim' => $donneeimprim]);
    session(['coltitre' => $coltitre]);
    session(['coldata' => $coldata]);
@endphp
<script>
    // function modifier(id, module) { //alert(id);
    //     $('#idenreg').val(id);
    //     $('#module').val(module);
    //     document.forms["myform"].method = 'GET';
    //     document.forms["myform"].action = '/classeAbonne';
    //     document.forms["myform"].submit();
    // }
</script>