@extends('layout.index')
@section('nav-items')
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{url('/agentp-edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
</div>
@endsection
@section('Sidebar')
<ul class="sidebar-nav">
	<li class="sidebar-item">
		<a href="{{route('clientListagentp')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>
	<li class="sidebar-item">
		<a class="sidebar-link collapsed" href="{{route('printeragentp')}}">
			<i class="align-middle me-2 fas fa-fw fa-print"></i> <span class="align-middle">Impression des chèques</span>
		</a>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="{{url('/agentp-edit-profil' . $LoggedUserInfo['id'])}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-user-alt"></i> <span class="align-middle">Modifier mes informations</span>
		</a>
	</li>
	<li class="sidebar-item ">
		<a href="{{route('logout')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-arrow-alt-circle-right"></i> <span class="align-middle">Se Deconnecter</span>
		</a>
	</li>
</ul>
	
@endsection
@section('page-body')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form action="{{ route('print') }}" method="post">
@csrf
	<div class="col-md-12">
							<div class="card">
								<div class="card-header">
								</div>
								<div class="card-body">
									<form>
										<div class="row">
											<div class="mb-3 col-md-6">
												<label for="Nomdelemeteur">Nom d'emeteur</label>
												<input type="text" class="form-control" name="name" placeholder="Nom de l'emeteur">
											</div>
											<div class="mb-3 col-md-6">
												<label for="Prenom">Prenom d'emeteur</label>
												<input type="text" class="form-control" name="lastname" placeholder="Prenom d'emeteur">
											</div>
										</div>
										<div class="mb-3">
											<label for="inputAddress">Addresse</label>
											<input type="text" class="form-control" name="add"  placeholder="1234 Main St">
										</div>
										<div class="mb-3">
											<label for="montantennombre">Montant en chiffres</label>
											<input type="text" class="form-control" id="numberInput" name="mn" placeholder="montant en nombre">
										</div>
										<div class="row">
											<div class="mb-3">
												<label for="montantenlettres">Montant en lettres</label>
												<input type="text" class="form-control" id="stringOutput" name="stringOutput" readonly>
											</div>
                                        <div class="row">
											<div class="mb-3">
                                                <label class="form-label">Date d'expiration</label>
                                                <input type="date" class="form-control"  name="date_naiss" placeholder="Date de naissance">
                                            </div>
                                        </div>
										
											<div class="mb-3">
												<label for="memo">beneficiaire</label>
												<input type="text" class="form-control" name="memo" id="Memo" placeholder="Nom de beneficiaire">
											</div>
										</div>
										<button type="submit" class="btn btn-primary">Print</button>
										<a href="{{route('Mail')}}" class="btn btn-info">Retour</a>
									</form>
								</div>
							</div>
						</div>
  <!-- scripts -->
  <script  src="js/numberToString.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- end scripts -->


@endsection