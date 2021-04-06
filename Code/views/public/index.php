<?php
$page = "home";
require_once "../../init/init.php";

$stmt = $con->prepare("SELECT courses.*, lecturers.lec_name AS lecturer 
								FROM courses 
								INNER JOIN lecturers 
								ON lecturers.id = courses.lecturer_id 
								ORDER BY courses.deadline DESC 
								LIMIT 3");
$stmt->execute();
$courses = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM workshops 
								ORDER BY deadline DESC 
								LIMIT 3");
$stmt->execute();
$workshops = $stmt->fetchAll();

$stmt = $con->prepare("Select lecturers.* , COUNT(courses.id), COUNT(lecturer_workshop.id), ( COUNT(courses.id) + COUNT(lecturer_workshop.id) ) as shares
								From lecturers
								LEFT JOIN courses
								ON lecturers.id = courses.lecturer_id
								LEFT JOIN lecturer_workshop
								ON lecturers.id = lecturer_workshop.lecturer_id
								GROUP BY lecturers.id
								ORDER by shares DESC
								Limit 3");
$stmt->execute();
$lecturers = $stmt->fetchAll();

for( $i = 0; $i < sizeof( $lecturers ); $i++ ) {
	$id = $lecturers[$i]['id'];
	$stmt = $con->prepare("SELECT SUM(ac) as total_sum
										FROM ( SELECT courses.*, COUNT(alumnus_course.id) AS ac 
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
										FROM ( SELECT workshops.*, COUNT(alumnus_workshop.id) AS aw 
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

<div id="carouselExampleInterval" class="carousel slide bg-white  " data-ride="carousel">
	<div class="carousel-inner shadow ">
		<div class="carousel-item active" data-interval="3000">
			<img src="<?= asset("Images/slider/slider1.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Title 1</h4>
				<hr>
				<p>
					Description 1
				</p>
			</div>
		</div>
		<div class="carousel-item" data-interval="3000">
			<img src="<?= asset("Images/slider/slider2.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Title 2</h4>
				<hr>
				<p>
					Description 2
				</p>
			</div>
		</div>
		<div class="carousel-item" data-interval="3000">
			<img src="<?= asset("Images/slider/slider3.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Title 3</h4>
				<hr>
				<p>
					Description 3
				</p>
			</div>
		</div>

	</div>
	<a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon bg-dark rounded-circle p-1" style="background-origin: content-box;"
			  aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next " href="#carouselExampleInterval" role="button" data-slide="next">
		<span class="carousel-control-next-icon bg-dark rounded-circle p-1" style="background-origin: content-box;"
			  aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>


<div class="container py-5">
	<Courses>
		<h2 class=" pb-4 font-weight-bold">Recent Courses</h2>
		<div class="card-deck">
			<?php foreach ($courses as $course): ?>
			<div class="card">
				<img class="card-img-top Cardimage" src="<?= asset("Images/course.jpeg"); ?>" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary"><?= $course['crs_name'] ?></h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-user-tie "></i> <?= $course['lecturer'] ?>
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> <?= $course['location'] ?>
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> <?= $course['start_date'] ?>
					</p>
				</div>
<!--				<a href="#" class="card-footer font-weight-bold">-->
<!--					Details >>-->
<!--				</a>-->
			</div>
			<?php endforeach; ?>
		</div>
	</Courses>

	<br/>
	<br/>
	<hr/>
	<br/>
	<br/>


	<workshops>

		<h2 class=" pb-4 font-weight-bold">Recent workshops</h2>
		<div class="card-deck">
			<?php foreach ($workshops as $workshop): ?>
			<div class="card">
				<img class="card-img-top Cardimage" src="<?= asset("Images/workshop.jpeg") ?>" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary"><?= $workshop['wshop_name'] ?></h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> <?= $workshop['location'] ?>
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> <?= $workshop['deadline'] ?>
					</p>
				</div>
<!--				<a href="#" class="card-footer font-weight-bold">-->
<!--					Details >>-->
<!--				</a>-->
			</div>
			<?php endforeach; ?>
		</div>
	</workshops>
	<br/>
	<br/>
	<hr/>
	<br/>
	<br/>
	<TopLecturers>
		<h2 class=" pb-4 font-weight-bold">Top Participated Lecturers</h2>
		<div class="card-deck">
			<?php foreach ($lecturers as $lecturer): ?>
			<div class="card Cardbackground" style="background-image:url('<?= asset("Images/bg/" . ( $lecturer['gender'] ? "female" : "male" ) . ".jpg") ?>') ;">
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
<!--					<a href="#" class="card-text text-right font-weight-bold">-->
<!--						Details >>-->
<!--					</a>-->
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</TopLecturers>


</div>


<?php require_once "../includes/footer.php"; ?>

