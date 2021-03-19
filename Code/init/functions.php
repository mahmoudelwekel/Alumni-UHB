<?php

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
	$stmt->execute([$lecturer_id]);

	$result = $stmt->fetch();
	$department_id = $result['department_id'];

	$stmt = $con->prepare("SELECT college_id FROM departments WHERE id = ? LIMIT 1");
	$stmt->execute([$department_id]);

	$result = $stmt->fetch();
	return $result['college_id'];
}