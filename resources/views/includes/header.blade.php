<!-- Page Title -->
 
@php
      use Illuminate\Support\Facades\DB;

        $config = (session('config')!=null)? session('config'):'accueil';
        $userEncours = (session('userEncours')!=null)? session('userEncours'):null;
        $anEncours = (session('anEncours')!=null)? session('anEncours'):null;
        $idanEncours = (session('idanEncours')!=null)? session('idanEncours'):null;
        
        $laclassEncour = (session('laclassEncour')!=null)? session('laclassEncour'):null;
        $abonnementEncours = (session('abonnementEncours')!=null)? session('abonnementEncours'):null;
        $img =($abonnementEncours != null && $abonnementEncours->logo!= null )?$abonnementEncours->logo:null;
        

      //$annescolaires = 'App\Models\anneescolaire'::
       
        $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
        $annescolaires = collect(DB::select($rekan));
        //dd($annescolaires);

        $laclas = ($laclassEncour)? $laclassEncour->libclasse():'';

  
 @endphp

<div class="page-title dark-background" >
    <!-- <form action="" id="myform"  method="GET"> -->
<input type="hidden" id="changeAnSel" name="changeAnSel" value="">
            <div class="row">
                <div class="col-md-4" style="position:left;"> 
                    @if($img != null)
                                <!-- <img src="assets/img/logo.webp" alt="KK"> -->
                            <img class="imgAbonne" src="../../storage/images/{{ $img }}" alt="KK" >
                            @else

                            @endif
                    <span  class="btn btn-success">
                    <b>{{($abonnementEncours)? $abonnementEncours->designation :"Administrateur" }}</b> 
                    
                    </span>
                </div>
                <div class="col-md-4" style="position:right;">
                    @if ($laclas !='')
                    <span  class="btn btn-success">
                            <b>{{ $laclas  }}</b>                             
                        </span>
                    
                    @endif
                    
                </div> 
                <div class="col-md-4">
                    <!-- <center>  -->
                        <span  class="btn btn-success">
                        <b>Année scolaire : </b> 
                        @php        
                echo chargerCombo($annescolaires, 'id', 'libannee', 'idanSela', 'Choisir une année scolaire','',"changeAnneeSel('$config')",$idanEncours);
                @endphp                 
                    </span>
                <!-- </center> -->
                    </div>
            </div> 
            <div class="container position-relative">
                <div class="row">
        
                    @if ($caspage == 'form')
                    <div class="col-md-2">
                            <div class="card-tools" style="position:left;">
                                <a class="btn btn-info btnarrondi" href="#" onclick="history.go( - 1);"
                                    style="position:left;"> <i class="bi bi-arrow-left"></i> Retour</a>
                            </div>
                        </div>
                        @endif
                    <div class="col-md-10">
                        <h1>{{$lecas}}</h1>
                        {{--<p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda
                            numquam
                            molestias.</p>--}}
                    </div>
                    @if ($caspage == 'liste')
                    <div class="col-md-2">
                            @if(is_array($menusUser) && in_array(1, $menusUser))
                    <div class="card-tools" style="position:right;">
                                <a class="btn btn-success btnarrondi" href="#" onclick="ajouter('{{ $lienAjout }}');"
                                    style="position:right;"> <i class="bi  bi-plus-circle"></i> Ajouter</a>
                            </div>
                            @endif
                        </div>
                        @endif
                </div>
                <!-- <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li class="current">Academics</li>
                    </ol>
                </nav> -->
            </div>
    <!-- </form> -->
</div>
<!-- End Page Title -->
 <script>
    function actualiserHeader() {
         document.forms["formHeader"].submit();
    }

    // function changeAnneeSel(conf) {
    //     $('#changeAnSel').val(1);
    //     var cf = "/changer-anneescolaire";
    //     document.forms["myform"].action = cf;
    //     document.forms["myform"].method = 'GET';
    //         document.forms["myform"].submit();
    // }
 </script>