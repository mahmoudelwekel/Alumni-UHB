<?php
$page = "jobs";
require_once "../../init/init.php";

$stmt = $con->prepare("SELECT * FROM jobs");
$stmt->execute();

$jobs = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();

$categories = $stmt->fetchAll();
?>

	<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
			background-repeat: no-repeat;
			background-size: contain;
			background-position: right;
			background-color: #e5f1ed;">
		<div class="container h1 py-5">Jobs</div>
	</div>

	<div class="container  py-5">

		<div id="filters" class="button-group">
			<button onclick="getCourses('*')" class="button is-checked" data-filter="*">show all</button>
			<?php foreach ( $categories as $category ): ?>
				<button onclick="getJobs('<?= $category['id'] ?>')" class="button"
						data-filter=".catg-<?= $category['id'] ?>"><?= $category['catg_name'] ?></button>
			<?php endforeach; ?>
		</div>

		<div id="jobs">
			<?php foreach ( $jobs as $job ): ?>
				<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
						background-repeat: no-repeat;
						background-size: contain;
						background-position: right;
						background-color: #e5f1ed;">
					<div class="card-body font-weight-bold">
						<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $job['job_name'] ?></h4>
						<hr/>
						<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
							<i class="icon fas fa-map-marker-alt "></i> <?= $job['company'] ?>
						</p>
						<div class="row card-text">
							<div class="col h5  font-weight-bold no-text-wrap">
								<i class="icon fas fa-envelope-open-text "></i> <?= $job['details'] ?>
							</div>
							<div class="col h5  font-weight-bold no-text-wrap  text-center">
								<a href="<?= $job['link'] ?>" target="_blank"
								   class="btn btn-sm btn-dark">Show</a>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<br/>
			<?php endforeach; ?>
		</div>

		<script>
			$(document).ready(function() {
				$('.kv-ltr-theme-fas-star').rating({
					hoverOnClear: false,
					theme: 'krajee-fas',
					containerClass: 'is-star',
					showCaption: false,
					stars: 5,
					displayOnly: true
				});
			});
		</script>
	</div>
<?php require_once "../includes/footer.php"; ?>