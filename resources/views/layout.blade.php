<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Academy Plus</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    @include('includes.css')
    <style>
        .lebody {
            /* background-image: url({{ asset('assets/img/slide/bg0.jpg')}} ); */
            background-color: #212529;
        }

        .corps {
            /* border: 2px solid var(--contrast-color); */
            margin-top: 70px;
            background-color: antiquewhite;
            padding: 20px;
            border-radius: 10px;
        }

        .letitre {
            text-align: center;
            padding-bottom: 10px;
            /* padding-bottom: 60px; */
            position: relative;
        }

        .btnarrondi {
            border-radius: 20px;
        }

        .lelabel {
            font-size: 16px;
            font-weight: bold;
        }

        .custom-search {
            position: relative;
            /* width: 300px; */
        }

        .custom-search-input {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 100px;
            padding: 10px 100px 10px 20px;
            line-height: 1;
            box-sizing: border-box;
            outline: none;
        }

        .custom-search-botton {
            position: absolute;
            right: 3px;
            top: 3px;
            bottom: 3px;
            border: 0;
            background: #977d88ff;
            color: #fff;
            outline: none;
            margin: 0;
            padding: 0 10px;
            border-radius: 100px;
            z-index: 2;
        }
    </style>

    <!-- =======================================================
      * Template Name: NiceSchool
      * Template URL: https://bootstrapmade.com/nice-school-bootstrap-education-template/
      * Updated: May 10 2025 with Bootstrap v5.3.6
      * Author: BootstrapMade.com
      * License: https://bootstrapmade.com/license/
      ======================================================== -->


</head>

<body class="index-page lebody">

    @php
        use Illuminate\Support\Facades\DB;

        $rek = "SELECT DISTINCT login FROM users ";
        $tlogin = collect(DB::select($rek));

        $logins = '';

        foreach ($tlogin as $lg) {
            $logins .= ($logins != '') ? '|' : '';
            $logins .= $lg->login;
        }
        $menusUser = (session('menusUser') != null) ? session('menusUser') : null;

        $caspage = isset($caspage) ? $caspage : '';
        $clbody = $caspage != '' ? 'corps' : '';
        //dd($caspage);
        $idclasEncours = (session('idclassannescosEncours') != null) ? session('idclassannescosEncours') : null;
        $userEncours = (session('userEncours') != null) ? session('userEncours') : null;
        $anEncours = (session('anEncours') != null) ? session('anEncours') : null;
        $idenreg = (session('idenreg') != null) ? session('idenreg') : null;
        $abonnementEncours = (session('abonnementEncours') != null) ? session('abonnementEncours') : null;
        $img = ($abonnementEncours != null && $abonnementEncours->logo != null) ? $abonnementEncours->logo : null;
    @endphp

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <i class="bi bi-buildings"></i>
                <h12 class="sitename">AcademyPlus</h1>
            </a>

            <!-- nav  -->
            @include('includes.nav')
            {{--@include('includes.menuAbonne')--}}
        </div>
    </header>

    <main class="main {{ $clbody }}">

        <form id='myform' name="myform" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idclassannescosEncours" id="idclassannescosEncours" value="{{ $idclasEncours }}">
            <input type="hidden" id='idenreg' name='idenreg' value="{{$idenreg}}">
            <input type="hidden" id='idanSel' name='idanSel' value="">
            <div id="zoneadd" name="zoneadd"> </div>

            @if($caspage == '')
                {{--@include('includes.headerAccueil')--}}
            @else
                @include('includes.header')
                {{--@switch($caspage)
                @case('listeClasse')
                @include('includes.headerAbonne')
                @break
                @default
                @include('includes.header')
                @break

                @endswitch--}}
                <div class="card " style="padding: 20px">
            @endif

                <!-- Modal Changer password -->
                @include('includes.modalChangePassword')
                <!-- Fin Modal Changer password -->


                <!-- Modal reinit password -->
                @include('includes.modalReinitPassword')
                <!-- Fin Modal reinit password -->

                <!-- Modal change login -->
                @include('includes.modalChangeLogin')
                <!-- Fin Modal change login -->



                @yield('content')
                @if($caspage != '')

                    </div>

                @endif
        </form>
    </main>
    @include('includes.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    @include('includes.js')

    <script>

        function controleVide(champs, labels) {
            if (champs !== '' && labels !== '') {
                var tch = champs.split('|');
                var tlab = labels.split('|'); //alert(tch.length + ' ' + tlab.length);
                if (tch.length !== tlab.length) {
                    alert("Les paramètres ne concordent pas");
                } else {
                    var n = tch.length;
                    for (let i = 0; i < n; i++) {
                        if(!document.getElementById(tch[i])) alert(tch[i]);
                        if (document.getElementById(tch[i]).value === '' | document.getElementById(tch[i]).value === '0') {
                            alert("Vous devez renseigner " + tlab[i]);
                            document.getElementById(tch[i]).focus();
                            return false;
                        }
                    }
                }
            }

            return true;
        }

        function ajouter(lien) {
            var chps = '';
            var labels = "";
            // alert(lien);
            switch (lien) {
                case "/ajout-apprenant":
                    chps = 'idclassannesco';
                    labels = "la classe";
                    break;
                case "/ajout-composition":
                    chps = 'idclassannesco';
                    labels = "la classe";
                    break;

                default:
                    break;
            }


            if (controleVide(chps, labels)) {
                document.forms["myform"].method = 'GET';
                document.forms["myform"].action = lien;
                document.forms["myform"].submit();
            }

        }

        function changerMonPassword() {
            var chps = 'ancienpass|newpass|confirmpass';
            var labels = "l'actuel mot de passe|le nouveau mot de passe|la confirmation";
            let act = '/changer-mon-password';
            if (controleVide(chps, labels)) {
                let ancpw = $('#ancienpass').val();
                let newpw = $('#newpass').val();
                let confpw = $('#confirmpass').val();
                if (newpw !== confpw) {
                    alert("Confirmation incorrecte");
                } else {

                    document.forms["myform"].method = 'POST';
                    document.forms["myform"].action = act;
                    document.forms["myform"].submit();
                }
            }
        }


        function reinitpassword() {

            if (controleVide('reinitpass', 'Le mot de passe')) {

                document.forms["myform"].method = 'POST';
                document.forms["myform"].action = '/reinitialiser-password';
                document.forms["myform"].submit();
            }
        }


        function ChangerLogin() {
            var logins = document.getElementById('tLogin').value;
            let logchg = document.getElementById('loginchange').value;
            let oldlog = document.getElementById('ancienLogin').value;
            let tlogin = logins.split('|');

            if (controleVide('loginchange', "l'identifiant")) {
                if ((oldlog !== logchg) && tlogin.includes(logchg)) {
                    alert("Cet identifiant existe déjà");
                } else {
                    document.forms["myform"].method = 'POST';
                    document.forms["myform"].action = '/changer-login';
                    document.forms["myform"].submit();
                }
            }


        }

    </script>

</body>

</html>