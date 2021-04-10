<?php
require_once "../init/db.php";
require_once "../init/functions.php";

if ( isset($_GET) ) {
	if ( $_GET['type'] == "get_departments_by_college" ) {
		$stmt = $con->prepare("SELECT * FROM departments WHERE college_id = ?");
		$stmt->execute([$_GET['college_id']]);
		$departments = $stmt->fetchAll();

		if ( $stmt->rowCount() == 0 ) {
			?>
			<option value="0">...</option>
			<?php
		} else {
			foreach ( $departments as $department ) {
				?>
				<option value="<?= $department['id'] ?>"><?= $department['dept_name'] ?></option>
				<?php
			}
		}
	} elseif ( $_GET['type'] == "get_courses_by_category" ) {
		if ( $_GET['category_id'] == "*" ) {
			$stmt = $con->prepare("SELECT
								courses.*, categories.catg_name AS category, lecturers.lec_name AS lecturer
       						FROM 
       						     courses
       						INNER JOIN categories
       						ON categories.id = courses.category_id
       						INNER JOIN lecturers
       						ON lecturers.id = courses.lecturer_id");
			$stmt->execute([]);
		} else {
			$stmt = $con->prepare("SELECT
								courses.*, categories.catg_name AS category, lecturers.lec_name AS lecturer
       						FROM 
       						     courses
       						INNER JOIN categories
       						ON categories.id = courses.category_id
       						INNER JOIN lecturers
       						ON lecturers.id = courses.lecturer_id
       						WHERE category_id = ?");
			$stmt->execute([$_GET['category_id']]);
		}

		$courses = $stmt->fetchAll();
		for ( $i = 0; $i < sizeof($courses); $i++ ) {
			$id = $courses[$i]['id'];
			$stmt = $con->prepare("SELECT AVG(rate) FROM alumnus_lecturer_rate WHERE course_id = ?");
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

		foreach ( $courses as $course ): ?>
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
						<div class="col-md-8">
							<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
								<i class="icon fa fa-user "></i> <?= $course['lecturer'] ?>
							</p>
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
								<a href="<?= $_SERVER['PHP_SELF'] ?>?course_id=<?= $course['id'] ?>"
								   class="btn btn-sm btn-dark" type="submit">Apply</a>
							</div>
						<?php elseif ( isAlumnus() && in_array($course['id'], $myCourses) ): ?>
							<div class="col h5  font-weight-bold no-text-wrap  text-center">
								<button class="btn btn-sm btn-dark"><?= ucfirst(courseState($course['id'], $_SESSION['id'])) ?></button>
							</div>
						<?php endif; ?>

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
						<?php if ( in_array($course['id'], $myCourses) && courseState($course['id'], $_SESSION['id']) == "finished" ): ?>
							<div class="col-12 ">
								<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
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
			<br/>
			<br/>
		<?php endforeach;
	} elseif ( $_GET['type'] == "get_workshops_by_category" ) {
		if ( $_GET['category_id'] == "*" ) {
			$stmt = $con->prepare("SELECT workshops.*, categories.catg_name AS category FROM workshops
								INNER JOIN categories
								ON categories.id = workshops.category_id");
			$stmt->execute();
		} else {
			$stmt = $con->prepare("SELECT workshops.*, categories.catg_name AS category FROM workshops
								INNER JOIN categories
								ON categories.id = workshops.category_id
								WHERE category_id = ?");
			$stmt->execute([$_GET['category_id']]);
		}

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
				$_lecturers .= $lecturers[$i]['lecturer'];

				if ( sizeof($lecturers) - $j > 2 ) {
					$_lecturers .= ", ";
				} elseif ( sizeof($lecturers) - $j == 2 ) {
					$_lecturers .= " and ";
				}
			}
			$workshops[$i]["lecturers"] = $_lecturers;

			$stmt = $con->prepare("SELECT * FROM lecturer_workshop where workshop_id = ? ORDER BY start_date ASC LIMIT 1");
			$stmt->execute([$id]);
			$start = $stmt->fetch();
			$workshops[$i]["start_date"] = $start["start_date"];

			$stmt = $con->prepare("SELECT * FROM lecturer_workshop where workshop_id = ? ORDER BY end_date DESC LIMIT 1");
			$stmt->execute([$id]);
			$end = $stmt->fetch();
			$workshops[$i]["end_date"] = $end["end_date"];
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

		foreach ( $workshops as $workshop ): ?>
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
						<div class="col-md-8">
							<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
								<i class="icon fa fa-user "></i> <?= $workshop['lecturers'] ?>
							</p>
						</div>

					</div>
					<div class="row card-text">
						<div class="col h5  font-weight-bold no-text-wrap">
							<i class="icon fas fa-layer-group "></i> <?= $workshop['category'] ?>
						</div>
						<div class="col h5 font-weight-bold no-text-wrap">
							<p title="Start Date">
								<i class="icon far fa-clock "></i> <?= $workshop['start_date'] ?>
							</p>

							<p title="End Date">
								<i class="icon far fa-clock "></i> <?= $workshop['end_date'] ?>
							</p>
						</div>

						<div class="col h5  font-weight-bold no-text-wrap">
							<i class="icon fas fa-envelope-open-text "></i> <?= $workshop['details'] ?>
						</div>

						<?php if ( $workshop['deadline'] > date("Y-m-d") && isAlumnus() ): ?>
							<div class="col h5  font-weight-bold no-text-wrap  text-center">
								<a href="<?= $_SERVER['PHP_SELF'] ?>?workshop_id=<?= $workshop['id'] ?>"
								   class="btn btn-sm btn-dark" type="submit">Apply</a>
							</div>
						<?php endif; ?>

						<?php if ( $workshop['deadline'] < date("Y-m-d") && sizeof($workshop['comments']) ): ?>
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
						<?php if ( in_array($workshop['id'], $myWorkshops) ): ?>
							<div class="col-12 ">
								<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
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
		<?php
		endforeach;
	} elseif ( $_GET['type'] == "get_jobs_by_category" ) {
		if ( $_GET['category_id'] == "*" ) {
			$stmt = $con->prepare("SELECT * FROM jobs");
			$stmt->execute();
		} else {
			$stmt = $con->prepare("SELECT * FROM jobs WHERE category_id = ?");
			$stmt->execute([$_GET['category_id']]);
		}
		$jobs = $stmt->fetchAll();

		foreach ($jobs as $job ): ?>
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
		<?php endforeach;

	}
}