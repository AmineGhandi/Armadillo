@extends('layout.index')
@section('nav-items')
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{url('/agentm-edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
</div>
@endsection
@section('Sidebar')
<ul class="sidebar-nav">
	<li class="sidebar-item">
		<a href="{{route('clientListagentm')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>

	<li class="sidebar-item">
		<a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-paper-plane"></i> <span class="align-middle">Envoie d'emails</span>
		</a>
		<ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('multimail.indexagentm')}}">Envoyer a plusieurs clients</a></li>
			<li class="sidebar-item"><a class="sidebar-link" href="{{route('email.indexagentm')}}">Envoyer a un seul client</a></li>
		</ul>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="{{url('/agentm-edit-profil' . $LoggedUserInfo['id'])}}" class="sidebar-link collapsed">
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

<form action="{{ route('email.send') }}" method="post">
	@csrf
	<div class="card">
	  <div class="card-header">
	  
	  </div>
	  <div class="card-body">
			
			 <div class="mb-3">
                <label class="form-label">Email</label>
				</br>
                <select name="email" class="select2 form-control" style="width: 100%"> 
					<option disabled selected style="font-size: 12%;">Selectionnez un email</option>
					@foreach ($clients as $Client)
                    <option value="{{$Client->email}}">{{$Client->email}}</option>
					@endforeach
                </select>
            </div>
			 <div class="form-group">
				 <label>Sujet</label>
				 <input type="text" name="subject" class="form-control" placeholder="Entrez un Sujet">
			 </div>
			 <div class="form-group">
				 <label>Message</label>
				 <textarea name="message" class="form-control" placeholder="Entrez un message"></textarea>
			 </div>
	  </div>
	  <div class="card-body">
		 <button type="submit" class="btn btn-primary">Envoyer</button>
		 <a href="{{route('Mail')}}" class="btn btn-info">Annuler</a>
	  </div>
	</div>
  </form>
  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- end scripts -->


  <script>
  	$(document).ready(function() {
    $('.select2').select2();
	});
  </script>

@if (Session::get('success'))
<script type='text/javascript'>
	Swal.fire({
position: 'top-end',
icon: 'success',
title: 'mail envoyé avec succès',
showConfirmButton: false,
timer: 3000
})
</script>
	
@endif

@endsection

