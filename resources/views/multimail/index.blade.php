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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form action="{{ route('multimail.send') }}" method="post">
	@csrf
	<div class="card">
	  <div class="card-header">
	  </div>
	  <div class="card-body">
			<div class="form-group">
				 <label>Name</label>
				 <input type="text" name="name"  class="form-control" placeholder="Enter Name">
			 </div>
			 <div class="mb-3">
                <label class="form-label">Email</label>
				</br>
                <select name="email" class="select2 form-control" style="width: 100%"> 
				<option disabled selected>select an option</option>
					@foreach ($utilisateurs as $util)
                    <option value="{{$util->email}}">{{$util->email}}</option>
					@endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Cc</label>
				</br>     
                <select name="bcc[]" class="select2 " style="width: 100%" multiple> 
				<option disabled selected>select an option</option>
					@foreach ($utilisateurs as $util)
                    <option value="{{$util->email}}">{{$util->email}}</option>
					@endforeach
                </select>
            </div>
			 <!-- <div class="form-group">
				 <label>Email</label>
				 <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email">
			 </div> -->
			 <div class="form-group">
				 <label>Subject</label>
				 <input type="text" name="subject" class="form-control" placeholder="Enter Subject">
			 </div>
			 <div class="form-group">
				 <label>Message</label>
				 <textarea name="message" class="form-control" placeholder="Enter Message"></textarea>
			 </div>
	  </div>
	  <div class="card-body">
		 <button type="submit" class="btn btn-primary">Send</button>
		 <a href="{{route('Admin')}}" class="btn btn-info">Annuler</a>
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
