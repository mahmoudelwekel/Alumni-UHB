<?php
$page = "workshops";
require_once "../../init/init.php";

if ( isset($_GET['workshop_id']) && isAlumnus() ) {
	$workshop_id = $_GET['workshop_id'];
	$alumnus_id = $_SESSION['id'];

	$stmt = $con->prepare("INSERT INTO alumnus_workshop(alumnus_id, workshop_id) VALUES(?, ?)");
	$stmt->execute([$alumnus_id, $workshop_id]);
//	redirect("workshops");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$workshop_id = $_POST['workshop_id'];
	$alumnus_id = $_SESSION['id'];
	$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

	$stmt = $con->prepare("UPDATE alumnus_workshop SET comment = ? WHERE workshop_id = ? AND alumnus_id = ?");
	$stmt->execute([$comment, $workshop_id, $alumnus_id]);

	redirect("workshops");
}

$stmt = $con->prepare("SELECT workshops.*, categories.catg_name AS category FROM workshops
								INNER JOIN categories
								ON categories.id = workshops.category_id");
$stmt->execute();
$workshops = $stmt->fetchAll();

for ( $i = 0; $i < sizeof($workshops); $i++ ) {
	$id = $workshops[$i]['id'];

	$stmt = $con->prepare("SELECT lecturer_workshop.*, lecturers.lec_name AS lecturer 
									FROM lecturer_workshop
									INNER JOIN lecturers
									ON lecturers.id = lecturer_workshop.lecturer_id
									WHERE workshop_id = ?");
	$stmt->execute([$id]);

	$lecturers = $stmt->fetchAll();
	$_lecturers = "";
	for ( $j = 0; $j < sizeof($lecturers); $j++ ) {
		$_lecturers .= $lecturers[$j]['lecturer'];

		if ( sizeof($lecturers) - $j > 2 ) {
			$_lecturers .= ", ";
		} elseif ( sizeof($lecturers) - $j == 2 ) {
			$_lecturers .= " and ";
		}
	}
	$workshops[$i]["lecturers"] = $_lecturers;

	$stmt = $con->prepare("SELECT alumnus_workshop.*, alumni.alu_name 
									FROM alumnus_workshop
									INNER JOIN alumni 
									ON alumni.id = alumnus_workshop.alumnus_id
									WHERE workshop_id = ? AND comment is not null");
	$stmt->execute([$id]);
	$comments = $stmt->fetchAll();
	$workshops[$i]['comments'] = $comments;

	$stmt = $con->prepare("SELECT AVG(rate) FROM alumnus_workshop WHERE workshop_id = ?");
	$stmt->execute([$id]);
	$avg = $stmt->fetch()['AVG(rate)'];
	if ( $avg == null ) {
		$avg = 0;
	}
	$workshops[$i]['rate'] = $avg;
}

if ( isAlumnus() ) {
	$stmt = $con->prepare("SELECT workshop_id FROM alumnus_workshop WHERE alumnus_id = ?");
	$stmt->execute([$_SESSION['id']]);
	$result = $stmt->fetchAll();
	$myWorkshops = [];
	foreach ( $result as $w ) {
		$myWorkshops[] = $w['workshop_id'];
	}
} else {
	$myWorkshops = [];
}

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();

$categories = $stmt->fetchAll();
?>

	<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
			background-repeat: no-repeat;
			background-size: contain;
			background-position: right;
			background-color: #e5f1ed;">
		<div class="container h1 py-5">Workshops</div>
	</div>

	<div class="container  py-5">

		<div id="filters" class="button-group">
			<button onclick="getWorkshops('all')" class="button is-checked">show all</button>
			<?php foreach ( $categories as $category ): ?>
				<button onclick="getWorkshops('<?= $category['id'] ?>')" class="button"
						data-filter=".catg-<?= $category['id'] ?>"><?= $category['catg_name'] ?></button>
			<?php endforeach; ?>
		</div>

		<div id="workshops">
			<?php foreach ( $workshops as $workshop ): ?>
				<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
						background-repeat: no-repeat;
						background-size: contain;
						background-position: right;
						background-color: #e5f1ed;">
					<div class="card-body font-weight-bold">
						<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $workshop['wshop_name'] ?></h4>
						<hr/>
						<div class="row">
							<div class="col-md-4">
								<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
									<i class="icon fas fa-map-marker-alt "></i> <?= $workshop['location'] ?>
								</p>
							</div>
							<div class="col-md-5">
								<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
									<i class="icon fa fa-user "></i> <?= $workshop['lecturers'] ?>
								</p>
							</div>
							<div class="col-md-3">
								<div id="rate-<?= $workshop['id'] ?>">
									<input name="rate-<?= $workshop['id'] ?>"
										   class="kv-ltr-theme-fas-star rating-loading" value="<?= $workshop['rate'] ?>" dir="ltr"
										   data-size="xs" onchange="rate_workshop(this)">
								</div>
							</div>

						</div>
						<div class="row card-text">
							<div class="col h5  font-weight-bold no-text-wrap">
								<i class="icon fas fa-layer-group "></i> <?= $workshop['category'] ?>
							</div>
							<div class="col h5 font-weight-bold no-text-wrap">
								<p title="Start Date">
									<i class="icon far fa-clock "></i> <?= date("Y-m-d", strtotime($workshop['start_date'] ) ) ?>
								</p>

								<p title="End Date">
									<i class="icon far fa-clock "></i> <?= date("Y-m-d", strtotime( $workshop['end_date'] ) ) ?>
								</p>
							</div>

							<div class="col h5  font-weight-bold no-text-wrap">
								<i class="icon fas fa-envelope-open-text "></i> <?= $workshop['details'] ?>
							</div>

							<?php if ( $workshop['deadline'] > date("Y-m-d") && isAlumnus() && !in_array($workshop['id'], $myWorkshops) ): ?>
								<div class="col h5  font-weight-bold no-text-wrap  text-center">
									<a href="<?= $_SERVER['REQUEST_URI'] ?>?workshop_id=<?= $workshop['id'] ?>"
									   class="btn btn-sm btn-dark" type="submit">Apply</a>
								</div>
							<?php elseif ( isAlumnus() && in_array($workshop['id'], $myWorkshops) ): ?>
								<div class="col h5  font-weight-bold no-text-wrap text-center">
									<button class="btn btn-sm btn-dark"><?= ucfirst(workshopState($workshop['id'], $_SESSION['id'])) ?></button>
								</div>
							<?php endif; ?>

							<?php if ( $workshop['deadline'] < date("Y-m-d") && isset($workshop['comments']) ): ?>
								<div class="col-12 ">
									<h4 class="text-center">
										<br/>
										Comments
										<hr class="w-50"/>
									</h4>

									<div class="SeeMore">
										<?php foreach ( $workshop['comments'] as $comment ): ?>
											<div class="media mb-3 bg-light shadow rounded p-3 item">
												<a href="#"><img class="mr-3" src="<?= asset("Images/logo.png") ?>"
																 width="30px"
																 height="30px" alt="Generic placeholder image"></a>
												<div class="media-body">
													<h4 class=""><?= $comment['alu_name'] ?></h4>
													<p class="text-muted"><?= $comment['comment'] ?></p>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( in_array($workshop['id'], $myWorkshops) && workshopState($workshop['id'], $_SESSION['id']) == "finished"  ): ?>
								<div class="col-12 ">
									<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
										<input type="hidden" name="workshop_id" value="<?= $workshop['id'] ?>">
										<label for="comment">Add Comment</label>
										<textarea name="comment" id="comment" class="form-control"></textarea>
										<br>
										<button class="btn btn-sm btn-dark" type="submit">Add Comment</button>
									</form>
								</div>
							<?php endif; ?>
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