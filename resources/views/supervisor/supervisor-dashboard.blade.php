@extends('layout.index')
@section('welcome-message')
<h1 class="header-title">
	Bonjour, {{$LoggedUserInfo['prenom']}}!
</h1>
@endsection
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
				<div class="col-12">
							<div class="card">
								<div class="card-header">
									<div class="row">
										<div class="col-sm-6">
											<h2 class="card-title">Liste des Utilisateurs</h2>
										</div>
										<div class="col-sm-6">
											@if (Session::get('success'))									  
										<div class="alert alert-success alert-dismissible" role="alert">
											<div class="alert-message">
												{{Session::get('success')}}

											</div>

											<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
          					
      									@endif
										  @if (Session::get('deleted'))									  
										<div class="alert alert-danger alert-dismissible" role="alert">
											<div class="alert-message">
												{{Session::get('deleted')}}

											</div>

											<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
          					
      									@endif
										</div>
									</div>
								</div>
								<div class="card-body">
									<table id="datatables-buttons" class="table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Nom</th>
												<th>Prenom</th>
												<th>Email</th>
												<th>Role</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($utilisateurs as $util)
											<tr>
												<td>{{$util->nom}}</td>
												<td>{{$util->prenom}}</td>
												<td>{{$util->email}}</td>
												<td>{{$util->role}}</td>
												<td>
                                                    @if ($util->role != 'Admin' && $util->role != 'Superviseur')
                                                    <a href="{{url('/supervisor-edit-user'. $util->id)}}" class="btn btn-primary">
                                                        <i class="fas  fa-cogs"></i>
                                                    </a>
                                                    @endif
												</td>
											</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th>Nom</th>
												<th>Prenom</th>
												<th>Email</th>
												<th>Role</th>
                                                <th>Actions</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
						<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
						<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
						<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
						<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
						<script src="//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Datatables with Buttons
			var datatablesButtons = $('#datatables-buttons').DataTable({
				lengthChange: !1,
				dom: 'Bfrtip',
				buttons: ['pdf','excel'],
				responsive: true ,
				language: 
            		{
    "emptyTable": "Aucune donnée disponible dans le tableau",
    "lengthMenu": "Afficher _MENU_ éléments",
    "loadingRecords": "Chargement...",
    "processing": "Traitement...",
    "zeroRecords": "Aucun élément correspondant trouvé",
    "paginate": {
        "first": "Premier",
        "last": "Dernier",
        "previous": "Précédent",
        "next": "Suiv"
    },
    "aria": {
        "sortAscending": ": activer pour trier la colonne par ordre croissant",
        "sortDescending": ": activer pour trier la colonne par ordre décroissant"
    },
    "select": {
        "rows": {
            "_": "%d lignes sélectionnées",
            "0": "Aucune ligne sélectionnée",
            "1": "1 ligne sélectionnée"
        },
        "1": "1 ligne selectionnée",
        "_": "%d lignes selectionnées",
        "cells": {
            "1": "1 cellule sélectionnée",
            "_": "%d cellules sélectionnées"
        },
        "columns": {
            "1": "1 colonne sélectionnée",
            "_": "%d colonnes sélectionnées"
        }
    },
    "autoFill": {
        "cancel": "Annuler",
        "fill": "Remplir toutes les cellules avec <i>%d<\/i>",
        "fillHorizontal": "Remplir les cellules horizontalement",
        "fillVertical": "Remplir les cellules verticalement",
        "info": "Exemple de remplissage automatique"
    },
    "searchBuilder": {
        "conditions": {
            "date": {
                "after": "Après le",
                "before": "Avant le",
                "between": "Entre",
                "empty": "Vide",
                "equals": "Egal à",
                "not": "Différent de",
                "notBetween": "Pas entre",
                "notEmpty": "Non vide"
            },
            "number": {
                "between": "Entre",
                "empty": "Vide",
                "equals": "Egal à",
                "gt": "Supérieur à",
                "gte": "Supérieur ou égal à",
                "lt": "Inférieur à",
                "lte": "Inférieur ou égal à",
                "not": "Différent de",
                "notBetween": "Pas entre",
                "notEmpty": "Non vide"
            },
            "string": {
                "contains": "Contient",
                "empty": "Vide",
                "endsWith": "Se termine par",
                "equals": "Egal à",
                "not": "Différent de",
                "notEmpty": "Non vide",
                "startsWith": "Commence par"
            },
            "array": {
                "equals": "Egal à",
                "empty": "Vide",
                "contains": "Contient",
                "not": "Différent de",
                "notEmpty": "Non vide",
                "without": "Sans"
            }
        },
        "add": "Ajouter une condition",
        "button": {
            "0": "Recherche avancée",
            "_": "Recherche avancée (%d)"
        },
        "clearAll": "Effacer tout",
        "condition": "Condition",
        "data": "Donnée",
        "deleteTitle": "Supprimer la règle de filtrage",
        "logicAnd": "Et",
        "logicOr": "Ou",
        "title": {
            "0": "Recherche avancée",
            "_": "Recherche avancée (%d)"
        },
        "value": "Valeur"
    },
    "searchPanes": {
        "clearMessage": "Effacer tout",
        "count": "{total}",
        "title": "Filtres actifs - %d",
        "collapse": {
            "0": "Volet de recherche",
            "_": "Volet de recherche (%d)"
        },
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Pas de volet de recherche",
        "loadMessage": "Chargement du volet de recherche..."
    },
    "buttons": {
        "copyKeys": "Appuyer sur ctrl ou u2318 + C pour copier les données du tableau dans votre presse-papier.",
        "collection": "Collection",
        "colvis": "Visibilité colonnes",
        "colvisRestore": "Rétablir visibilité",
        "copy": "Copier",
        "copySuccess": {
            "1": "1 ligne copiée dans le presse-papier",
            "_": "%ds lignes copiées dans le presse-papier"
        },
        "copyTitle": "Copier dans le presse-papier",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Afficher toutes les lignes",
            "1": "Afficher 1 ligne",
            "_": "Afficher %d lignes"
        },
        "pdf": "PDF",
        "print": "Imprimer"
    },
    "decimal": ",",
    "info": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
    "infoEmpty": "Affichage de 0 à 0 sur 0 éléments",
    "infoThousands": ".",
    "search": "Rechercher:",
    "searchPlaceholder": "...",
    "thousands": ".",
    "infoFiltered": "(filtrés depuis un total de _MAX_ éléments)",
    "datetime": {
        "previous": "Précédent",
        "next": "Suivant",
        "hours": "Heures",
        "minutes": "Minutes",
        "seconds": "Secondes",
        "unknown": "-",
        "amPm": [
            "am",
            "pm"
        ]
    },
    "editor": {
        "close": "Fermer",
        "create": {
            "button": "Nouveaux",
            "title": "Créer une nouvelle entrée",
            "submit": "Envoyer"
        },
        "edit": {
            "button": "Editer",
            "title": "Editer Entrée",
            "submit": "Modifier"
        },
        "remove": {
            "button": "Supprimer",
            "title": "Supprimer",
            "submit": "Supprimer"
        },
        "error": {
            "system": "Une erreur système s'est produite"
        },
        "multi": {
            "title": "Valeurs Multiples",
            "restore": "Rétablir Modification"
        }
    }

        }
			});
			datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)")
		});
	</script>
@endsection