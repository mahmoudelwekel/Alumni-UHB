<!DOCTYPE html>
<html lang="en">

<head>
    <title>Alumni UHB</title>
    <link rel="icon" href="<?= asset("Images/logo.png") ?>" type="image/png" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1,shrink-to-fit=no" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-16" />

    <link rel="stylesheet" href="<?= asset("css/bootstrap.min.css") ?>" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

    <link rel="stylesheet" href="<?= asset("css/style.css") ?>" />
</head>

<body>
    <div style="background-image: url('<?= asset("Images/header.jpg") ?>');background-repeat: no-repeat;
    background-size: cover;
    background-position: center; ">
        <div class="container d-flex justify-content-start align-items-center">
            <img src="<?= asset("Images/logo.png") ?>" class="my-4" />
        </div>
    </div>


    <nav class="navbar navbar-expand-lg navbar-light bg-light font-weight-bold">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="<?= route("courses") ?>">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="<?= route("courses") ?>">Courses</a>
                    <a class="nav-item nav-link" href="<?= route("workshops") ?>">WorkShops</a>
                    <a class="nav-item nav-link" href="<?= route("jobs") ?>">Jobs</a>
                    <a class="nav-item nav-link" href="<?= route("lecturers") ?>">Lecturers</a>
                    <a class="nav-item nav-link" href="<?= route("public/login.php") ?>">Login</a>
                </div>
            </div>
        </div>
    </nav>