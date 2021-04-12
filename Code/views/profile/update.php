<?php require_once "../../init/init.php";

if ( isAdmin() || isVisitor() ) {
	redirect("public");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$id = $_SESSION['id'];
	if ( isAlumnus() ) {
		$ssn = $_POST['ssn'];
		$name = $_POST['name'];
		$email = $_POST['email'];

		if( $_POST['password'] != "" ) {
			$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

			$salt = substr( md5( rand() ), 0, 10);
			$password = sha1( $password . $salt );
		} else {
			$password = getColumn('alumni', "password", $id);
			$salt = getColumn('alumni', "salt", $id);
		}

		$phone = $_POST['phone'];
		$department = $_POST['department'];

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


	} elseif ( isLecturer() ) {
		$ssn = $_POST['ssn'];
		$name = $_POST['name'];
		$email = $_POST['email'];

		if( $_POST['password'] != "" ) {
			$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

			$salt = md5( rand() );
			$password = sha1( $password . $salt );
		} else {
			$password = getColumn('lecturers', "password", $id);
			$salt = getColumn('lecturers', "salt", $id);
		}
		$phone = $_POST['phone'];
		$department = $_POST['department'];

		$cv = $_FILES['cv'];
		if( !empty( $_FILES['cv']['name'] ) ) {
			$cvName	= rand(1000000, 9999999) . $cv['name'];
			$cvTmp = $cv['tmp_name'];
			move_uploaded_file( $cvTmp, "..\..\uploads\cvs\\" . $cvName );
		} else {
			$cvName = getColumn("lecturers", 'cv', $id);
		}
		$gender = $_POST['gender'];

		$stmt = $con->prepare("UPDATE lecturers SET 
                     SSN = ?, 
                     lec_name = ?, 
                     email = ?, 
                     password = ?, 
                     salt = ?, 
                     phone = ?, 
                     cv = ?,
                     department_id = ?
					 gender = ?
                     WHERE 
                     id = ?");
		$stmt->execute([$ssn, $name, $email, $password, $salt, $phone, $cvName, $department, $gender, $id]);
	}
//	redirect("profile");
}

if ( isAlumnus() ) {
	$id = $_SESSION['id'];
	$stmt = $con->prepare("SELECT * FROM alumni WHERE id = ? LIMIT 1");
	$stmt->execute([$id]);
	$user = $stmt->fetch();

	$college_id = getCollegeId($id, "alumni");
} elseif ( isLecturer() ) {
	$id = $_SESSION['id'];
	$stmt = $con->prepare("SELECT * FROM lecturers WHERE id = ? LIMIT 1");
	$stmt->execute([$id]);
	$user = $stmt->fetch();
	$college_id = getCollegeId($id);
} elseif ( isAdmin() ) {
	$id = $_SESSION['id'];
	$stmt = $con->prepare("SELECT * FROM admins WHERE id = ? LIMIT 1");
	$stmt->execute([$id]);
	$user = $stmt->fetch();
} else {
	redirect("public");
}

$stmt = $con->prepare("SELECT * FROM colleges");
$stmt->execute();
$colleges = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM departments");
$stmt->execute();
$departments = $stmt->fetchAll();

?>
<div class="container py-5">
	<h3>Update Profile</h3>
	<hr/>

	<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
		<?php if( isLecturer() || isAlumnus() ): ?>
			<div class="form-group">
				<label for="ssn">SSN</label>
				<input type="text" class="form-control" id="ssn" name="ssn" value="<?= $_POST['ssn'] ?? $user['SSN'] ?>" required>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name"
				   value="<?= $_POST['name'] ?? $user['lec_name'] ?? $user['alu_name'] ?? "" ?>" required>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" name="email" id="email" value="<?= $_POST['email'] ?? $user['email'] ?? "" ?>" required>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>

		<?php if ( isAlumnus() || isLecturer() ): ?>
			<div class="form-group">
				<label for="college">College</label>
				<select class="form-control" id="college" name="college">
					<option value="0">...</option>
					<?php foreach ( $colleges as $college ): ?>
						<option
								value="<?= $college['id'] ?>"
								<?php if ( $college['id'] == $college_id ) echo "selected"; ?>
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
				<label for="phone">Phone</label>
				<input type="text" class="form-control" id="phone" name="phone"
					   value="<?= $_POST['phone'] ?? $user['phone'] ?>" required>
			</div>
		<?php endif; ?>

		<?php if( isLecturer() ): ?>
			<div class="form-group">
				<label for="gender">Gender</label>
				<select class="form-control" id="gender" name="gender">
					<option value="0">Male</option>
					<option value="1" <?php if($user['gender']) echo "selected"; ?> >Female</option>
				</select>
			</div>

			<div class="form-group">
				<label for="cv">CV</label>
				<input type="file" class="filestyle" id="cv" name="cv">
			</div>

		<?php endif; ?>

		<button type="submit" class="btn btn-primary ">Save</button>
		<a href="index.php" class="btn btn-secondary ml-3">Close</a>
	</form>
</div>

<?php require_once "../includes/footer.php"; ?>
<script>
	<?php if ( isset($college_id) ): ?>
	getDepartments(<?= $college_id ?>);
	<?php endif; ?>
</script>

