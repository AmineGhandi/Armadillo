<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
	<meta name="author" content="Bootlab">

	<title>Armadillo</title>

	
	<link href="css/modern.css" rel="stylesheet">

	<link rel="icon" href="img/armadillo_inverted.ico" />

	<style>
		body {
			opacity: 0;
		}
	</style>
	<script src="{{asset('js/settings.js')}}"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120946860-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120946860-7');
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<div class="splash active">
		<div class="splash-icon"></div>
	</div>

	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<a class="sidebar-brand" href="javascript:void(0)">
			<img src="img/armadillo_inverted.png" style="width: 26%; ">
				<img src="img/armadillostr_inverted.png" style="width: 69%">
			</a>
			<div class="sidebar-content">
				<div class="sidebar-user">
					<img src="{{$LoggedUserInfo['img']}}" class="img-fluid rounded-circle mb-2" alt="{{$LoggedUserInfo['prenom']}} {{$LoggedUserInfo['nom']}}" />
					<div class="fw-bold">{{$LoggedUserInfo['prenom']}} {{$LoggedUserInfo['nom']}}</div>
					<small>{{$LoggedUserInfo['role']}}</small>
				</div>
				@yield('Sidebar')
			</div>
		</nav>
		<div class="main">
			<nav class="navbar navbar-expand navbar-theme">
				<a class="sidebar-toggle d-flex me-2">
					<i class="hamburger align-self-center"></i>
				</a>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav ms-auto">
						
						<li class="nav-item dropdown ms-lg-2">
							<a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-bs-toggle="dropdown">
								<i class="align-middle fas fa-cog"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="{{url('/edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
							</div>
						</li>
					</ul>
				</div>

			</nav>
			<main class="content">
				<div class="container-fluid">

					<div class="header">
						@yield('welcome-message')
					</div>
					
					@yield('page-body')


				</div>
			</main>
			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-4 text-end">
							<p class="mb-0">
								&copy; 2021 - <a href="javascript:void(0)" class="text-muted">Armadillo</a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>

	</div>

	<svg width="0" height="0" style="position:absolute">
		<defs>
			<symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong">
				<path
					d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z">
				</path>
			</symbol>
		</defs>
	</svg>
	<script src="{{asset('js/app.js')}}"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: 'line',
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
							label: "Orders",
							fill: true,
							backgroundColor: window.theme.primary,
							borderColor: window.theme.primary,
							borderWidth: 2,
							data: [3, 2, 3, 5, 6, 5, 4, 6, 9, 10, 8, 9]
						},
						{
							label: "Sales ($)",
							fill: true,
							backgroundColor: "rgba(0, 0, 0, 0.05)",
							borderColor: "rgba(0, 0, 0, 0.05)",
							borderWidth: 2,
							data: [5, 4, 10, 15, 16, 12, 10, 13, 20, 22, 18, 20]
						}
					]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					elements: {
						point: {
							radius: 0
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 5
							},
							display: true,
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: 'pie',
				data: {
					labels: ["Chrome", "Firefox", "IE", "Other"],
					datasets: [{
						data: [4401, 4003, 1589],
						backgroundColor: [
							window.theme.primary,
							window.theme.warning,
							window.theme.danger,
							"#E8EAED"
						],
						borderColor: "transparent"
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: 'bar',
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "This year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var map = new jsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				selectedRegions: [
					'US',
					'SA',
					'DE',
					'FR',
					'CN',
					'AU',
					'BR',
					'IN',
					'GB'
				],
				regionStyle: {
					initial: {
						fill: '#e4e4e4',
						"fill-opacity": 0.9,
						stroke: 'none',
						"stroke-width": 0,
						"stroke-opacity": 0
					},
					selected: {
						fill: window.theme.primary,
					}
				},
				zoomOnScroll: false
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
			setTimeout(function() {
				map.updateSize();
			}, 250);
		});
	</script>
	<script>
		$(function() {
			$('#datatables-dashboard-projects').DataTable({
				pageLength: 6,
				lengthChange: false,
				bFilter: false,
				autoWidth: false
			});
		});
	</script>
	<script>
		$(function() {
			$('#datetimepicker-dashboard').datetimepicker({
				inline: true,
				sideBySide: false,
				format: 'L'
			});
		});
	</script>

</body>

</html>