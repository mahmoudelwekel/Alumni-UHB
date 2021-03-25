<?php require_once"../../init/init.php"; ?>


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

		<h2 class=" pb-4 font-weight-bold">
			Recent Courses
		</h2>
		<div class="card-deck">
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?4" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-user-tie "></i> Lecturer Name
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?5" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-user-tie "></i> Lecturer Name
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?6" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-user-tie "></i> Lecturer Name
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>


		</div>
	</Courses>

	<br/>
	<br/>
	<hr/>
	<br/>
	<br/>


	<workshops>

		<h2 class=" pb-4 font-weight-bold">
			Recent workshops
		</h2>
		<div class="card-deck">
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?7" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?8" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>
			<div class="card">
				<img class="card-img-top Cardimage" src="https://source.unsplash.com/random?9" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title font-weight-bold  text-primary">Workshop Title</h5>
					<hr/>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-map-marker-alt "></i> Location
					</p>
					<p class="card-text text-decoration-none text-secondary">
						<i class="icon fas fa-calendar-alt"></i> 12:12 12/12/2021
					</p>
				</div>
				<a href="#" class="card-footer font-weight-bold">
					Details >>
				</a>
			</div>

		</div>
	</workshops>


	<br/>
	<br/>
	<hr/>
	<br/>
	<br/>

	<TopLecturers>

		<h2 class=" pb-4 font-weight-bold">
			Top Participated Lecturers
		</h2>
		<div class="card-deck">
			<div class="card Cardbackground" style="background-image:url('Images/bg/female.jpg') ;">
				<div class="card-body" style="padding-top: 65%;">
					<h5 class="card-title font-weight-bold h3 text-dark text-center">Lecturer Name</h5>
					<hr/>
					<div class="d-flex justify-content-around  text-center font-weight-bold">
                        <span>
                            <i class=" fas fa-share-alt fa-2x"></i>
                            <br/>
                            1248
                        </span>
						<span>
                            <i class=" fas fa-users  fa-2x"></i>
                            <br/>
                            55565
                        </span>
					</div>
					<br/>
					<a href="#" class="card-text text-right font-weight-bold">
						Details >>
					</a>
				</div>
			</div>
			<div class="card Cardbackground" style="background-image:url('Images/bg/male.jpg') ;">
				<div class="card-body" style="padding-top: 65%;">
					<h5 class="card-title font-weight-bold h3 text-dark text-center">Lecturer Name</h5>
					<hr/>
					<div class="d-flex justify-content-around  text-center font-weight-bold">
                        <span>
                            <i class=" fas fa-share-alt fa-2x"></i>
                            <br/>
                            1248
                        </span>
						<span>
                            <i class=" fas fa-users  fa-2x"></i>
                            <br/>
                            55565
                        </span>
					</div>
					<br/>
					<a href="#" class="card-text text-right font-weight-bold">
						Details >>
					</a>
				</div>
			</div>
			<div class="card Cardbackground" style="background-image:url('Images/bg/female.jpg') ;">
				<div class="card-body" style="padding-top: 65%;">
					<h5 class="card-title font-weight-bold h3 text-dark text-center">Lecturer Name</h5>
					<hr/>
					<div class="d-flex justify-content-around  text-center font-weight-bold">
                        <span>
                            <i class=" fas fa-share-alt fa-2x"></i>
                            <br/>
                            1248
                        </span>
						<span>
                            <i class=" fas fa-users  fa-2x"></i>
                            <br/>
                            55565
                        </span>
					</div>
					<br/>
					<a href="#" class="card-text text-right font-weight-bold">
						Details >>
					</a>
				</div>
			</div>
		</div>
	</TopLecturers>


</div>


<?php require_once"footer.php"; ?>
