<?php require_once"../../init/init.php";

session_unset();
session_destroy();

redirect("public");
?>

<?php require_once"../includes/footer.php"; ?>
