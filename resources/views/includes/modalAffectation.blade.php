@php
    use App\Models\affectation;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    //$u = User::find($d->id);
    $idanEncours = (session('idanEncours') != null) ? session('idanEncours') : null;
  
  $idabonnementEncours = (session('idabonnementEncours') != null) ? session('idabonnementEncours') : null;


    $libmat = ", COALESCE((SELECT libelle FROM matieres m WHERE m.id = a.idmatiere),' ') AS libmatiere ";
    $rekete = " SELECT a.*, c.libelle, sigle, CONCAT(c.libelle,' ',groupe) AS libclasse  ".$libmat ;
    $rekete .= " ";
    $rekete .= " FROM affectations a, classannescos ca, classetypes c ";
    $rekete .= " WHERE c.id = ca.idclasse AND a.idclassannesco = ca.id  ";
    $rekete .= " AND idclassannesco IN ( SELECT id FROM classannescos WHERE  idanneescolaire = '" . $idanEncours . "' ) ";
    $rekete .= " AND idenseignant = '" . $d->id . "' AND desactive = false ";
   // dd($rekete);
    $affectations = collect(DB::select($rekete));
    //dd($affectations);
@endphp
<div class="modal fade" id="modalAffectation{{ $i }}">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <input type="hidden" id="num" value="{{ $i }}">

            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Attribution de classes à :
                                {{ $d->libpersonne }}
                            </h4>

                        </div>
                    </div>
                    @php
                        //$c = $client ;
                        $c = null;
                    @endphp

                    <form class="form-horizontal" method="post" name="formModal{{ $i }}" id="formModal{{ $i }}"
                        action="">
                        <!-- <div class="panel panel-success setup-content active"> -->
                        @csrf

                        <div class="panel-body">
                            <div id="info" class="validateTips"></div>
                            <div id="zoneadd"> </div>
                            <div id="zoneChangeClasse"> </div>
                            <input type="hidden" name="idenseignant{{ $i }}" id="idenseignant{{ $i }}"
                                value="{{ $idenseignant }}" />
                            <div class="row">
                                <!-- <div class="col-md-6"></div> -->
                                <div class="col-md-6">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Date Affectation (*)</label>
                                        <input type="date" name="dateaffetation{{ $i }}" id="dateaffetation{{ $i }}"
                                            class="form-control rounded-4 " value="{{  date('Y-m-d')}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Classe (*)</label>
                                        <?php
echo chargerComboSimple($classannescos, 'id', 'libclasse', 'idclassannesco' . $i, 'Choisir une classe', '', '', '');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Matière </label>
                                        <?php
echo chargerComboSimple($matieres, 'id', 'libelle', 'idmatiere' . $i, 'Choisir une matière', '', '', '');
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="btn-group centrer-contenu-horizontal">
                                <div class=" row ">

                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-primary btnarrondi w-20 mr-auto"
                                            onclick="validerAffectation('{{ $i }}');">Valider</button>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-secondary btnarrondi w-20 mr-auto"
                                            data-dismiss="modal">
                                            Annuler</button>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>
                            </div>

                            <!-- </div> -->
                    </form>


                </div>
            </div>

        </div>
        <!-- <div class="modal-footer justify-content-between">
            <div class=" row d-flex justify-content-center"> -->
        <!-- <div class="box">
                    <div class="box-body"> -->
        <section id="admissions" class="admissions section" >
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="admissions-steps mt-5" style="padding:10px;">
                    <h3>Les classes et matières attribuées à {{$libenseignant}}</h3>
                    <div class="steps-wrapper mt-4">
                        @foreach ($affectations as $af)

                            <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="step-number">{{ $loop->index + 1 }}</div>
                                <div class="step-content">
                                    <h4>{{$af->libclasse }}</h4>
                                    <p>{{$af->libmatiere }}
                                    <button type="button" class="btn btn-outline-warning btnarrondi w-20 mr-auto"
                                            onclick="retirerAffectation('{{ $af->id }}');">Retirer</button>
                                    <button type="button" class="btn btn-outline-danger btnarrondi w-20 mr-auto"
                                            onclick="supprAffectation('{{ $af->id }}');">Supprimer</button>
                                  
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>

</div>
</div>

<script>
    $('.select2').select2();

    function validerAffectationaa() {
        var idenseignant = $('#idenseignant{{ $i }}').val();
        var idclassannesco = $('#idclassannesco{{ $i }}').val();
        var idmatiere = $('#idmatiere{{ $i }}').val();
        var dateaffetation = $('#dateaffetation{{ $i }}').val();
        let num = $('#num').val();
        alert(num);
        if (idclassannesco == '' || idenseignant == '' || dateaffetation == '') {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        $.ajax({
            url: '/enregistrer-affectation',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                idenseignant: idenseignant,
                idclassannesco: idclassannesco,
                idmatiere: idmatiere,
                dateaffetation: dateaffetation
            },
            success: function (response) {
                if (response.success) {
                    alert('Affectation réussie !');
                    location.reload(); // Recharger la page pour voir les changements
                } else {
                    alert('Erreur lors de l\'affectation : ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Une erreur est survenue : ' + error);
            }
        });
    }
</script>