<?php include "../../init/init.php"; ?>

<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
background-repeat: no-repeat;
    background-size: contain;
    background-position: right;
    background-color: #e5f1ed;">

    <div class="container h1 py-5">
        Login
    </div>
</div>

<div class="container font-weight-bold py-5">
    <div class="row">

        <div class="col-md">

        </div>
        <div class="col-md">

            <form>


                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>


                <p class="text-center">

                    <button type="submit" class="btn btn-primary btn-lg ">Login</button>
                </p>
            </form>
        </div>
        <div class="col-md">

        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>