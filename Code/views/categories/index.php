<?php
$page = "categories";
require_once "../../init/init.php";

if ( !isAdmin() ) {
	redirect("public");
}

$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();

?>

	<div class="container py-5">
		<h3>Categories</h3>
		<hr/>
		<a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered w-100">
				<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $categories as $category ): ?>
					<tr>
						<td><?= $category['id'] ?></td>
						<td><?= $category['catg_name'] ?></td>
						<td>
							<a class="btn btn-sm mb-1 btn-dark" href="edit.php?id=<?= $category['id'] ?>">Edit</a>
							<a class="btn btn-sm mb-1 btn-danger"
							   href="delete.php?id=<?= $category['id'] ?>">Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

	</div>
<?php require_once "../includes/footer.php"; ?>