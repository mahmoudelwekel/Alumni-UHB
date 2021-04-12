<?php
$page = "lecturers";
require_once "../../init/init.php";

$stmt = $con->prepare("Select lecturers.*, (COUNT(DISTINCT courses.id) + COUNT( DISTINCT lecturer_workshop.id) ) as shares
								From lecturers
								LEFT JOIN courses
								ON lecturers.id = courses.lecturer_id
								LEFT JOIN lecturer_workshop
								ON lecturers.id = lecturer_workshop.lecturer_id
								GROUP BY lecturers.id
								ORDER by shares DESC");
$stmt->execute();
$lecturers = $stmt->fetchAll();

for ( $i = 0; $i < sizeof($lecturers); $i++ ) {
	$id = $lecturers[$i]['id'];
	$stmt = $con->prepare("SELECT SUM(ac) as total_sum
										FROM ( SELECT courses.*, COUNT(DISTINCT alumnus_course.alumnus_id) AS ac 
												FROM courses
												INNER JOIN alumnus_course
                                                ON alumnus_course.course_id = courses.id
										    	WHERE lecturer_id = ?
                                                GROUP BY id) AS result");
	$stmt->execute([$id]);
	$courses_alumni = $stmt->fetch()['total_sum'];
	if ( $courses_alumni == null ) {
		$courses_alumni = 0;
	}

	$stmt = $con->prepare("SELECT SUM(aw) as total_sum
										FROM ( SELECT workshops.*, COUNT(DISTINCT alumnus_workshop.alumnus_id) AS aw 
												FROM workshops
												INNER JOIN alumnus_workshop
                                                ON alumnus_workshop.workshop_id = workshops.id
												INNER JOIN lecturer_workshop
												ON lecturer_workshop.workshop_id = workshops.id
										    	WHERE lecturer_id = ?
                                                GROUP BY id) AS result");
	$stmt->execute([$id]);
	$workshops_alumni = $stmt->fetch()['total_sum'];
	if ( $workshops_alumni == null ) {
		$workshops_alumni = 0;
	}

	$lecturers[$i]['learners'] = $courses_alumni + $workshops_alumni;
}

?>

	<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
			background-repeat: no-repeat;
			background-size: contain;
			background-position: right;
			background-color: #e5f1ed;">
		<div class="container h1 py-5">Lecturers</div>
	</div>

	<div class="container  py-5">

	<div class="card-deck" style="flex-flow: column">
		<div class="row">
			<?php foreach ( $lecturers as $lecturer ): ?>
				<div class="col-md-3" style="margin-bottom: 40px">
					<div class="card Cardbackground"
						 style="background-image:url('<?= asset("Images/bg/" . ($lecturer['gender'] ? "female" : "male") . ".jpg") ?>') ;">
						<div class="card-body" style="padding-top: 65%;">
							<h5 class="card-title font-weight-bold h3 text-dark text-center"><?= $lecturer['lec_name'] ?></h5>
							<hr/>
							<div class="d-flex justify-content-around  text-center font-weight-bold">
								<span>
									<i class=" fas fa-share-alt fa-2x"></i>
									<br/>
									<?= $lecturer['shares'] ?>
								</span>
									<span>
									<i class=" fas fa-users  fa-2x"></i>
									<br/>
									<?= $lecturer['learners'] ?>
								</span>
							</div>
							<br/>
							<a href="<?= uploads("cvs/" . $lecturer['cv']); ?>" TARGET="_blank" class="card-text text-right font-weight-bold">
								CV >>
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
<?php require_once "../includes/footer.php"; ?>