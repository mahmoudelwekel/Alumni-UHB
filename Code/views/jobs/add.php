<?php
$page = "jobs";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

?>

	<div class="container py-5">
    <h3>
        Add Job
    </h3>
    <hr />

    <form>

        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Company</label>
            <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Link</label>
            <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Details</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>



<?php require_once"../includes/footer.php"; ?>