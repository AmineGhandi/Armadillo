@extends('layout.index')
@section('nav-items')
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{url('/supervisor-edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
</div>
@endsection
@section('Sidebar')
<ul class="sidebar-nav">
	<li class="sidebar-header">
		Gestion
	</li>
	<li class="sidebar-item">
		<a href="{{route('clientListsup')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>
	<li class="sidebar-item">
		<a href="{{route('statssup')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-chart-pie"></i> <span class="align-middle">Statistiques des utilisateurs</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>
	<li class="sidebar-item">
		<a class="sidebar-link collapsed" href="{{route('printersup')}}">
			<i class="align-middle me-2 fas fa-fw fa-print"></i> <span class="align-middle">Impression des chèques</span>
		</a>
	</li>

	<li class="sidebar-item">
		<a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-paper-plane"></i> <span class="align-middle">Envoie d'emails</span>
		</a>
		<ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('multimail.indexsup')}}">Envoyer a plusieurs clients</a></li>
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('email.indexsup')}}">Envoyer a un seul client</a></li>
		</ul>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="{{url('/supervisor-edit-profil' . $LoggedUserInfo['id'])}}" class="sidebar-link collapsed">
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
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Informations du profil</h5>
        <h6 class="card-subtitle text-muted">Vous pouvez modifier vos informations dans cette page.</h6>
    </div>
    <div class="card-body">
        <form action="{{url('/supervisor-update-profil/'. $User->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{$User->email}}" placeholder="Email">
				@error('email')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" value="{{$User->nom}}" name="nom" placeholder="Nom">
				@error('nom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Prenom</label>
                <input type="text" class="form-control" value="{{$User->prenom}}" name="prenom" placeholder="Prenom">
				@error('prenom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="mdp" value="{{$User->mdp}}" placeholder="Mot de passe">
				@error('mdp')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Changer votre photo de profil</label>
                <input type="file" name="img">
            </div>
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
			<a href="{{route('Supervisor')}}" class="btn btn-info">Annuler</a>
        </form>
    </div>
</div>
    
@endsection