<?php
require_once "../../init/init.php";

$stmt = $con->prepare("SELECT
	lecturers.*, colleges.colg_name, departments.dept_name
	FROM 
	    lecturers 
    INNER JOIN departments ON lecturers.department_id = departments.id 
    INNER JOIN colleges ON departments.college_id = colleges.id");
$stmt->execute();

$lecturers = $stmt->fetchAll();

for ( $i = 0; $i < sizeof( $lecturers ); $i++ ) {
	$id = $lecturers[$i]['id'];

	$stmt = $con->prepare("SELECT AVG(rate) as rate FROM alumnus_lecturer_rate WHERE lecturer_id = ?");
	$stmt->execute([$id]);

	$rate = $stmt->fetch();
	$lecturers[$i]['rate'] = $rate['rate'];
}

?>

<div class="container py-5">
    <h3>Lecturers</h3>
    <hr/>
    <a class="btn btn-block mb-3 btn-primary" href="<?= route("lecturers/add.php") ?>">Add New</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
					<th>SSN</th>
					<th>College</th>
                    <th>Department</th>
                    <th>CV</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>rate</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
				<?php foreach ($lecturers as $lecturer): ?>
					<tr>
						<td><?= $lecturer['id'] ?></td>
						<td><?= $lecturer['lec_name'] ?></td>
						<td><?= $lecturer['SSN'] ?></td>
						<td><?= $lecturer['colg_name'] ?></td>
						<td><?= $lecturer['dept_name'] ?></td>
						<td><a class="btn btn-success" download href="<?= uploads("cvs/" . $lecturer['cv']); ?>">Download</a></td>
						<td><?= $lecturer['email'] ?></td>
						<td><?= $lecturer['phone'] ?></td>
						<td><?= $lecturer['rate'] ?></td>
						<td>
						<!--<a class="btn btn-sm mb-1 btn-dark" href="--><?//= route("lecturers/show.php?id=" . $lecturer['id'] )?><!-- ">Details</a>-->
							<a class="btn btn-sm mb-1 btn-dark" href="<?= route("lecturers/edit.php?id=" . $lecturer['id'] )?>">Edit</a>
							<a class="btn btn-sm mb-1 btn-danger" href="<?= route("lecturers/delete.php?id=" . $lecturer['id'] )?>">Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once "../includes/footer.php";