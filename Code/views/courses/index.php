<?php
$page = "courses";
require_once"../../init/init.php";

if (!isAdmin()) {
	redirect("courses/show.php");
}

$stmt = $con->prepare("SELECT
								courses.*, categories.catg_name AS category, lecturers.lec_name AS lecturer
       						FROM 
       						     courses
       						INNER JOIN categories
       						ON categories.id = courses.category_id
       						INNER JOIN lecturers
       						ON lecturers.id = courses.lecturer_id");
$stmt->execute();

$courses = $stmt->fetchAll();
?>

<div class="container py-5">
    <h3>Courses</h3>
    <hr />
	<a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">
	<table id="example" class="table table-striped  table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Details</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Deadline</th>
                    <th>Category</th>
                    <th>Lecturer</th>
                    <th></th>
                </tr>
            </thead>
			<tbody>
			<?php foreach ( $courses as $course ): ?>
				<tr>
					<td><?= $course['id'] ?></td>
					<td>
						<a style="color: inherit" href="<?= route( "courses/course.php?id=" . $course['id'])?>"
						><?= $course['crs_name'] ?>
						</a></td>
					<td><?= $course['location'] ?></td>
					<td><?= $course['details'] ?></td>
					<td><?= $course['start_date'] ?></td>
					<td><?= $course['end_date'] ?></td>
					<td><?= $course['deadline'] ?></td>
					<td><?= $course['category'] ?></td>
					<td><?= $course['lecturer'] ?></td>
					<td>
						<!--<a class="btn btn-sm mb-1 btn-dark" href="show.php">Details</a>-->
						<a class="btn btn-sm mb-1 btn-dark" href="<?= route("courses/edit.php?id=" . $course['id']) ?>">Edit</a>
						<a class="btn btn-sm mb-1 btn-danger" href="<?= route("courses/delete.php?id=" . $course['id']) ?>">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once"../includes/footer.php"; ?>