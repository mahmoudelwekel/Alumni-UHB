<?php
$page = "lecturers";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$id = $_POST['id'];
	/** Validating the SSN */
	if( $_POST['ssn'] != "" ) {
		$ssn = filter_var($_POST['ssn'], FILTER_SANITIZE_STRING);

		if ( isExistInExcept($ssn, "lecturers", "SSN", $id) ) {
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

		if ( isExistInExcept($email, "lecturers", "email", $id) ) {
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
		$password = getColumn('lecturers', "password", $id);
		$salt = getColumn('lecturers', "salt", $id);
	}

	/** Validating the Department */
	if ( $_POST['department'] != 0 ) {
		$department = $_POST['department'];
	} else {
		$_SESSION['msg'][] = "You Must Select a Department";
	}

	/** Validating the Phone */
	if( $_POST['phone'] != "" ) {
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

		if ( isExistInExcept($phone, "lecturers", "phone", $id) ) {
			$_SESSION['msg'][] = "The SSN Must Be Unique";
		}
	} else {
		$_SESSION['msg'][] = "You Must Enter The Phone";
	}

	/** Validating the CV */
	$cv = $_FILES['cv'];
	if( !empty( $_FILES['cv']['name'] ) ) {
		$cvName	= rand(1000000, 9999999) . $cv['name'];
		$cvTmp = $cv['tmp_name'];
		move_uploaded_file( $cvTmp, "..\..\uploads\cvs\\" . $cvName );
	} else {
		$cvName = getColumn("lecturers", 'cv', $id);
	}
	$gender = $_POST['gender'];

	if ( empty( $_SESSION['msg'] ) ) {
		$stmt = $con->prepare("UPDATE lecturers SET 
                     SSN = ?, 
                     lec_name = ?, 
                     email = ?, 
                     password = ?, 
                     salt = ?, 
                     phone = ?, 
                     cv = ?,
                     department_id = ?,
					 gender = ?
                     WHERE 
                     id = ?");
		$stmt->execute([$ssn, $name, $email, $password, $salt, $phone, $cvName, $department, $gender, $id]);

		redirect("lecturers");
	}
}

$stmt = $con->prepare("SELECT * FROM colleges");
$stmt->execute();

$colleges = $stmt->fetchAll();

if ( isset( $_GET['id'] ) ) {
	$stmt = $con->prepare("SELECT * FROM lecturers WHERE id = ? LIMIT 1");
	$stmt->execute([$_GET['id']]);

	$lecturer = $stmt->fetch();

	$college_id = getCollegeId($lecturer['id']);
} else {
	redirect("lecturers");
}

getErrors();
?>

<div class="container py-5">
    <h3>Edit Lecturer</h3>
    <hr />

	<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?= $lecturer['id'] ?>" name="id" required>

		<div class="form-group">
			<label for="ssn">SSN</label>
			<input type="text" class="form-control" id="ssn" name="ssn" value="<?= $_POST['ssn'] ?? $lecturer['SSN'] ?>" required>
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? $lecturer['lec_name'] ?>" required>
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
						<?php if( $college['id'] == $college_id ): ?>
							selected
						<?php endif; ?>
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
			<input type="email" class="form-control" id="email" name="email" value="<?= $_POST['email'] ?? $lecturer['email'] ?>" required>
		</div>

		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="text" class="form-control" id="phone" name="phone" value="<?= $_POST['phone'] ?? $lecturer['phone'] ?>" required>
		</div>

		<div class="form-group">
			<label for="gender">Gender</label>
			<select class="form-control" id="gender" name="gender">
				<option value="0">Male</option>
				<option value="1" <?php if($lecturer['gender']) echo "selected"; ?> >Female</option>
			</select>
		</div>

		<div class="form-group">
			<label for="cv">CV</label>
			<input type="file" class="filestyle" id="cv" name="cv">
		</div>

		<button type="submit" class="btn btn-primary">Save</button>
		<a href="<?= route("lecturers") ?>" class="btn btn-secondary ml-3">Close</a>
	</form>
</div>

<?php require_once"../includes/footer.php"; ?>
<script>
	getDepartments(<?= $college_id ?>);
</script>
