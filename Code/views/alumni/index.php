<?php
$page = "alumni";
require_once "../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

$stmt = $con->prepare("SELECT
	alumni.*, colleges.colg_name, departments.dept_name
	FROM 
	    alumni 
    INNER JOIN departments ON alumni.department_id = departments.id 
    INNER JOIN colleges ON departments.college_id = colleges.id");
$stmt->execute();

$alumni = $stmt->fetchAll();
?>
	<div class="container py-5">
		<h3>Alumni</h3>
		<hr/>
		<a class="btn btn-block mb-3 btn-primary" href="<?= route("alumni/add.php") ?>">Add New</a>

		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered w-100">
				<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>SSN</th>
					<th>Email</th>
					<th>Phone</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ( $alumni as $alumnus ): ?>
					<tr>
						<td><?= $alumnus['id'] ?></td>
						<td><?= $alumnus['alu_name'] ?></td>
						<td><?= $alumnus['SSN'] ?></td>
						<td><?= $alumnus['email'] ?></td>
						<td><?= $alumnus['phone'] ?></td>
						<td>
							<a class="btn btn-sm mb-1 btn-dark"
							   href="<?= route("alumni/edit.php?id=" . $alumnus['id']) ?>">Edit</a>
							<a class="btn btn-sm mb-1 btn-danger"
							   href="<?= route("alumni/delete.php?id=" . $alumnus['id']) ?>">Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

<?php require_once "../includes/footer.php"; ?>