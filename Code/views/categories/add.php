<?php
$page = "categories";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	/** Validating the Name */
	if( $_POST['name'] != "" ) {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Name";
	}

	if ( empty($_SESSION['msg']) ) {
		$stmt = $con->prepare("INSERT INTO categories(catg_name) VALUES (?)");
		$stmt->execute([$name]);

		redirect("categories");
	}
}

getErrors();
?>

<div class="container py-5">
    <h3>Add Category</h3>
    <hr />

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" id="title" name="name" required value="<?= $_POST['name'] ?? "" ?>">
        </div>

		<button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>

<?php require_once"../includes/footer.php"; ?>