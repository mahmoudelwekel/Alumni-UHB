<?php
require_once "../../init/init.php";

$stmt = $con->prepare("SELECT * FROM lecturers");
$stmt->execute();

$lecturers = $stmt->fetchAll();

var_dump($lecturers);

?>


<?php
require_once "../includes/footer.php";
