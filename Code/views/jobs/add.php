<?php
$page = "jobs";
require_once"../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
	/** Validating the Name */
	if ($_POST['name'] != "") {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Name";
	}

	/** Validating the Company */
	if ($_POST['company'] != "") {
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Company";
	}

	/** Validating the Link */
	if ($_POST['link'] != "") {
		$link = filter_var($_POST['link'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Link";
	}

	/** Validating the Name */
	if ($_POST['details'] != "") {
		$details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
	} else {
		$_SESSION['msg'][] = "You Must Enter The Details";
	}

	if ( empty($_SESSION['msg']) ) {
		$stmt = $con->prepare("INSERT INTO jobs(job_name, company, details, link, category_id) VALUES (?, ?, ?, ?, ?)");
		$stmt->execute([$name, $company, $details, $link, $_POST['category']]);
		redirect("jobs");
	}
}

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();
getErrors();
?>

	<div class="container py-5">
    <h3>Add Job</h3>
    <hr />
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="name">Title</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= $_POST['name'] ?? "" ?>">
        </div>
        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" class="form-control" id="company" name="company" required value="<?= $_POST['company'] ?? "" ?>">
        </div>
        <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" required value="<?= $_POST['link'] ?? "" ?>">
        </div>
        
        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3" required><?= $_POST['details'] ?? "" ?></textarea>
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

		<button type="submit" class="btn btn-primary ">Save</button>
        <a href="index.php" class="btn btn-secondary ml-3">Close</a>
    </form>
</div>
<?php require_once"../includes/footer.php"; ?>