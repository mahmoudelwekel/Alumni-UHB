<?php
$page = "alumnuses";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

?>

<?php require_once"../includes/footer.php"; ?>
