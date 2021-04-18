<?php
$page = "courses";
require_once "../../init/init.php";

if ( isset($_GET['course_id']) && isAlumnus() ) {
	$course_id = $_GET['course_id'];
	$alumnus_id = $_SESSION['id'];

	$stmt = $con->prepare("INSERT INTO alumnus_course(alumnus_id, course_id) VALUES(?, ?)");
	$stmt->execute([$alumnus_id, $course_id]);
	redirect("courses");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$course_id = $_POST['course_id'];
	$alumnus_id = $_SESSION['id'];
	$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

	$stmt = $con->prepare("UPDATE alumnus_course SET comment = ? WHERE course_id = ? AND alumnus_id = ?");
	$stmt->execute([$comment, $course_id, $alumnus_id]);

	redirect("courses");
}

$stmt = $con->prepare("SELECT
								courses.*, categories.catg_name AS category, lecturers.lec_name AS lecturer
       						FROM 
       						     courses
       						INNER JOIN categories
       						ON categories.id = courses.category_id
       						INNER JOIN lecturers
       						ON lecturers.id = courses.lecturer_id");
$stmt->execute();

$courses = $stmt->fetchAll();
for ( $i = 0; $i < sizeof($courses); $i++ ) {
	$id = $courses[$i]['id'];

	$stmt = $con->prepare("SELECT AVG(rate) FROM alumnus_course WHERE course_id = ?");
	$stmt->execute([$id]);
	$avg = $stmt->fetch()['AVG(rate)'];
	if ( $avg == null ) {
		$avg = 0;
	}
	$courses[$i]['rate'] = $avg;

	$stmt = $con->prepare("SELECT alumnus_course.*, alumni.alu_name 
									FROM alumnus_course
									INNER JOIN alumni 
									ON alumni.id = alumnus_course.alumnus_id
									WHERE course_id = ? AND comment is not null");
	$stmt->execute([$id]);
	$comments = $stmt->fetchAll();
	$courses[$i]['comments'] = $comments;
}

if ( isAlumnus() ) {
	$stmt = $con->prepare("SELECT course_id FROM alumnus_course WHERE alumnus_id = ?");
	$stmt->execute([$_SESSION['id']]);
	$result = $stmt->fetchAll();
	$myCourses = [];
	foreach ( $result as $c ) {
		$myCourses[] = $c['course_id'];
	}
} else {
	$myCourses = [];
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
		<div class="container h1 py-5">Courses</div>
	</div>

	<div class="container  py-5">

		<div id="filters" class="button-group">
			<button onclick="getCourses('*')" class="button is-checked" data-filter="*">show all</button>
			<?php foreach ( $categories as $category ): ?>
				<button onclick="getCourses('<?= $category['id'] ?>')" class="button"
						data-filter=".catg-<?= $category['id'] ?>"><?= $category['catg_name'] ?></button>
			<?php endforeach; ?>
		</div>

		<div id="courses">
			<?php foreach ( $courses as $course ): ?>
				<div class="element-item  catg-<?= $course['category_id'] ?>">
					<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
							background-repeat: no-repeat;
							background-size: contain;
							background-position: right;
							background-color: #e5f1ed;">
						<div class="card-body font-weight-bold">
							<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $course['crs_name'] ?></h4>
							<hr/>
							<!-- Location and Lecturer -->
							<div class="row">
								<div class="col-md-4">
									<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
										<i class="icon fas fa-map-marker-alt "></i> <?= $course['location'] ?>
									</p>
								</div>
								<div class="col-md-5">
									<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
									<i class="icon fa fa-user "></i> <?= $course['lecturer'] ?>
									</p>
								</div>
								<div class="col-md-3">
									<div id="rate-<?= $course['id'] ?>">
										<input name="rate-<?= $course['id'] ?>"
											   class="kv-ltr-theme-fas-star rating-loading" value="<?= $course['rate'] ?>" dir="ltr"
											   data-size="xs" onchange="rate_course(this)">
									</div>
								</div>
							</div>

							<div class="row card-text">
								<!-- Category, Dates and Details -->
								<div class="col h5 font-weight-bold no-text-wrap">
									<i class="icon fas fa-layer-group "></i> <?= $course['category'] ?>
								</div>
								<div class="col h5 font-weight-bold no-text-wrap">
									<p title="Start Date">
										<i class="icon far fa-clock "></i> <?= $course['start_date'] ?>
									</p>

									<p title="End Date">
										<i class="icon far fa-clock "></i> <?= $course['end_date'] ?>
									</p>
								</div>
								<div class="col h5 font-weight-bold no-text-wrap">
									<i class="icon fas fa-envelope-open-text "></i> <?= $course['details'] ?>
								</div>


								<!-- Label -->
								<?php if ( $course['deadline'] > date("Y-m-d") && isAlumnus() && !in_array($course['id'], $myCourses) ): ?>
									<div class="col h5  font-weight-bold no-text-wrap  text-center">
										<a href="<?= route("courses/show.php") ?>?course_id=<?= $course['id'] ?>"
										   class="btn btn-sm btn-dark" type="submit">Apply</a>
									</div>
								<?php elseif ( isAlumnus() && in_array($course['id'], $myCourses) ): ?>
									<div class="col h5  font-weight-bold no-text-wrap  text-center">
										<button class="btn btn-sm btn-dark"><?= ucfirst(courseState($course['id'], $_SESSION['id'])) ?></button>
									</div>
								<?php endif; ?>

								<?php if ( isset($course['comments']) ): ?>
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
								<?php if ( in_array($course['id'], $myCourses) && courseState($course['id'], $_SESSION['id']) == "finished" ): ?>
									<div class="col-12 ">
										<form action="<?= route("courses/show.php") ?>" method="post">
											<input type="hidden" name="course_id" value="<?= $course['id'] ?>">
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
				</div>
				<br/>
				<br/>
			<?php endforeach ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {

		});
	</script>
<?php require_once "../includes/footer.php"; ?>