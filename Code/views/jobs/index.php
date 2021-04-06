<?php
$page = "jobs";
require_once"../../init/init.php";
$stmt = $con->prepare("SELECT * FROM jobs");
$stmt->execute();
$jobs = $stmt->fetchAll();

for( $i = 0; $i < sizeof($jobs); $i++ ) {
	$id = $jobs[$i]['id'];
	$stmt = $con->prepare("SELECT workshop_job.*, workshops.* 
									FROM workshop_job
									INNER JOIN workshops
									ON workshop_job.workshop_id = workshops.id
									WHERE job_id = ?");
	$stmt->execute([$id]);
	$workshops = $stmt->fetchAll();

	$_workshops = "";
	for ( $j = 0; $j < sizeof($workshops); $j++ ) {
		$_workshops .= $workshops[$i]['wshop_name'];

		if ( sizeof($workshops) - $j > 2 ) {
			$_workshops .= ", ";
		} elseif ( sizeof($workshops) - $j == 2 ) {
			$_workshops .= " and ";
		}
	}

	$jobs[$i]['workshops'] = $_workshops;
}
?>

<div class="container py-5">
    <h3>Jobs</h3>
    <hr />
    <a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Link</th>
                    <th>Details</th>
                    <th>Workshops</th>
					<?php if( isAdmin() ): ?>
                    	<th></th>
					<?php endif; ?>

                </tr>
            </thead>
            <tbody>
				<?php foreach ($jobs as $job): ?>
					<tr>
						<td><?= $job['id'] ?></td>
						<td><?= $job['job_name'] ?></td>
						<td><?= $job['company'] ?></td>
						<td><?= $job['link'] ?></td>
						<td><?= $job['details'] ?></td>
						<td><?= $job['workshops'] ?></td>

						<?php if( isAdmin() ): ?>
							<td>
								<a class="btn btn-sm mb-1 btn-dark" href="edit.php?id=<?= $job['id'] ?>">Edit</a>
								<a class="btn btn-sm mb-1 btn-danger" href="delete.php?id=<?= $job['id'] ?>">Delete</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
        </table>
    </div>

</div>
<?php require_once"../includes/footer.php"; ?>