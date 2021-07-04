@extends('layout.index')
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
			<li class="sidebar-item "><a class="sidebar-link" href="dashboard-analytics.html">Clients</a></li>
		</ul>
	</li>
	<li class="sidebar-item">
		<a href="#" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>
	<li class="sidebar-item">
		<a href="#" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-chart-pie"></i> <span class="align-middle">Statistiques des utilisateurs</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>
	<li class="sidebar-item">
		<a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-print"></i> <span class="align-middle">Impression des chèques</span>
		</a>
		<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class="sidebar-link" href="#">Client existant</a></li>
			<li class="sidebar-item"><a class="sidebar-link" href="#">Nouveau client</a></li>
		</ul>
	</li>

	<li class="sidebar-item">
		<a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-paper-plane"></i> <span class="align-middle">Envoie d'emails</span>
		</a>
		<ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class="sidebar-link" href="#">Envoyer a plusieurs clients</a></li>
			<li class="sidebar-item"><a class="sidebar-link" href="#">Envoyer a un seul client</a></li>
		</ul>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="#" class="sidebar-link collapsed">
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
        <h5 class="card-title">Modification des informations d'un utilisateur</h5>
        <h6 class="card-subtitle text-muted">Vous pouvez modifier ou supprimer cet utilisateur.</h6>
    </div>
    <div class="card-body">
        <form action="{{url('/update-user/'. $user->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{$user->email}}" name="email"  placeholder="Email">
                @error('email')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" value="{{$user->nom}}" name="nom" placeholder="Nom">
                @error('nom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
			<div class="mb-3">
                <label class="form-label">Prenom</label>
                <input type="text" class="form-control" value="{{$user->prenom}}" name="prenom" placeholder="Prenom">
                @error('prenom')
            <div class="text-danger">
              {{$message}}
            </div>
          @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="mdp" value="{{$user->mdp}}" placeholder="Mot de passe">
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
                    <option value="Admin" {{$user->role == "Admin" ? 'selected' : '' }} >Admin</option>
                    <option value="Superviseur" {{$user->role == "Superviseur" ? 'selected' : '' }}>Superviseur</option>
                    <option value="Agent impression" {{$user->role == "Agent impression" ? 'selected' : '' }}>Agent impression</option>
                    <option value="Agent mailing" {{$user->role == "Agent mailing" ? 'selected' : '' }}>Agent mailing</option>
                </select>
            </div>
            <div class="row">
                <div class="col-sm-9">
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
			<a href="{{route('Admin')}}" class="btn btn-secondary">Annuler</a>
                </div>
                <div class="col-sm-3">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger">Supprimer cet utilisateur</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- Modal-delete --}}
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DeleteLabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Voulez-vous vraiment supprimer cet utilisateur ?
        </div>
        <div class="modal-footer">
          <a href="{{url('/delete-user/'.$user->id)}}" class="btn btn-danger">Supprimer</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </div>
  </div>

    
@endsection