<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from spark.bootlab.io/pages-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Jun 2021 22:21:51 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
	<meta name="author" content="Bootlab">

	<title>Armadillo - Se connecter</title>
	<link rel="icon" href="img/armadillologo.png" />
	<!-- PICK ONE OF THE STYLES BELOW -->
	<link href="{{asset('css/modern.css')}}" rel="stylesheet"> 
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- <link href="css/classic.css" rel="stylesheet"> -->
	<!-- <link href="css/dark.css" rel="stylesheet"> -->
	<!-- <link href="css/light.css" rel="stylesheet"> -->

	<!-- BEGIN SETTINGS -->
	<!-- You can remove this after picking a style -->
	<style>
		body {
			opacity: 0;
		}
		.bg-modern{
			background-color: #153d77;
		}
		.text-modern{
			color: #153d77;
		}
	</style>
	<script src="{{asset('js/settings.js')}}"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120946860-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120946860-7');
</script></head>

<body class="theme-blue">
	<div class="splash active">
		<div class="splash-icon"></div>
	</div>

	<main class="main h-100 w-100 bg-modern">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						
						<div class="shadow-lg p-3 mb-5 ">
						<div class="card">
							<div class="card-header">
								<div class="text-center mt-4">
								<img src="img/armadillo_fullt.png" alt="logo" style="width: 64%;">
								</div>
							</div>
							<div class="card-body">
								<div class="m-sm-4">
									<form action="{{route('check')}}" method="POST">
										@csrf
										<div class="mb-3">
											<label >Email</label> <br> 
											<input class="form-control form-control-lg" type="email" name="email" value="{{old('email')}}" placeholder="Entrez votre email" />
											<span class="text-danger">
												@error('email')
													{{$message}}
												@enderror
											  </span>
										</div>
										<div class="mb-3">
											<label>Mot de passe</label> <br>
											<input class="form-control form-control-lg" type="password" name="mdp" placeholder="Entrez votre mot de passe" />
											<span class="text-danger">
												@error('mdp')
													{{$message}}
												@enderror
											  </span>
										</div>
										<div class="text-center mt-3">
											 <button type="submit" class="btn btn-lg btn-success">Se connecter</button> 
										</div>
									</form>
								</div>
								@if (Session::get('fail'))									  
										<div class="alert alert-danger alert-dismissible" role="alert">
											<div class="alert-message">
												{{Session::get('fail')}}

											</div>

											<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
          					
      							@endif
							</div>
						</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{asset('js/app.js')}}"></script>

</body>


<!-- Mirrored from spark.bootlab.io/pages-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Jun 2021 22:21:51 GMT -->
</html>