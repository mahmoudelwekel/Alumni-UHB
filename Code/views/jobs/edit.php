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

	$workshops = array_unique($_POST['workshops']);
	$id = $_POST['id'];

	if ( empty($_SESSION['msg']) ) {
		$stmt = $con->prepare("UPDATE jobs
										SET job_name = ?, 
										    company = ?,
										    details = ?,
										    link = ?
										WHERE id = ?");
		$stmt->execute([$name, $company, $details, $link, $id]);

		$stmt = $con->prepare("DELETE FROM workshop_job WHERE job_id = ?");
		$stmt->execute([$id]);

		foreach ($workshops as $workshop) {
			$stmt = $con->prepare("INSERT INTO workshop_job(workshop_id, job_id) VALUES(?, ?)");
			$stmt->execute([$workshop, $id]);
		}
		redirect("jobs");
	}
}

getErrors();

if ( isset($_GET['id']) ) {
	$id = $_GET['id'];
} else {
	redirect("jobs");
}

$stmt = $con->prepare("SELECT * FROM workshops");
$stmt->execute();
$workshops = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM jobs WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$job = $stmt->fetch();

$stmt = $con->prepare("SELECT * FROM workshop_job");
$stmt->execute();
$_job_workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
$job_workshops = [];
foreach ($_job_workshops as $job_workshop) {
	$job_workshops[] = $job_workshop['id'];
}

?>

	<div class="container py-5">
		<h3>Add Job</h3>
		<hr />
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="hidden" value="<?= $job['id'] ?>" name="id">
			<div class="form-group">
				<label for="name">Title</label>
				<input type="text" class="form-control" id="name" name="name" required value="<?= $job['job_name'] ?>">
			</div>
			<div class="form-group">
				<label for="company">Company</label>
				<input type="text" class="form-control" id="company" name="company" required value="<?= $job['company'] ?>">
			</div>
			<div class="form-group">
				<label for="link">Link</label>
				<input type="text" class="form-control" id="link" name="link" required value="<?= $job['link'] ?>">
			</div>

			<div class="form-group">
				<label for="details">Details</label>
				<textarea class="form-control" id="details" name="details" rows="3" required><?= $job['details'] ?></textarea>
			</div>

			<fieldset class="p-2 border rounded mb-3" id="workshopsContainer">
				<legend style="width: auto!important;">Workshops</legend>

				<?php foreach ($job_workshops as $job_workshop): ?>
				<div class="form-row workshopDiv" id="workshopDiv">
					<div class="col-4 mb-3">
						<label for="workshops">Workshop</label>
						<select class="form-control" name="workshops[]" id="workshops">
							<?php foreach ($workshops as $workshop) : ?>
								<option value="<?= $workshop['id'] ?>" <?php if($workshop['id'] == $job_workshop) echo "selected"; ?>><?= $workshop['wshop_name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-2 d-flex align-items-end mb-3">
						<span  class="btn btn-primary btn-block addWorkshop" onclick="addWorkshop()"><i class="fas fa-plus"></i></span>
					</div>
					<div class="col-2 d-flex align-items-end mb-3">
						<span  class="btn btn-danger btn-block addWorkshop" onclick="RemoveWorkshop(this)"><i class="fas fa-times"></i></span>
					</div>
				</div>
				<?php endforeach; ?>

				<?php if( sizeof( $job_workshops ) === 0 ): ?>
				<div class="form-row workshopDiv" id="workshopDiv">
					<div class="col-4 mb-3">
						<label for="workshops">Workshop</label>
						<select class="form-control" name="workshops[]" id="workshops">
							<?php foreach ($workshops as $workshop) : ?>
								<option value="<?= $workshop['id'] ?>"><?= $workshop['wshop_name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-2 d-flex align-items-end mb-3">
						<span  class="btn btn-primary btn-block addWorkshop" onclick="addWorkshop()"><i class="fas fa-plus"></i></span>
					</div>
					<div class="col-2 d-flex align-items-end mb-3">
						<span  class="btn btn-danger btn-block addWorkshop" onclick="RemoveWorkshop(this)"><i class="fas fa-times"></i></span>
					</div>
				</div>
				<?php endif; ?>
			</fieldset>

			<button type="submit" class="btn btn-primary ">Save</button>
			<a href="index.php" class="btn btn-secondary ml-3">Close</a>
		</form>
	</div>

	<script>
		function addWorkshop () {
			$("#workshopDiv").clone().insertAfter("div.workshopDiv:last");
		}

		function RemoveWorkshop (lem) {
			if( $('.workshopDiv').length !== 1 ) {

				$(lem).parent().parent().remove();
			}
		}
	</script>

<?php require_once"../includes/footer.php"; ?>