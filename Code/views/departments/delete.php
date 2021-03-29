<?php
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if ( isset( $_GET['id'] ) ) {
	$stmt = $con->prepare("DELETE FROM departments WHERE id = ?");
	$stmt->execute([$_GET['id']]);
}

redirect("departments");