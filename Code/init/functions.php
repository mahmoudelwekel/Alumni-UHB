<?php

function setActive( $_page ) {
	global $page;
	if ( $page == $_page ) {
		echo "active";
	}
}

function setTitle() {
	global $title;
	if ( isset($title) ) {
		echo $title;
	} else {
		echo "alumni";
	}
}

function asset( $file ) {
	return "../../assets/" . $file;
}

function route( $path ) {
	return "/alumni-uhb/Code/views/" . $path;
}

function uploads( $file ) {
	return "/alumni-uhb/Code/uploads/" . $file;
}

function redirect( $path ) {
	header("Location: /alumni-uhb/Code/views/" . $path);
	exit();
}

function isExistIn( $value, $table, $column ) {
	global $con;

	$stmt = $con->prepare("SELECT $column FROM $table WHERE $column = ? LIMIT 1");
	$stmt->execute([$value]);

	$num = $stmt->rowCount();
	return $num != 0;
}

function isExistInExcept( $value, $table, $column, $id ) {
	global $con;

	$stmt = $con->prepare("SELECT $column FROM $table WHERE $column = ? AND id != ? LIMIT 1");
	$stmt->execute([$value, $id]);

	$num = $stmt->rowCount();
	return $num != 0;
}

function getColumn($table, $column, $id) {
	global $con;

	$stmt = $con->prepare("SELECT $column FROM $table WHERE id = ? LIMIT 1");
	$stmt->execute([$id]);
	$result = $stmt->fetch();

	return $result[$column];
}

function getCollegeId( $user_id, $table = "lecturers" ) {
	global $con;

	$stmt = $con->prepare("SELECT department_id FROM $table WHERE id = ? LIMIT 1");
	$stmt->execute([$user_id]);

	$result = $stmt->fetch();
	$department_id = $result['department_id'];

	$stmt = $con->prepare("SELECT college_id FROM departments WHERE id = ? LIMIT 1");
	$stmt->execute([$department_id]);

	$result = $stmt->fetch();
	return $result['college_id'];
}

function getErrors() {
	if ( isset( $_SESSION['msg'] ) ) {
		foreach ( $_SESSION['msg'] as $msg ) {
			?>
			<div class="alert alert-danger col-8 offset-2"><?= $msg ?></div>
			<?php
		}
		unset( $_SESSION['msg'] );
	}
}

function logIn( $email, $password ) {
	if ( ( $id = isLogInFromTable( $email, $password, "admins" ) ) > 0 ) {
		return ["admin", $id];
	} elseif ( ( $id = isLogInFromTable( $email, $password, "lecturers" ) ) > 0 ) {
		return ["lecturer", $id];
	} elseif ( ( $id = isLogInFromTable( $email, $password, "alumni" ) ) > 0 ) {
		return ["alumnus", $id];
	} else {
		return ["not valid", 0];
	}
}

function isLogInFromTable( $email, $password, $table ) {
	global $con;
	$stmt = $con->prepare("SELECT salt FROM $table WHERE email = ? LIMIT 1");
	$stmt->execute([$email]);
	if ( $stmt->rowCount() > 0 ) {
		$result = $stmt->fetch();
		$salt = $result['salt'];

		$pass = sha1( $password . $salt );

		$stmt = $con->prepare("SELECT * FROM $table WHERE email = ? AND password = ? LIMIT 1");
		$stmt->execute([$email, $pass]);

		if ( $stmt->rowCount() > 0 ) {
			$result = $stmt->fetch();
			return $result['id'];
		}
	}
	return 0;
}

function courseState($course_id, $alumnus_id) {
	global $con;
	$stmt = $con->prepare("SELECT state FROM alumnus_course WHERE course_id = ? AND alumnus_id = ? LIMIT 1");
	$stmt->execute([$course_id, $alumnus_id]);

	if ( $stmt->rowCount() > 0 ) {
		$result = $stmt->fetch();
		return $result['state'];
	} else {
		return null;
	}
}

function workshopState($workshop_id, $alumnus_id) {
	global $con;
	$stmt = $con->prepare("SELECT state FROM alumnus_workshop WHERE workshop_id = ? AND alumnus_id = ? LIMIT 1");
	$stmt->execute([$workshop_id, $alumnus_id]);

	if ( $stmt->rowCount() > 0 ) {
		$result = $stmt->fetch();
		return $result['state'];
	} else {
		return null;
	}
}

function isAdmin() {
	if ( isset( $_SESSION['type'] ) ) {
		return $_SESSION['type'] == "admin";
	}
	return false;
}

function isLecturer() {
	if ( isset( $_SESSION['type'] ) ) {
		return $_SESSION['type'] == "lecturer";
	}
	return false;
}

function isAlumnus() {
	if ( isset( $_SESSION['type'] ) ) {
		return $_SESSION['type'] == "alumnus";
	}
	return false;
}

function isVisitor() {
	return !( isAdmin() || isLecturer() || isAlumnus() );
}