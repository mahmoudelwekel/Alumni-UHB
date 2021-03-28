<?php
$page = "workshops";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	var_dump($_POST);
	/** Validating the Name */
	if( $_POST['name'] != "" ) {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Name";
	}

	/** Validating the Location */
	if( $_POST['location'] != "" ) {
		$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Location";
	}

	/** Validating the Deadline */
	if( $_POST['deadline'] != "" ) {
		$deadline = filter_var($_POST['deadline'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Deadline";
	}

	/** Validating the Details */
	if( $_POST['details'] != "" ) {
		$details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Details";
	}

	/** Validating the Lecturers */
	if( !empty( $_POST['lecturers'] ) ) {
		$lecturers = $_POST['lecturers'];
	} else {
		$_SESSION['msg'][] = "You Must Select the Lecturers";
	}

	/** Validating the Category */
	if( $_POST['category'] == 0 ) {
		$_SESSION['msg'][] = "You Must Choose The Category";
	} else {
		$category = $_POST['category'];
	}

	if ( empty($_SESSION['msg']) ) {
		$stmt = $con->prepare("INSERT INTO workshops(wshop_name, deadline, location, details, category_id) VALUES (?, ?, ?, ?, ?)");
		$stmt->execute([$name, $deadline, $location, $details, $category]);

		$id = $con->lastInsertId();
		foreach ( $lecturers as $lecturer ) {
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
            <label for="deadline">DeadLine</label>
            <input type="date" class="form-control" id="deadline" name="deadline">
        </div>

        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3"></textarea>
        </div>

		<div class="form-group">
			<label for="category">Category</label>
			<select class="form-control" id="category" name="category">
				<?php foreach ($categories as $category): ?>
					<option value="<?= $category['id'] ?>"><?= $category['catg_name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="lecturers">Lecturers</label>
			<div>
				<div class="row">
					<?php foreach ( $lecturers as $lecturer ): ?>
						<div class="col-md-4">
							<input type="checkbox" id="lecturer-<?= $lecturer['id'] ?>" name="lecturers[]" value="<?= $lecturer['id'] ?>">
							<label for="lecturer-<?= $lecturer['id'] ?>"><?= $lecturer['lec_name'] ?></label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>



<?php require_once"../includes/footer.php"; ?>