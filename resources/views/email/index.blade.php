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
<div class="container">
    <div class="row">
        <form action="{{ route('email.send') }}" method="post">
        @csrf
        <label for="">Name</label>
        <input type="text" name="name" placeholder="name">
        <label for="">Email</label>
        <input type="text" name="email" placeholder="email">
        <label for="">bcc</label>
        <input type="text" name="bcc" placeholder="bcc">
        <label for="">Subject</label>
        <input type="text" name="subject" placeholder="subject">
        <label for="">message</label>
        <textarea name="message" cols="30" rows="10"></textarea>
        <button type="submit">Send Email</button>
        </form>
    </div>
</div>
@endsection