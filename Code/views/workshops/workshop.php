<?php
$page = "workshops";
require_once "../../init/init.php";

if ( !isAdmin() ) {
	redirect("workshops/show.php");
}

if ( !isset($_GET['id']) ) {
	redirect("workshops");
}

if ( isset($_GET['alumnus_id']) ) {
	$stmt = $con->prepare("UPDATE alumnus_workshop SET state = ? WHERE workshop_id = ? AND alumnus_id = ?");
	$stmt->execute([$_GET['state'], $_GET['id'], $_GET['alumnus_id']]);

	redirect("workshops/workshop.php?id=" . $_GET['id']);
}

$stmt = $con->prepare("SELECT
								workshops.*, categories.catg_name AS category
       						FROM 
       						     workshops
       						INNER JOIN categories
       						ON categories.id = workshops.category_id
       						WHERE workshops.id = ?
       						LIMIT 1");
$stmt->execute([$_GET['id']]);

$workshop = $stmt->fetch();

$stmt = $con->prepare('SELECT alumnus_workshop.state, alumni.*
								FROM alumnus_workshop
								INNER JOIN alumni
								ON alumni.id = alumnus_workshop.alumnus_id
								WHERE workshop_id = ?');
$stmt->execute([$_GET['id']]);
$alumni = $stmt->fetchAll();

$stmt = $con->prepare("SELECT lecturer_workshop.*, lecturers.lec_name AS lecturer 
									FROM lecturer_workshop
									INNER JOIN lecturers
									ON lecturers.id = lecturer_workshop.lecturer_id
									WHERE workshop_id = ?");
$stmt->execute([$_GET['id']]);

$lecturers = $stmt->fetchAll();
$_lecturers = "";
for ( $i = 0; $i < sizeof($lecturers); $i++ ) {
	$_lecturers .= $lecturers[$i]['lecturer'];

	if ( sizeof($lecturers) - $i > 2 ) {
		$_lecturers .= ", ";
	} elseif ( sizeof($lecturers) - $i == 2 ) {
		$_lecturers .= " and ";
	}
}
$workshop["lecturers"] = $_lecturers;

?>

	<div class="container py-5">
		<div class="card shadow" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
				background-repeat: no-repeat;
				background-size: contain;
				background-position: right;
				background-color: #e5f1ed;">
			<div class="card-body font-weight-bold">
				<h4 class="card-title font-weight-bold h3 text-dark text-left"><?= $workshop['wshop_name'] ?></h4>
				<hr/>
				<div class="row">
					<div class="col-md-4">
						<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
							<i class="icon fas fa-map-marker-alt "></i> <?= $workshop['location'] ?>
						</p>
					</div>
					<div class="col-md-8">
						<p class="card-text text-decoration-none text-secondary  h5  font-weight-bold my-4">
							<i class="icon fa fa-user "></i> <?= $workshop['lecturers'] ?>
						</p>
					</div>

				</div>
				<div class="row card-text">
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon fas fa-layer-group "></i> <?= $workshop['category'] ?>
					</div>
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon far fa-clock "></i> <?= $workshop['deadline'] ?>
					</div>
					<div class="col h5  font-weight-bold no-text-wrap">
						<i class="icon fas fa-envelope-open-text "></i> <?= $workshop['details'] ?>
					</div>
				</div>
			</div>
		</div>
		<br/>
		<br/>

		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered w-100">
				<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>State</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $alumni as $alumnus ): ?>
					<tr>
						<td><?= $alumnus['id'] ?></td>
						<td><?= $alumnus['alu_name'] ?></td>
						<td><?= ucfirst($alumnus['state']) ?></td>
						<td>
							<?php if ( $alumnus['state'] == "pending" ): ?>
								<a class="btn btn-sm mb-1 btn-dark"
								   href="<?= route("workshops/workshop.php?id=" . $workshop['id'] . "&alumnus_id=" . $alumnus['id'] . "&state=accepted") ?>">Accept</a>
								<a class="btn btn-sm mb-1 btn-dark"
								   href="<?= route("workshops/workshop.php?id=" . $workshop['id'] . "&alumnus_id=" . $alumnus['id'] . "&state=refused") ?>">Refuse</a>
							<?php elseif ( $alumnus['state'] != "finished" && $alumnus['state'] != "refused" ): ?>
								<a class="btn btn-sm mb-1 btn-dark"
								   href="<?= route("workshop/workshop.php?id=" . $workshop['id'] . "&alumnus_id=" . $alumnus['id'] . "&state=finished") ?>">Finish</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php require_once "../includes/footer.php"; ?>