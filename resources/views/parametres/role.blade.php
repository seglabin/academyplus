@extends('layout', ["page_title" => Session('title'), "caspage"=>'liste', "lecas"=>"Liste des profil-utilisateurs","lienAjout"=>'/ajout-role'])

@section('content')
                
                <form class="row" method="GET" id='myform' name='myform' action="/role">
                    @csrf
                    <div class="card-body">
                        <div class="panel-body">
                            <table id="letablo" class="table table-bordered table-striped appliqueDT " scrol>
                                <thead>
                                    <tr>
                                        <th style="width: 15px;">N°</th>
                                        <th>Code</th>
                                        <th>Désignation</th>
                                        <th style="width: 100px;">Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $j = 0;
                                    @endphp
                                    @foreach ($donnees as $i => $d)
                                        <tr>
                                            @php
                                                $j++;
                                            @endphp
                                            <td>
                                                {{$j}}
                                            </td>
                                            <td>
                                                {{$d->code}}
                                            </td>
                                            <td>
                                                {{$d->name}}
                                            </td>
                                            <td>
                                                <div class="flex justify-center items-center">
                                                    <a class="flex items-center mr-3" href="/modifier-role/{{$d->id}}"
                                                        title="Modifier "><img
                                                            src="{{asset('assets/img/iconbutton/modif.png')}}"
                                                            style="width: 24px;  height: 24px;" /> </a>
                                                    <a class="flex items-center text-danger" href="#"
                                                        onclick="supprimer({{$d->id}});" title="Suprimer "> <img
                                                            src="{{asset('assets/img/iconbutton/annuler.png')}}"
                                                            alt="Supprimer" style="width: 24px;  height: 24px;" /> </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </form>
          
@endsection

<script>
    function actualiser() {
        document.forms["myform"].submit();
    }
    function supprimer(id) {
        var rep = confirm("Voulez vous vraiment supprimer cet enregistrement?", okLabel = "oui");
        if (rep) {
            document.forms["myform"].action = '/supprimer-role/' + id;
            document.forms["myform"].submit();
        }
    }
</script>