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
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
        $caspage = isset($caspage) ? $caspage : '';
        $clbody = $caspage != '' ? 'corps' : '';
        //dd($caspage);
        $userEncours = (session('userEncours') != null) ? session('userEncours') : null;
        $anEncours = (session('anEncours') != null) ? session('anEncours') : null;
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
        </div>
    </header>

    <main class="main {{ $clbody }}">

        @if($caspage == '')
            @include('includes.headerAccueil')
        @else
            @include('includes.header')
            <div class="card " style="padding: 20px">
        @endif
            @yield('content')
            @if($caspage != '')

                </div>

            @endif

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
                document.forms["myform"].action = lien;
                document.forms["myform"].submit();
            }

        }

    </script>

</body>

</html>