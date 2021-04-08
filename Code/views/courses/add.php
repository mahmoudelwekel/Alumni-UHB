<?php
$page = "courses";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	/** Validating the Name */
	if( $_POST['name'] != "" ) {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Title";
	}

	/** Validating the Location */
	if( $_POST['location'] != "" ) {
		$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Location";
	}

	/** Validating the Details */
	if( $_POST['details'] != "" ) {
		$details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Details";
	}

	/** Validating the Category */
	if ( $_POST['category'] != 0 ) {
		$category = $_POST['category'];
	} else {
		$_SESSION['msg'][] = "You Must Select the Category";
	}

	/** Validating the Lecturer */
	if ( $_POST['lecturer'] != 0 ) {
		$lecturer = $_POST['lecturer'];
	} else {
		$_SESSION['msg'][] = "You Must Select the Lecturer";
	}

	$start_date = date("Y-m-d H:i:s", strtotime( $_POST['start_date'] ) );
	$end_date = date("Y-m-d H:i:s", strtotime( $_POST['end_date'] ) );
	$deadline = $_POST['deadline'];

	if ( empty( $_SESSION['msg'] ) ) {
		$stmt = $con->prepare("INSERT INTO
    									courses(crs_name, location, details, start_date, end_date, deadline, lecturer_id, category_id) 
    									VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->execute([$name, $location, $details, $start_date, $end_date, $deadline, $lecturer, $category]);

		redirect("courses");
	}
}

getErrors();

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM lecturers");
$stmt->execute();
$lecturers = $stmt->fetchAll();

?>

<div class="container py-5">
    <h3>Add Course</h3>
    <hr />
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="name" required value="<?= $_POST['name'] ?? "" ?>">
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" required value="<?= $_POST['location'] ?? "" ?>">
        </div>

        <div class="form-group">
            <label for="details">Details</label>
			<textarea id="details" class="form-control" name="details" required><?= $_POST['details'] ?? "" ?></textarea>
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
			<input type="date" class="form-control" id="deadline" name="deadline" required value="<?= $_POST['deadline'] ?? "" ?>">
		</div>

		<div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
				<option value="0">...</option>
				<?php foreach ($categories as $category): ?>
					<option value="<?= $category['id'] ?>"><?= $category['catg_name'] ?></option>
				<?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="lecturer">Lecturer</label>
			<select class="form-control" id="lecturer" name="lecturer">
				<option value="0">...</option>
				<?php foreach ($lecturers as $lecturer): ?>
					<option value="<?= $lecturer['id'] ?>"><?= $lecturer['lec_name'] ?></option>
				<?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>



<?php require_once"../includes/footer.php"; ?>