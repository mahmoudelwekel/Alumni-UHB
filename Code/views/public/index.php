<?php
$page = "home";
require_once "../../init/init.php";

$stmt = $con->prepare("SELECT courses.*, lecturers.lec_name AS lecturer, categories.catg_name as category
								FROM courses 
								INNER JOIN lecturers 
								ON lecturers.id = courses.lecturer_id 
								INNER JOIN categories
								ON categories.id = courses.category_id
								ORDER BY courses.deadline DESC 
								LIMIT 3");
$stmt->execute();
$courses = $stmt->fetchAll();

$stmt = $con->prepare("SELECT workshops.*, categories.catg_name as category FROM workshops
								INNER JOIN categories
								ON categories.id = workshops.category_id
								ORDER BY deadline DESC 
								LIMIT 3");
$stmt->execute();
$workshops = $stmt->fetchAll();

$stmt = $con->prepare("Select lecturers.*, (COUNT(DISTINCT courses.id) + COUNT( DISTINCT lecturer_workshop.id) ) as shares
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

<div id="carouselExampleInterval" class="carousel slide bg-white  " data-ride="carousel">
	<div class="carousel-inner shadow ">
		<div class="carousel-item active" data-interval="3000">
			<img src="<?= asset("Images/slider/slider1.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Mission</h4>
				<hr>
				<p>
					Qualified  Alumni ready to compete in the Labor market locally and internationally.
				</p>
			</div>
		</div>
		<div class="carousel-item" data-interval="3000">
			<img src="<?= asset("Images/slider/slider2.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Vision</h4>
				<hr>
				<p>
					Enhancing the competitiveness of our alumni in the labor market through vocational training and job rehabilitation
				</p>
			</div>
		</div>
		<div class="carousel-item" data-interval="3000">
			<img src="<?= asset("Images/slider/slider3.jpg") ?>" class="d-block w-100 fullimg">
			<div class="carousel-caption bg-dark  ">
				<h4>Values</h4>
				<hr>
				<p>
					Helping alumni find employment and vocational training opportunities and preserve effective communication with alumni, employment and vocational training destinations.
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
			<?php foreach ( $courses as $course ): ?>
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
					<a class="card-footer font-weight-bold">
						<button class="btn btn-link" data-toggle="modal" data-target="#course<?= $course['id'] ?>">
							Details >>
						</button>
					</a>
				</div>

				<div class="modal fade" id="course<?= $course['id'] ?>" tabindex="-1" role="dialog"
					 aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document" style="max-width: 1000px">

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

									<?php if ( $course['deadline'] > date("Y-m-d") && isAlumnus() ): ?>
										<div class="col h5  font-weight-bold no-text-wrap  text-center">
											<a href="<?= $_SERVER['PHP_SELF'] ?>?course_id=<?= $course['id'] ?>"
											   class="btn btn-sm btn-dark" type="submit">Apply</a>
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
														<a href="#"><img class="mr-3"
																		 src="<?= asset("Images/logo.png") ?>"
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
						</div>
					</div>

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
			<?php foreach ( $workshops as $workshop ): ?>
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
					<a class="card-footer font-weight-bold">
						<button class="btn btn-link" data-toggle="modal" data-target="#workshop<?= $workshop['id'] ?>">
							Details >>
						</button>
					</a>
				</div>

				<div class="modal fade" id="workshop<?= $workshop['id'] ?>" tabindex="-1" role="dialog"
					 aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document" style="max-width: 1000px">
						<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
								background-repeat: no-repeat;
								background-size: contain;
								background-position: right;
								background-color: #e5f1ed;">
							<div class="card-body font-weight-bold">
								<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $workshop['wshop_name'] ?></h4>
								<hr/>
								<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
									<i class="icon fas fa-map-marker-alt "></i> <?= $workshop['location'] ?>
								</p>
								<div class="row card-text">
									<div class="col h5  font-weight-bold no-text-wrap">
										<i class="icon fas fa-layer-group "></i> <?= $workshop['category'] ?>
									</div>
									<div class="col h5  font-weight-bold no-text-wrap">
										<i class="icon far fa-clock "></i> <?= $workshop['deadline'] ?>
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

									<?php if ( isset($workshop['comments']) ): ?>
										<div class="col-12 ">
											<h4 class="text-center">
												<br/>
												Comments
												<hr class="w-50"/>
											</h4>

											<div class="SeeMore">
												<?php foreach ( $workshop['comments'] as $comment ): ?>
													<div class="media mb-3 bg-light shadow rounded p-3 item">
														<a href="#"><img class="mr-3"
																		 src="<?= asset("Images/logo.png") ?>"
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
						</div>
					</div>
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
			<?php foreach ( $lecturers as $lecturer ): ?>
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
						<a href="<?= uploads("cvs/" . $lecturer['cv']); ?>" TARGET="_blank"
						   class="card-text text-right font-weight-bold">
							CV >>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</TopLecturers>


</div>


<?php require_once "../includes/footer.php"; ?>

