<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('login_assets/css/style.css') }}">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Bienvenue</h2>
								<p>Vous etes nouveaux ?</p>
								<a href="{{ route('showRegister')}}" class="btn btn-white btn-outline-white">S'inscrire</a>
							</div>
			            </div>
						<div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Se connecter</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                            </div>

                            <form action="{{ route('loginAction') }}" method="POST"  class="signin-form">
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                  @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                  @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="form-group mb-3">
                                <label class="label" for="name">Identifiant</label>
                                <input type="text" class="form-control" placeholder="votre identifiant" name="identifier">
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Mot de passe </label>
                                <input type="password" class="form-control" placeholder="votre mot de passe" name="password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" >se connecter</button>
                            </div>
                            </form>
                            
                        </div>
		            </div>
				</div>
			</div>
		</div>

        
	</section>

    <script src="{{ asset('login_assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('login_assets/js/popper.js') }}"></script>
    <script src="{{ asset('login_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('login_assets/js/main.js') }}"></script>

	</body>
</html>