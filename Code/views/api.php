<?php
require_once "../init/db.php";

if (isset($_GET)) {
	if ( $_GET['type'] == "get_departments_by_college" ) {
		$stmt = $con->prepare("SELECT * FROM departments WHERE college_id = ?");
		$stmt->execute( [ $_GET['college_id'] ] );
		$departments = $stmt->fetchAll();

		if ($stmt->rowCount() == 0) {
			?>
			<option value="0">...</option>
			<?php
		} else {
			foreach ( $departments as $department ) {
				?>
				<option value="<?= $department['id'] ?>"><?= $department['dept_name'] ?></option>
				<?php
			}
		}
	}
}