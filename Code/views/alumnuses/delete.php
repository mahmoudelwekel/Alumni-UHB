<?php
include "../../init/init.php";

if ( isset( $_GET['id'] ) ) {
	$stmt = $con->prepare("DELETE FROM alumnuses WHERE id = ?");
	$stmt->execute([$_GET['id']]);
}

redirect("alumnuses");