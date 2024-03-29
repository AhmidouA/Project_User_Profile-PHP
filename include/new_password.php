<?php require 'header.html'; ?>
<title>Reset Password</title>
</head>

<body>

	<?php

	if ($_GET) {

		if (isset($_GET['email'])) {
			$email = $_GET['email'];
		}
		if (isset($_GET['token'])) {
			$token = $_GET['token'];
		}

		if (!empty($email) && !empty($token)) {

			require_once '../data/db.php';

			$requete = $bdd->prepare('SELECT * FROM reset_password WHERE email=:email AND token=:token');

			$requete->bindvalue(':email', $email);
			$requete->bindvalue(':token', $token);

			$requete->execute();

			$nombre = $requete->rowCount();

			if ($nombre != 1) {
				header('Location:login.php');
			} else {

				if (isset($_POST['new_password'])) {

					if (empty($_POST['password']) || $_POST['password'] != $_POST['confirmPassword']) {
						$message = "Password And Confirm Password not same";
					} else {
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

						$requete = $bdd->prepare('UPDATE users SET password=:password WHERE email=:email');

						$requete->bindvalue(':email', $email);
						$requete->bindvalue('password', $password);

						$result = $requete->execute();

						if ($result) {
							echo "<script type =\"text/javascript\">
						alert('Your password is successfully reset');
						document.location.href='login.php';
					</script>";
						} else {

							header('Location:login.php');
						}
					}
				}
			}
		}
	} else {
		header('Location:signup.php');
	}

	?>


	<div id="login">
		<h3 class="text-center text-white pt-5">Nouveau mot de passe</h3>
		<h6 class="text-center text-white pt-5">Merci d'entrer votre nouveau mot de passe </h6>

		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">
					<div id="login-box" class="col-md-12">


						<center>
							<div class="container" style="background-color:#FB6969;">
								<font color="#8B0505">
									<?php if (isset($message)) echo $message; ?>
								</font>
							</div>
						</center>

						<form id="login-form" class="form" action="" method="post">

							<div class="form-group">
								<label for="password" class="text-info">Votre nouveau mot de passe:</label><br>
								<input type="password" name="password" id="password" class="form-control" placeholder='Nouveau mot de passe'>
							</div>
							<div class="form-group">
								<label for="confirmPassword" class="text-info">Confirmation du mot de passe:</label><br>
								<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder='Confirmer votre mot de passe'>
							</div>

							<div class="form-group">

								<input type="submit" name="new_password" class="btn btn-info btn-md" value="Valider">

							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>