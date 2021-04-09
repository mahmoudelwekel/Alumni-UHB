<?php
$page = "courses";
require_once "../../init/init.php";

if ( !isAdmin() ) {
	redirect("courses/show.php");
}

if ( !isset($_GET['id']) ) {
	redirect("courses");
}

if ( isset($_GET['alumnus_id']) ) {
	$stmt = $con->prepare("UPDATE alumnus_course SET state = ? WHERE course_id = ? AND alumnus_id = ?");
	$stmt->execute(["finished", $_GET['id'], $_GET['alumnus_id']]);

	redirect("courses/course.php?id=" . $_GET['id']);
}

$stmt = $con->prepare("SELECT
								courses.*, categories.catg_name AS category, lecturers.lec_name AS lecturer
       						FROM 
       						     courses
       						INNER JOIN categories
       						ON categories.id = courses.category_id
       						INNER JOIN lecturers
       						ON lecturers.id = courses.lecturer_id
       						WHERE courses.id = ?
       						LIMIT 1");
$stmt->execute([$_GET['id']]);

$course = $stmt->fetch();

$stmt = $con->prepare('SELECT alumnus_course.state, alumni.*
								FROM alumnus_course
								INNER JOIN alumni
								ON alumni.id = alumnus_course.alumnus_id
								WHERE course_id = ?');
$stmt->execute([$_GET['id']]);
$alumni = $stmt->fetchAll();
?>

	<div class="container py-5">
		<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
				background-repeat: no-repeat;
				background-size: contain;
				background-position: right;
				background-color: #e5f1ed;">
			<div class="card-body font-weight-bold">
				<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $course['crs_name'] ?></h4>
				<hr/>
				<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
					<i class="icon fas fa-map-marker-alt "></i> <?= $course['location'] ?>
				</p>
				<div class="row card-text">
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon fas fa-layer-group "></i> <?= $course['category'] ?>
					</div>
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon far fa-clock "></i> <?= $course['deadline'] ?>
					</div>
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon fas fa-envelope-open-text "></i> <?= $course['details'] ?>
					</div>

					<?php if ( $course['deadline'] > date("Y-m-d") ): ?>
						<div class="col h5  font-weight-bold no-text-wrap  text-center">
							<button class="btn btn-sm btn-dark" type="submit">Open</button>
						</div>
					<?php else: ?>
						<button class="btn btn-sm btn-dark">Finished</button>
					<?php endif; ?>
				</div>

				<?php if ( $course['deadline'] < date("Y-m-d") && sizeof($course['comments']) ): ?>
					<div class="col-12 ">
						<h4 class="text-center">
							<br/>
							Comments
							<hr class="w-50"/>
						</h4>

						<div class="SeeMore">
							<?php foreach ( $course['comments'] as $comment ): ?>
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
			</div>
		</div>
		<br/>
		<br/>

		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered w-100">
				<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>State</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $alumni as $alumnus ): ?>
					<tr>
						<td><?= $alumnus['id'] ?></td>
						<td><?= $alumnus['alu_name'] ?></td>
						<td><?= ucfirst($alumnus['state']) ?></td>
						<td>
							<?php if ( $alumnus['state'] == "pending" ): ?>
								<a class="btn btn-sm mb-1 btn-dark"
								   href="<?= route("courses/course.php?id=" . $course['id'] . "&alumnus_id=" . $alumnus['id']) ?>">Finish</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php require_once "../includes/footer.php"; ?>