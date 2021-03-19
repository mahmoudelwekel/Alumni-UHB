<?php
include "../../init/init.php";

if ( isset( $_GET['id'] ) ) {
	$stmt = $con->prepare("DELETE FROM courses WHERE id = ?");
	$stmt->execute([$_GET['id']]);
}

redirect("courses");