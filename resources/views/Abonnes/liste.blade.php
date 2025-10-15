@php
    switch ($module) {
        case 'listeApprenant':
            $modif = 'inscriptionAbonne';
   //         $tires = array('Matricule', 'NPI','Nom', 'Prénoms','contactparent','Classe actuelle','Tot. à payer','Tot. Payé','Reste à payer');
//$cols = array('matricule','npi', 'nom', 'prenoms', 'contactparent','classeactuelle','totscolarite','totpaye','reste');
            $tires = array( 'NPI', 'N° EDUCMASTER', 'Nom', 'Prénoms', 'Contact parent','Tot. à payer','Tot. Payé','Reste à payer');
            $cols = array('npi', 'matricule', 'nom', 'prenoms', 'contactparent','totscolarite','totpaye','reste');
            $lienSuppr = "supprimer-apprenant";
            break;
        case 'listePaiementAbonnement':
            $modif = 'paiementAbonne';
            $tires = array('Date paiement', 'Apprenant', 'Montant payé','Motif', 'Déposant');
            $cols = array('datepaiement', 'libapprenant', 'montant','libmotif', 'deposant');
            $lienSuppr = "supprimer-paiement";
            break;

        case 'listeCompositionAbonne':
            $modif = 'compositionAbonne';
            $tires = array('Date évaluation','Libellé');
            $cols = array('datecompo','libelle');
            $lienSuppr = "supprimer-composition";
            break;       

    }

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
            <tr>
                <td>{{ ($i + 1) }}</td>
                @foreach ($cols as $c)
                    <td>
                        {{$d->$c}}
                    </td>
                @endforeach
                <td>
                    <div class="flex justify-center items-center">
                        @if(is_array($menusUser) && (in_array(3, $menusUser) ||in_array(29, $menusUser)))
                        <a class="flex items-center mr-3" href="#" onclick="modifier('{{ $d->id}}','{{ $modif}}')" title="Modifier "><img
                                src="{{asset('assets/img/iconbutton/modif.png')}}" style="width: 24px;  height: 24px;" />
                        </a>
                        @endif
                         @if ($module == 'listeCompositionAbonne')
                            <a class="flex items-center mr-3" href="/details-composition/{{ $d->id}}" title="Détails "> <i class="bi bi-eye"></i> </a>
                            @endif
                        @if(is_array($menusUser) && (in_array(2, $menusUser)||in_array(30, $menusUser)))
                        <a class="flex items-center text-danger" href="#" onclick="supprimer('{{$d->id}}','{{ $module}}','{{ $lienSuppr}}');"
                            title="Suprimer "> <img src="{{asset('assets/img/iconbutton/annuler.png')}}" alt="Supprimer"
                                style="width: 24px;  height: 24px;" /> </a>
                        @endif        
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    // function modifier(id, module) { //alert(id);
    //     $('#idenreg').val(id);
    //     $('#module').val(module);
    //     document.forms["myform"].method = 'GET';
    //     document.forms["myform"].action = '/classeAbonne';
    //     document.forms["myform"].submit();
    // }
</script>