<?php
$page = "workshops";
require_once "../../init/init.php";

if (!isAdmin()) {
	redirect("workshops/show.php");
}

$stmt = $con->prepare("SELECT workshops.*, categories.catg_name AS category FROM workshops
								INNER JOIN categories
								ON categories.id = workshops.category_id");
$stmt->execute();
$workshops = $stmt->fetchAll();

for ( $i = 0; $i < sizeof($workshops); $i++ ) {
	$id = $workshops[$i]['id'];

	$stmt = $con->prepare("SELECT lecturer_workshop.*, lecturers.lec_name AS lecturer 
									FROM lecturer_workshop
									INNER JOIN lecturers
									ON lecturers.id = lecturer_workshop.lecturer_id
									WHERE workshop_id = ?");
	$stmt->execute([$id]);

	$lecturers = $stmt->fetchAll();
	$_lecturers = "";
	for ( $j = 0; $j < sizeof($lecturers); $j++ ) {
		$_lecturers .= $lecturers[$j]['lecturer'];

		if ( sizeof($lecturers) - $j > 2 ) {
			$_lecturers .= ", ";
		} elseif ( sizeof($lecturers) - $j == 2 ) {
			$_lecturers .= " and ";
		}
	}

	$workshops[$i]["lecturers"] = $_lecturers;
}

?>

<div class="container py-5">
    <h3>Workshop</h3>
    <hr />
    <a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">
        <table id="example" class="table table-striped  table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>DeadLine</th>
                    <th>Details</th>
                    <th>Lecturers</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach ($workshops as $workshop): ?>
                <tr>
                    <td><?= $workshop['id'] ?></td>
					<td><a style="color: inherit" href="<?= route( "workshops/workshop.php?id=" . $workshop['id'])?>"><?= $workshop['wshop_name'] ?></a></td>
                    <td><?= $workshop['location'] ?></td>
                    <td><?= $workshop['deadline'] ?></td>
                    <td><?= $workshop['details'] ?></td>
                    <td><?= $workshop['lecturers'] ?></td>
						<td>
							<a class="btn btn-sm mb-1 btn-dark" href="edit.php?id=<?= $workshop['id'] ?>">Edit</a>
							<a class="btn btn-sm mb-1 btn-danger" href="delete.php?id=<?= $workshop['id'] ?>">Delete</a>
						</td>
                </tr>
			<?php endforeach; ?>

            </tbody>

        </table>
    </div>

</div>
<?php require_once "../includes/footer.php"; ?>