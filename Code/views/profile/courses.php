<?php require_once "../../init/init.php";

if ( isVisitor() ) {
	redirect("public");
}

$id = $_SESSION['id'];
$type = $_SESSION['type'];

if ( isAlumnus() ) {
	$stmt = $con->prepare("SELECT alumnus_course.*, courses.crs_name, courses.location, courses.start_date, lecturers.lec_name
									FROM alumnus_course 
									INNER JOIN courses
									ON alumnus_course.course_id = courses.id
									INNER JOIN lecturers
									ON lecturers.id = courses.lecturer_id
									WHERE alumnus_id = ? AND state = ?");
	$stmt->execute([$id, "finished"]);
} elseif ( isLecturer() ) {
	$stmt = $con->prepare("SELECT courses.*, lecturers.lec_name
									FROM courses
									INNER JOIN lecturers
									ON lecturers.id = courses.lecturer_id
									WHERE lecturer_id = ?");
	$stmt->execute([$id]);
}
$courses = $stmt->fetchAll();

if ( isLecturer() ) {
	for ( $i = 0; $i < sizeof($courses); $i++ ) {
		$stmt = $con->prepare("SELECT COUNT(DISTINCT alumnus_id) AS learners FROM alumnus_course WHERE course_id = ?");
		$stmt->execute([$courses[$i]['id']]);
		$c = $stmt->fetch();

		$courses[$i]['learners'] = $c['learners'];
	}
}
?>

	<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
			background-repeat: no-repeat;
			background-size: contain;
			background-position: right;
			background-color: #e5f1ed;">
		<div class="container h1 py-5">
			Courses
		</div>
	</div>

	<div class="container py-5">
		<div class="row">
			<?php foreach ( $courses as $course ): ?>
				<div class="col-md-4">
					<div class="card">
						<img class="card-img-top p-4" src="<?= asset("Images/logo.png") ?>" alt="Card image cap">
						<div class="card-body">
							<h5 class="card-title font-weight-bold  text-primary"><?= $course['crs_name'] ?></h5>
							<hr/>
							<p class="card-text text-decoration-none text-secondary">
								<i class="icon fas fa-user-tie "></i> <?= $course['lec_name'] ?>
							</p>
							<p class="card-text text-decoration-none text-secondary">
								<i class="icon fas fa-map-marker-alt "></i> <?= $course['location'] ?>
							</p>
							<p class="card-text text-decoration-none text-secondary">
								<i class="icon fas fa-calendar-alt"></i> <?= $course['start_date'] ?>
							</p>
							<?php if ( isLecturer() ): ?>
								<p class="card-text text-decoration-none text-secondary">
									<i class="icon fa fa-users"></i> <?= $course['learners'] ?>
								</p>
							<?php endif; ?>
						</div>
						<?php if ( isAlumnus() && $course['state'] == "finished" ): ?>
							<a href="cerificate.php?course=<?= $course['crs_name'] ?>" target="_blank"
							   class="card-footer font-weight-bold">
								Certificate >>
							</a>
						<?php elseif ( isLecturer() && $course['end_date'] < date("Y-m-d H:i:s") ): ?>
							<a href="cerificate.php?course=<?= $course['crs_name'] ?>" target="_blank"
							   class="card-footer font-weight-bold">
								Certificate >>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>


<?php require_once "../includes/footer.php"; ?>