<?php include "../../init/init.php";

$stmt = $con->prepare("SELECT
	alumnuses.*, colleges.colg_name, departments.dept_name
	FROM 
	    alumnuses 
    INNER JOIN departments ON alumnuses.department_id = departments.id 
    INNER JOIN colleges ON departments.college_id = colleges.id");
$stmt->execute();

$alumnuses = $stmt->fetchAll();

?>

	<div class="container py-5">
		<h3>Lecturers</h3>
		<hr/>
		<a class="btn btn-block mb-3 btn-primary" href="<?= route("alumnuses/add.php") ?>">Add New</a>

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
					<?php foreach ( $alumnuses as $alumnus ): ?>
						<tr>
							<td><?= $alumnus['id'] ?></td>
							<td><?= $alumnus['alu_name'] ?></td>
							<td><?= $alumnus['SSN'] ?></td>
							<td><?= $alumnus['email'] ?></td>
							<td><?= $alumnus['phone'] ?></td>
							<td>
								<a class="btn btn-sm mb-1 btn-dark" href="<?= route("alumnuses/edit.php?id=" . $alumnus['id'] )?>">Edit</a>
								<a class="btn btn-sm mb-1 btn-danger" href="<?= route("alumnuses/delete.php?id=" . $alumnus['id'] )?>">Delete</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

<?php include "../includes/footer.php"; ?>