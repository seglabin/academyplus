@php
$lecas = "";
    $lienAjout = "";
    $lienModif = "";
@endphp

@extends('layout', ["page_title"=> Session('title'),"caspage" => 'doublon',"lecas" => $lecas, "lienAjout" => $lienAjout])

@section('content')

    @php
$tit =($titre !=null)?$titre:"Doublon d'information";
            @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round" style="padding: 20px">

                <div class="card-product" style="background-color: #f1f5f9">
                    <form id='myform' action = ""  method="GET">
                        @csrf
                        <div class="card-body">
                            <!-- Content Wrapper. Contains page content -->
                            <div class="content-wrapper">

                                <!-- Main content -->
                                <section class="content">
                                    <div class="error-page">
                                        <h2 class="headline text-warning-emphasis">{{$tit}}</h2>

                                        <div class="error-content">
                                            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! {{$info}}.</h3>

                                            <div class="input-group-append">
                                                <a class="btn btnarrondi btn-outline-primary" onclick="history.go(-1);"> <i class="fas fa-arrow-left"></i> Retour</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.error-page -->

                                </section>
                                <!-- /.content -->
                            </div>
                            <!-- /.content-wrapper -->

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

<script>

</script>
