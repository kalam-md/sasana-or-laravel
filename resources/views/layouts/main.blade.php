<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Futsal App">
	<meta name="author" content="Rudi Haryanto">
	<meta name="keywords" content="Futsal, App">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Dashboard Admin - Sasana Olahraga</title>

	<link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<style>
		.preview-images-zone {
				width: 100%;
				border: 1px solid #ddd;
				min-height: 180px;
				border-radius: 5px;
				padding: 20px;
				display: flex;
				justify-content: center;
				align-items: center;
				flex-wrap: wrap;
				box-sizing: border-box;
		}
		.preview-image {
				width: 250px;
				height: 150px;
				margin: 10px;
				overflow: hidden;
				position: relative;
		}
		.preview-image img {
				width: 100%;
				height: 100%;
				object-fit: cover;
		}
		.past-date {
    		background-color: #f2f2f2;
		}
		.jadwal-item.selected {
			background-color: #eeeeee;
		}
	</style>	
</head>

<body>
	@include('sweetalert::alert')
	
	<div class="wrapper">
    {{-- NAV --}}
    @include('layouts.sidebar')

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						{{-- <li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li> --}}
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="{{ route('profile', ['username' => Auth::user()->username]) }}" data-bs-toggle="dropdown">
                <img 
									src="{{ auth()->user()->photo ? asset('profile/' . auth()->user()->photo) : asset('admin/img/avatars/profile.webp') }}" 
									class="avatar img-fluid rounded me-1" 
									alt="{{ auth()->user()->fullname }}"
									width="128" 
									height="128"
									style="object-fit: cover;">
								<span class="text-dark">{{ auth()->user()->fullname }}</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="{{ route('profile', ['username' => Auth::user()->username]) }}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<form action="{{ route('logout') }}" method="post">
									@csrf
									<button type="submit" class="dropdown-item" href="#">Logout</button>
								</form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

      {{-- MAIN --}}
			<main class="content">
				<div class="container-fluid p-0">

          @yield('content')

				</div>
			</main>

      {{-- FOOTER --}}
			@include('layouts.footer')
		</div>
	</div>

  {{-- JS --}}
	<script src="{{ asset('admin/js/app.js') }}"></script>

	{{-- Dashboard Chart --}}
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Pemesanan",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [
							10,
							20,
							15,
							10,
							25,
							13,
							22,
							30,
							50,
							23,
							11,
							20,
						]
					}]
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
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
		});
	</script>

	{{-- Image Preview --}}
	<script>
		$(document).ready(function() {
			function readURL(input) {
					if (input.files && input.files.length > 0) {
							$('.preview-images-zone').empty(); // Kosongkan preview gambar yang sudah ada

							for (let i = 0; i < input.files.length; i++) {
									let file = input.files[i];
									let reader = new FileReader();

									reader.onload = function(e) {
											let html = '<div class="preview-image"><img src="' + e.target.result + '"></div>';
											$('.preview-images-zone').append(html);
									}

									reader.readAsDataURL(file);
							}
					}
			}

			// Trigger image preview when file input changes
			$("input[name='gambar_lapangan[]']").change(function() {
					readURL(this);
			});
		});
	</script>

</body>

</html>