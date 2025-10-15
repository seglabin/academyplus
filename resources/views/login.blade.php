<!doctype html>
<html lang="en">

<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('assets/Login/css/style.css')}}" rel="stylesheet">
</head>
<!-- <body class="img js-fullheight" style="background-image: url(assets/Login/images/bg.jpg);"> -->

<body class="img js-fullheight" style="background-image: url(assets/Login/images/bg_1.jpg);">
    <section class="ftco-section">
        <!-- <form id="myform" action="{{ route('connecter') }}" method="POST"> -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Entrez vos paramètres pour vous connecter</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <form id="myform" action="{{ route('connecter') }}" class="signin-form" method='POST'>
                            @csrf
                            <input type='hidden' name='config' id='config' value='login'>
                            <div class="form-group">
                                <input type="text" class="form-control" id="login" name="login"
                                    placeholder="Identifiant" required>
                            </div>
                            <div class="form-group">
                                <input id="password" name="password" type="password" class="form-control"
                                    placeholder="Mot de passe" required>
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Se
                                    connecter</button>
                            </div>
                            <!-- <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Forgot Password</a>
								</div>
	            </div> -->
                        </form>
                        <!-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p> -->
                        <!-- <div class="social d-flex text-center">
	          	<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- </form> -->
    </section>

    <script src="{{ asset('assets/Login/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/Login/js/popper.js')}}"></script>
    <script src="{{ asset('assets/Login/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/Login/js/main.js')}}"></script>
    <script>
        function connecter() {
            document.forms["myform"].method = 'POST';
            document.forms["myform"].action = "/connecter";
            document.forms["myform"].submit();
        }
    </script>

</body>

</html>