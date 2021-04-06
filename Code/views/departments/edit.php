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

	/** Validating the College */
	if ( $_POST['college'] != 0 ) {
		$college = $_POST['college'];
	} else {
		$_SESSION['msg'][] = "You Must Select a College";
	}

	$id = $_POST['id'];

	if ( empty( $_SESSION['msg'] ) ) {
		$stmt = $con->prepare("UPDATE departments SET dept_name = ?, college_id = ? WHERE id = ?");
		$stmt->execute([$name, $college, $id]);

		redirect("colleges");
	}
}

$stmt = $con->prepare("SELECT * FROM departments WHERE id = ? LIMIT 1");
$stmt->execute([$_GET['id']]);
$department = $stmt->fetch();

$stmt = $con->prepare("SELECT * FROM colleges");
$stmt->execute();
$colleges = $stmt->fetchAll();

?>

<div class="container py-5">
    <h3>Edit Department</h3>
    <hr />

    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
		<input type="hidden" name="id" value="<?= $department['id'] ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $department['dept_name'] ?>" required>
        </div>

		<div class="form-group">
			<label for="category">Category</label>
			<select class="form-control" id="category" name="category">
				<option value="0">...</option>
				<?php foreach ($colleges as $college): ?>
					<option value="<?= $college['id'] ?>"
							<?php if ( $college['id'] == $department['college_id'] ): ?>
								selected
							<?php endif; ?>
					>
						<?= $college['colg_name'] ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>

<?php require_once"../includes/footer.php"; ?>