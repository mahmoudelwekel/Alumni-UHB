<?php
$page = "departments";
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

	/** Validating the College  */
	if ( $_POST['college'] != 0 ) {
		$college = $_POST['college'];
	} else {
		$_SESSION['msg'][] = "You Must Select a College";
	}

	if ( empty($_SESSION['msg']) ) {
		$stmt = $con->prepare("INSERT INTO departments(dept_name, college_id) VALUES (?, ?)");
		$stmt->execute([$name, $college]);

		redirect("departments");
	}
}

getErrors();

$stmt = $con->prepare("SELECT * FROM colleges");
$stmt->execute();

$colleges = $stmt->fetchAll();

?>

<div class="container py-5">
    <h3>Add College</h3>
    <hr />

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= $_POST['name'] ?? "" ?>">
        </div>

		<div class="form-group">
			<label for="college">College</label>
			<select class="form-control" id="college" name="college">
				<option value="0">...</option>
				<?php foreach ($colleges as $college): ?>
					<option value="<?= $college['id'] ?>"><?= $college['colg_name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>

<?php require_once"../includes/footer.php"; ?>