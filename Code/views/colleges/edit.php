<?php
$page = "colleges";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	/** Validating the Name */
	if( $_POST['name'] != "" ) {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Title";
	}

	$id = $_POST['id'];

	if ( empty( $_SESSION['msg'] ) ) {
		$stmt = $con->prepare("UPDATE colleges SET colg_name = ? WHERE id = ?");
		$stmt->execute([$name, $id]);

		redirect("colleges");
	}
}

$stmt = $con->prepare("SELECT * FROM colleges WHERE id = ? LIMIT 1");
$stmt->execute([$_GET['id']]);
$college = $stmt->fetch();


?>

<div class="container py-5">
    <h3>Edit Category</h3>
    <hr />

    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
		<input type="hidden" name="id" value="<?= $college['id'] ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $college['colg_name'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>

<?php require_once"../includes/footer.php"; ?>