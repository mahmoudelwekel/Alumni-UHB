<?php require_once "../../init/init.php";

if ( !isVisitor() ) {
	redirect("public");
}
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		list($type, $id) = logIn( $email, $password );

		if ( $type == "not valid" ) {
			$_SESSION['msg'][] = "Wrong Name or Password";
		} else {
			$_SESSION['type'] = $type;
			$_SESSION['id'] = $id;
			redirect("public");
		}
	}

	?>

	<div class="" style="background-image:url('<?= asset("Images/bg/empty.jpg") ?>') ;
			background-repeat: no-repeat;
			background-size: contain;
			background-position: right;
			background-color: #e5f1ed;">
		<div class="container h1 py-5">Login</div>
	</div>

	<div class="container font-weight-bold py-5">
		<?php getErrors(); ?>
		<div class="row">
			<div class="col-md">
			</div>
			<div class="col-md">
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" id="email" name="email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<p class="text-center">
						<button type="submit" class="btn btn-primary btn-lg ">Login</button>
					</p>
				</form>
			</div>
			<div class="col-md">
			</div>

		</div>
	</div>

<?php require_once "../includes/footer.php"; ?>