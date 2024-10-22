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
								<h2>Creer votre profile</h2>
								<p>Deja parmi nos membres ?</p>
								<a href="{{ route('showLogin')}}" class="btn btn-white btn-outline-white">Se connecter</a>
							</div>
			            </div>
						<div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">S'inscrire</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                            </div>

                            <form action="{{ route('client.register')}}" method="GET"  class="signin-form">
        
                            <div class="form-group mb-3">
                                <label class="label" >Nom Complet</label>
                                
                                <input type="text" class="form-control @error('name')is-invalid @enderror" placeholder="votre nom" name="name" value={{ old('name')}}>
                                <label>
                                    @error('name')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </label>

                            </div>
                            <div class="form-group mb-3">
                                <label class="label" >Identifiant</label>
                                <input type="text" class="form-control @error('email')is-invalid @enderror" placeholder="e-mail ou identifiant" name="email">
                                @error('email')
                                        <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Mot de passe </label>
                                
                                <input type="password" class="form-control @error('password')is-invalid @enderror" placeholder="Password" name="password">
                                <label>
                                    @error('password')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="label" for="password">Confirmer mot de passe </label>
                                
                                <input type="password" class="form-control @error('password')is-invalid @enderror" placeholder="retaper votre mot de passe " name="confirm">
                                <label>
                                    @error('confirm')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">S'inscrire</button>
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