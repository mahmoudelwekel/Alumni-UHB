<?php
$page = "courses";
require_once"../../init/init.php"; ?>

<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
background-repeat: no-repeat;
    background-size: contain;
    background-position: right;
    background-color: #e5f1ed;">

    <div class="container h1 py-5">
        Courses
    </div>
</div>

<div class="container  py-5">

    <div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
background-repeat: no-repeat;
    background-size: contain;
    background-position: right;
    background-color: #e5f1ed;">

        <div class="card-body font-weight-bold">
            <h4 class="card-title font-weight-bold h3 text-dark text-left">Course Title</h4>
            <hr />
            <p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
                <i class="icon fas fa-map-marker-alt "></i> Location
            </p>
            <div class="row card-text">
                <div class="col h5  font-weight-bold no-text-wrap">
                    <i class="icon fas fa-layer-group "></i> Category
                </div>
                <div class="col h5  font-weight-bold no-text-wrap">
                    <i class="icon far fa-clock "></i> Time
                </div>
                <div class="col h5  font-weight-bold no-text-wrap">
                    <i class="icon fas fa-envelope-open-text "></i> Details
                </div>
                <div class="col h5  font-weight-bold no-text-wrap  text-center">
                    <button class="btn btn-sm btn-dark" type="submit">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <br />
    <br />
    <br />

    <div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
background-repeat: no-repeat;
    background-size: contain;
    background-position: right;
    background-color: #e5f1ed;">

        <div class="card-body font-weight-bold">
            <div class="row card-text">
                <div class="col-md-9 ">

                    <h4 class="card-title font-weight-bold h3 text-dark text-left">Course Title</h4>
                    <p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
                        <i class="icon fas fa-map-marker-alt "></i> Location
                    </p>
                    <div class="row card-text">
                        <div class="col h5  font-weight-bold no-text-wrap">
                            <i class="icon fas fa-layer-group "></i> Category
                        </div>
                        <div class="col h5  font-weight-bold no-text-wrap">
                            <i class="icon far fa-clock "></i> Time
                        </div>
                        <div class="col h5  font-weight-bold no-text-wrap">
                            <i class="icon fas fa-envelope-open-text "></i> Details
                        </div>

                    </div>
                </div>
                <div class="col-md-3 text-center pt-4">
                    <input id="input-1-ltr-star-xs " name="input-1-ltr-star-xs" class="kv-ltr-theme-fas-star rating-loading" value="1" dir="ltr" data-size="xs">
                    <button class="btn  btn-secondary mt-2" type="submit">Finished</button>


                </div>


            </div>

            <hr />
            <div class="col-12 ">

                <h4 class="text-center">
                    Comments
                    <br />
                    <i class="fas fa-chevron-down"></i>
                </h4>

                <div class="media mb-3 bg-light shadow rounded p-3">
                    <a href="#"><img class="mr-3" src="<?= asset("Images/logo.png") ?>" width="30px" height="30px" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h4 class="">Mahmoud Elwekel</h4>
                        <p class=""> 14/3/2021 15:21:35</p>
                        <p class="text-muted">Very nice</p>
                    </div>
                </div>

                <div class="media mb-3 bg-light shadow rounded p-3">
                    <a href="#"><img class="mr-3" src="<?= asset("Images/logo.png") ?>" width="30px" height="30px" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h4 class="">Mahmoud Elwekel</h4>
                        <p class=""> 14/3/2021 15:21:35</p>
                        <p class="text-muted">Very nice</p>
                    </div>
                </div>

                <div class="media mb-3 bg-light shadow rounded p-3">
                    <a href="#"><img class="mr-3" src="<?= asset("Images/logo.png") ?>" width="30px" height="30px" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h4 class="">Mahmoud Elwekel</h4>
                        <p class=""> 14/3/2021 15:21:35</p>
                        <p class="text-muted">Very nice</p>
                    </div>
                </div>

                <div class="media mb-3 bg-light shadow rounded p-3">
                    <a href="#"><img class="mr-3" src="<?= asset("Images/logo.png") ?>" width="30px" height="30px" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h4 class="">Mahmoud Elwekel</h4>
                        <p class=""> 14/3/2021 15:21:35</p>
                        <p class="text-muted">Very nice</p>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.kv-ltr-theme-fas-star').rating({
                hoverOnClear: false,
                theme: 'krajee-fas',
                containerClass: 'is-star',
                showCaption: false,
                stars: 3,

            });
        });
    </script>






























</div>





<?php require_once"../includes/footer.php"; ?>