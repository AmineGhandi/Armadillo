@extends('layout.index')
@section('nav-items')
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{url('/edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
</div>
@endsection
@section('Sidebar')
<ul class="sidebar-nav">
	<li class="sidebar-header">
		Gestion
	</li>
	<li class="sidebar-item ">
		<a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-user-plus"></i> <span class="align-middle">Créer</span>
		</a>
		<ul id="dashboards" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
			<li class="sidebar-item "><a class="sidebar-link" href="{{route('createUser')}}">Utilisateurs</a></li>
			<li class="sidebar-item "><a class="sidebar-link" href="{{route('createClient')}}">Clients</a></li>
		</ul>
	</li>
	<li class="sidebar-item">
		<a href="{{route('clientList')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>
	<li class="sidebar-item">
		<a href="{{route('stats')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-chart-pie"></i> <span class="align-middle">Statistiques des utilisateurs</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>
	<li class="sidebar-item">
		<a class="sidebar-link collapsed" href="{{route('printer')}}">
			<i class="align-middle me-2 fas fa-fw fa-print"></i> <span class="align-middle">Impression des chèques</span>
		</a>
	</li>

	<li class="sidebar-item">
		<a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-paper-plane"></i> <span class="align-middle">Envoie d'emails</span>
		</a>
		<ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('multimail.index')}}">Envoyer a plusieurs clients</a></li>
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('email.index')}}">Envoyer a un seul client</a></li>
		</ul>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="{{url('/edit-profil' . $LoggedUserInfo['id'])}}" class="sidebar-link collapsed">
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
        <h5 class="card-title">Creation d'un utilisateur</h5>
        <h6 class="card-subtitle text-muted">Merci de remplir le formulaire avec les informations necessaires.</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insertUser')}}" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email"  placeholder="Email">
                @error('email')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control"  name="nom" placeholder="Nom">
                @error('nom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Prenom</label>
                <input type="text" class="form-control"  name="prenom" placeholder="Prenom">
                @error('prenom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="mdp"  placeholder="Mot de passe">
                @error('mdp')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Changer votre photo de profil</label>
                <input type="file" name="img">
                @error('img')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="Admin">Admin</option>
                    <option value="Superviseur">Superviseur</option>
                    <option value="Agent impression">Agent impression</option>
                    <option value="Agent mailing">Agent mailing</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
			<a href="{{route('Admin')}}" class="btn btn-info">Annuler</a>
        </form>
    </div>
</div>
    
@endsection