<?php
$page = "workshops";
require_once "../../init/init.php";

if (!isAdmin()) {
	redirect("public");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	/** Validating the Name */
	if ($_POST['name'] != "") {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Name";
	}

	/** Validating the Location */
	if ($_POST['location'] != "") {
		$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Location";
	}

	/** Validating the Deadline */
	if ($_POST['deadline'] != "") {
		$deadline = filter_var($_POST['deadline'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Deadline";
	}

	/** Validating the Details */
	if ($_POST['details'] != "") {
		$details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Details";
	}

	/** Validating the Lecturers */
	if (!empty($_POST['lecturers'])) {
		$lecturers = $_POST['lecturers'];
	} else {
		$_SESSION['msg'][] = "You Must Select the Lecturers";
	}

	/** Validating the Category */
	if ($_POST['category'] == 0) {
		$_SESSION['msg'][] = "You Must Choose The Category";
	} else {
		$category = $_POST['category'];
	}

	$start_date = date("Y-m-d H:i:s", strtotime( $_POST['start_date'] ) );
	$end_date = date("Y-m-d H:i:s", strtotime( $_POST['end_date'] ) );

	if (empty($_SESSION['msg'])) {
		$stmt = $con->prepare("INSERT INTO workshops(wshop_name, deadline, start_date, end_date, location, details, category_id) VALUES (?, ?, ?, ?,?, ?, ?)");
		$stmt->execute([$name, $deadline, $start_date, $end_date,$location, $details, $category]);

		$id = $con->lastInsertId();
		foreach ($lecturers as $lecturer) {
			$stmt = $con->prepare("INSERT INTO lecturer_workshop(lecturer_id, workshop_id) VALUES(?, ?)");
			$stmt->execute([$lecturer, $id]);
		}

		redirect("workshops");
	}
}

$stmt = $con->prepare("SELECT * FROM lecturers");
$stmt->execute();

$lecturers = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();

$categories = $stmt->fetchAll();

getErrors();
?>

<div class="container py-5">
	<h3>Add Workshop</h3>
	<hr />

	<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" id="title" name="name">
		</div>

		<div class="form-group">
			<label for="location">Location</label>
			<input type="text" class="form-control" id="location" name="location">
		</div>

		<div class="form-group">
			<label for="start_date">Start Date</label>
			<input type="datetime-local" class="form-control" id="start_date" name="start_date" required value="<?= $_POST['start_date'] ?? "" ?>">
		</div>

		<div class="form-group">
			<label for="end_date">End Date</label>
			<input type="datetime-local" class="form-control" id="end_date" name="end_date" required value="<?= $_POST['end_date'] ?? "" ?>">
		</div>

		<div class="form-group">
			<label for="deadline">DeadLine</label>
			<input type="date" class="form-control" id="deadline" name="deadline">
		</div>

		<div class="form-group">
			<label for="details">Details</label>
			<textarea class="form-control" id="details" name="details" rows="3"></textarea>
		</div>

		<div class="form-group">
			<label for="category">Category</label>
			<select class="form-control selectpicker " data-live-search="true" id="category" name="category">
				<?php foreach ($categories as $category) : ?>
					<option value="<?= $category['id'] ?>"><?= $category['catg_name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<fieldset class="p-2 border rounded mb-3" id="lecturersContainer">
			<legend style="width: auto!important;">Lecturers</legend>
			<div class="form-row lecturerDiv" id="lecturerDiv">
				<div class="col-3 mb-3">
					<label for="lecturers">Lecturer</label>
					<select class="form-control " data-live-search="true" name="lecturers[]">
						<?php foreach ($lecturers as $lecturer) : ?>
							<option value="<?= $lecturer['id'] ?>"><?= $lecturer['lec_name'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-3 mb-3">
					<label for="lecturers_start">Start</label>
					<input type="datetime-local" class="form-control" id="lecturers_start" name="lecturer_start[]" required>
				</div>
				<div class="col-3 mb-3">
					<label for="lecturers_end">End</label>
					<input type="datetime-local" class="form-control" id="lecturers_end" name="lecturers_end[]" required>
				</div>
				<div class="col-2 d-flex align-items-end mb-3">
					<span  class="btn btn-primary btn-block addLecturer" onclick="addLecturer()"><i class="fas fa-plus"></i></span>
				</div>
				<div class="col-1 d-flex align-items-end mb-3">
					<span  class="btn btn-danger btn-block addLecturer" onclick="RemoveLecturer(this)"><i class="fas fa-times"></i></span>
				</div>
			</div>
		</fieldset>

		<button type="submit" class="btn btn-primary ">Save</button>
		<a href="index.php" class="btn btn-secondary ml-3">Close</a>
	</form>
</div>

<script>
	function addLecturer () {
		$("#lecturerDiv").clone().insertAfter("div.lecturerDiv:last");
	}

	function RemoveLecturer (lem) {
		if( $('.lecturerDiv').length !== 1 ) {

			$(lem).parent().parent().remove();
		}
	}
</script>

<?php require_once "../includes/footer.php"; ?>