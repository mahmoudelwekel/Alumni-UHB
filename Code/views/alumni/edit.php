<?php
$page = "alumni";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$id = $_POST['id'];
	/** Validating the SSN */
	if( $_POST['ssn'] != "" ) {
		$ssn = filter_var($_POST['ssn'], FILTER_SANITIZE_STRING);

		if ( isExistInExcept($ssn, "alumni", "SSN", $id) ) {
			$_SESSION['msg'][] = "The SSN Must Be Unique";
		}
	} else {
		$_SESSION['msg'][] = "You Must Enter The SSN";
	}

	/** Validating the Name */
	if( $_POST['name'] != "" ) {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Name";
	}

	/** Validating the Email */
	if( $_POST['email'] != "" ) {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

		if ( isExistInExcept($email, "alumni", "email", $id) ) {
			$_SESSION['msg'][] = "The Email Must Be Unique";
		}
	} else {
		$_SESSION['msg'][] = "You Must Enter The Email";
	}

	/** Validating the Password */
	if( $_POST['password'] != "" ) {
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		$salt = substr( md5( rand() ), 0, 10);
		$password = sha1( $password . $salt );
	} else {
		$password = getColumn('alumni', "password", $id);
		$salt = getColumn('alumni', "salt", $id);
	}

	/** Validating the SSN */
	if ( $_POST['department'] != 0 ) {
		$department = $_POST['department'];
	} else {
		$_SESSION['msg'][] = "You Must Select a Department";
	}

	/** Validating the SSN */
	if( $_POST['phone'] != "" ) {
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

		if ( isExistInExcept($phone, "alumni", "phone", $id) ) {
			$_SESSION['msg'][] = "The SSN Must Be Unique";
		}
	} else {
		$_SESSION['msg'][] = "You Must Enter The Phone";
	}

	if ( empty( $_SESSION['msg'] ) ) {
		$stmt = $con->prepare("UPDATE alumni SET 
						 SSN = ?, 
						 alu_name = ?, 
						 email = ?, 
						 password = ?, 
						 salt = ?, 
						 phone = ?, 
						 department_id = ?
                     WHERE 
                     	id = ?");
		$stmt->execute([$ssn, $name, $email, $password, $salt, $phone, $department, $id]);

		redirect("alumni");
	}
}

$stmt = $con->prepare("SELECT * FROM colleges");
$stmt->execute();

$colleges = $stmt->fetchAll();

if ( isset( $_GET['id'] ) ) {
	$stmt = $con->prepare("SELECT * FROM alumni WHERE id = ? LIMIT 1");
	$stmt->execute([$_GET['id']]);

	$alumnus = $stmt->fetch();

	$college_id = getCollegeId( $alumnus['id'], "alumni" );
} else {
	$_SESSION['msg'][] = "Error in the URL, You Must Pass the ID";
}

if ( isset( $_SESSION['msg'] ) ) {
	foreach ( $_SESSION['msg'] as $msg ) {
		?>
			<div class="alert alert-danger col-8 offset-2"><?= $msg ?></div>
		<?php
	}
	unset( $_SESSION['msg'] );
}
?>

<div class="container py-5">
	<h3>Edit Alumnus</h3>
	<hr />

	<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?= $alumnus['id'] ?>" name="id">

		<div class="form-group">
			<label for="ssn">SSN</label>
			<input type="text" class="form-control" id="ssn" name="ssn" value="<?= $alumnus['SSN'] ?>" required>
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="<?= $alumnus['alu_name'] ?>" required>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>

		<div class="form-group">
			<label for="college">College</label>
			<select class="form-control" id="college">
				<option value="0">...</option>
				<?php foreach ($colleges as $college): ?>
					<option
						value="<?= $college['id'] ?>"
						<?php if( $college['id'] == $college_id ) echo "selected"; ?>
					>
						<?= $college['colg_name'] ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="department">Department</label>
			<select class="form-control" id="department" name="department">
				<option value="0">...</option>
			</select>
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?= $alumnus['email'] ?>" required>
		</div>

		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="text" class="form-control" id="phone" name="phone" value="<?= $alumnus['phone'] ?>" required>
		</div>

		<button type="submit" class="btn btn-primary">Save</button>
		<a href="<?= route("lecturers") ?>" class="btn btn-secondary ml-3">Close</a>
	</form>
</div>

<?php require_once"../includes/footer.php"; ?>
<script>
	getDepartments(<?= $college_id ?>);
</script>
