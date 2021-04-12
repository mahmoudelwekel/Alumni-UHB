<?php
$page = "departments";
require_once "../../init/init.php";

if( !isAdmin() ) {
	redirect("public");
}

$stmt = $con->prepare("SELECT departments.*, colleges.colg_name AS college FROM departments INNER JOIN colleges ON colleges.id = departments.college_id");
$stmt->execute();
$departments = $stmt->fetchAll();

?>

<div class="container py-5">
    <h3>Departments</h3>
    <hr />
    <a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>College</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach ($departments as $department): ?>
                <tr>
                    <td><?= $department['id'] ?></td>
                    <td><?= $department['dept_name'] ?></td>
                    <td><?= $department['college'] ?></td>
                    <td>
                        <a class="btn btn-sm mb-1 btn-dark" href="edit.php?id=<?= $department['id'] ?>">Edit</a>
                        <a class="btn btn-sm mb-1 btn-danger" href="delete.php?id=<?= $department['id'] ?>">Delete</a>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once "../includes/footer.php"; ?>