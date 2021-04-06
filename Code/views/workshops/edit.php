<?php
$page = "workshops";
require_once"../../init/init.php";

if ( !isAdmin() ) {
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

	if ( empty( $_SESSION['msg'] ) ) {
		$id = $_POST['id'];
		$stmt = $con->prepare("UPDATE workshops
										SET wshop_name = ?,
										    deadline = ?,
										    location = ?,
										    details = ?,
										    category_id = ?
										WHERE id = ?)");
		$stmt->execute([$name, $deadline, $location, $details, $category, $id]);

		$stmt = $con->prepare("DELETE FROM lecturer_workshop WHERE workshop_id = ?");
		$stmt->execute([$id]);

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


if ( isset($_GET['id']) ) {
	$id = $_GET['id'];
} else {
	redirect("workshops");
}
$stmt = $con->prepare("SELECT * FROM workshops WHERE id = ?");
$stmt->execute([$id]);
$workshop = $stmt->fetch();

$stmt = $con->prepare("SELECT * FROM lecturer_workshop WHERE workshop_id = ?");
$stmt->execute([$id]);
$workshop_lecturers = $stmt->fetchAll();

getErrors();

?>

<div class="container py-5">
    <h3>Edit Workshop</h3>
    <hr />

	<form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" id="title" name="name" required value="<?= $workshop['wshop_name'] ?>">
		</div>

		<div class="form-group">
			<label for="location">Location</label>
			<input type="text" class="form-control" id="location" name="location" required value="<?= $workshop['location'] ?>">
		</div>

		<div class="form-group">
			<label for="deadline">DeadLine</label>
			<input type="date" class="form-control" id="deadline" name="deadline" required value="<?= $workshop['deadline'] ?>">
		</div>

		<div class="form-group">
			<label for="details">Details</label>
			<textarea class="form-control" id="details" name="details" rows="3" required><?= $workshop['details'] ?></textarea>
		</div>

		<div class="form-group">
			<label for="category">Category</label>
			<select class="form-control selectpicker " data-live-search="true" id="category" name="category">
				<?php foreach ($categories as $category) : ?>
					<option value="<?= $category['id'] ?>" <?php if ( $category['id'] == $workshop['category_id'] ) echo "selected";?>><?= $category['catg_name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<fieldset class="p-2 border rounded mb-3" id="lecturersContainer">
			<legend style="width: auto!important;">Lecturers</legend>


			<?php foreach ( $workshop_lecturers as $workshop_lecturer ): ?>
			<div class="form-row lecturerDiv" id="lecturerDiv">
				<div class="col-4 mb-3">
					<label for="lecturers">Lecturer</label>
					<select class="form-control" id="lecturers" data-live-search="true" name="lecturers[]">
						<?php foreach ($lecturers as $lecturer) : ?>
							<option value="<?= $lecturer['id'] ?>" <?php if( $lecturer['id'] == $workshop_lecturer['lecturer_id'] ) echo "selected" ?> ><?= $lecturer['lec_name'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-2 mb-3">
					<label for="lecturers_start">Start</label>
					<input type="time" class="form-control" id="lecturers_start" name="lecturer_start[]" required value="<?= $workshop_lecturer['start_date'] ?>">
				</div>
				<div class="col-2 mb-3">
					<label for="lecturers_end">End</label>
					<input type="time" class="form-control" id="lecturers_end" name="lecturers_end[]" required value="<?= $workshop_lecturer['end_date'] ?>">
				</div>
				<div class="col-2 d-flex align-items-end mb-3">
					<span  class="btn btn-primary btn-block addLecturer" onclick="addLecturer()"><i class="fas fa-plus"></i></span>
				</div>
				<div class="col-2 d-flex align-items-end mb-3">
					<span  class="btn btn-danger btn-block addLecturer" onclick="RemoveLecturer(this)"><i class="fas fa-times"></i></span>
				</div>
			</div>
			<?php endforeach; ?>

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