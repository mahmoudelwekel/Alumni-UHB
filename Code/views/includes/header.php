<!DOCTYPE html>
<html lang="en">

<head>
	<title>Alumni UHB</title>
	<link rel="icon" href="<?= asset("Images/logo.png") ?>" type="image/png"/>

	<meta charset="utf-8">
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1,shrink-to-fit=no"/>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-16"/>

	<link rel="stylesheet" href="<?= asset("css/bootstrap.min.css") ?>"/>
	<link rel="stylesheet" href="<?= asset("StarRating/star-rating.min.css") ?>"/>
	<link rel="stylesheet" href="<?= asset("StarRating/theme.min.css") ?>"/>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>


	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css"
		  href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">

	<link rel="stylesheet"
		  href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

	<link rel="stylesheet" href="<?= asset("css/style.css") ?>"/>
</head>

<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?= asset("StarRating/star-rating.min.js") ?>"></script>
<script src="<?= asset("StarRating/theme.min.js") ?>"></script>


<div style="background-image: url('<?= asset("Images/header.jpg") ?>');background-repeat: no-repeat;
		background-size: cover;
		background-position: center; ">
	<div class="container d-flex justify-content-start align-items-center">
		<img src="<?= asset("Images/logo.png") ?>" class="my-4"/>
	</div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light font-weight-bold shadow">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
				aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				<a class="nav-item nav-link <?php setActive("home"); ?>" href="<?= route("public") ?>">Home</a>
				<?php if ( isAdmin() ) : ?>
					<a class="nav-item nav-link <?php setActive("alumni"); ?>" href="<?= route("alumni") ?>">Alumni</a>
					<a class="nav-item nav-link <?php setActive("categories"); ?>" href="<?= route("categories") ?>">Categories</a>
					<a class="nav-item nav-link <?php setActive("colleges"); ?>" href="<?= route("colleges") ?>">Colleges</a>
					<a class="nav-item nav-link <?php setActive("departments"); ?>" href="<?= route("departments") ?>">Departments</a>
				<?php endif; ?>
				<a class="nav-item nav-link <?php setActive("courses"); ?>" href="<?= route("courses") ?>">Courses</a>
				<a class="nav-item nav-link <?php setActive("workshops"); ?>"
				   href="<?= route("workshops") ?>">WorkShops</a>
				<a class="nav-item nav-link <?php setActive("jobs"); ?>" href="<?= route("jobs") ?>">Jobs</a>
				<a class="nav-item nav-link <?php setActive("lecturers"); ?>"
				   href="<?= route("lecturers") ?>">Lecturers</a>
				<?php if ( isVisitor() ) : ?>
					<a class="nav-item nav-link <?php setActive("login"); ?>" href="<?= route("public/login.php") ?>">Login</a>
				<?php else : ?>
					<?php if ( !isAdmin() ): ?>
						<?php if ( isAlumnus() ): ?>
							<a class="nav-item nav-link" href="<?= route("profile") ?>">My Requests</a>
						<?php endif; ?>
						<a class="nav-item nav-link" href="<?= route("profile/courses.php") ?>">My Courses</a>
						<a class="nav-item nav-link" href="<?= route("profile/update.php") ?>">Update My Profile</a>
					<?php endif; ?>
					<a class="nav-item nav-link" href="<?= route("public/logout.php") ?>">Logout</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</nav>


<div class="">