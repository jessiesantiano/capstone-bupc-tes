<style>
	body {
		/* background-color: blanchedalmond; */
		background-image: linear-gradient(#056a9f, #fc8f02);
		background-position: cover;
		background-attachment: fixed;
		background-repeat: no-repeat;
	}
</style>
<style>
	body {
		/* background-color: blanchedalmond; */
		background-image: url(assets/img/header-bg.jpg);
		background-position: cover;
		background-attachment: fixed;
		background-repeat: no-repeat;
	}
</style>
<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['user_name'])) {
	header("Location: index.php");
}

if (isset($_POST['submit'])) {
	$user_name = $_POST['user_name'];
	$user_username = $_POST['user_username'];
	$user_pass = $_POST['user_pass'];
	$cuser_pass = $_POST['cuser_pass'];

	// to hide the password!
	// $cuser_pass = md5($_POST['cuser_pass']);

	if ($user_pass == $cuser_pass) {
		$sql = "SELECT * FROM users WHERE user_username='$user_username'";
		$result = mysqli_query($conn, $sql);

		if (preg_match('|@bicol-u.edu.ph$|', $user_username)) {



			if (!$result->num_rows > 0) {
				$sql = "INSERT INTO users (user_name, user_username, user_pass)
					VALUES ('$user_name', '$user_username', '$user_pass')";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					echo '<script>
    setTimeout(function() {
        swal({
            title: "Nice!",
            text: "Registration Completed",
            type: "success"
        }, function() {
            window.location = "index.php";
        });
    }, 1000);
</script>';
					$user_name = "";
					$user_username = "";
					$_POST['user_pass'] = "";
					$_POST['cuser_pass'] = "";
				} else {
					echo "<script>alert('Woops! Something Wrong Went.')</script>";
					$_SESSION['status'] = "Woo hoo!";
					$_SESSION['text'] = "Woops! Something Wrong Went. Please contact the dev.";
					$_SESSION['icon'] = "error";
				}
			} else {
				// echo "<script>alert('Woops! Email Already Exists.')</script>";
				$_SESSION['status'] = "Woo hoo!";
				$_SESSION['text'] = "Email Already Exists!";
				$_SESSION['icon'] = "error";
			}
		} else {
			// echo "<script>alert('Please enter valid BU email.')</script>";
			$_SESSION['status'] = "Woo hoo!";
			$_SESSION['text'] = "Please enter valid BU email.";
			$_SESSION['icon'] = "error";
		}
	} else {
		// echo "<script>alert('Password Not Matched.')</script>";
		$_SESSION['status'] = "Woo hoo!";
		$_SESSION['text'] = "Password do not match!";
		$_SESSION['icon'] = "error";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Alert JS -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<script src="sweetalert2.min.js"></script>
	<link rel="stylesheet" href="sweetalert2.min.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

	<title>Signup</title>
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
</head>

<body>
	<div class="container">
	<?php include("theme/alertSession.php"); ?>
		<form action="" method="POST" class="login-email">
			<h1 style="font-size: 2.25rem;
					padding:10px;
					margin-bottom:5px;
					text-align:center;
					font-family: Arial;
					font-weight:500;
					">Signup</h1>
			<div class="input-group">
				<input autocomplete="off" type="text" placeholder="Fullname" name="user_name" value="<?php echo $user_name; ?>" required>
			</div>
			<div class="input-group">
				<input autocomplete="off" type="email" placeholder="BU Email" name="user_username" value="<?php echo $user_username; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="user_pass" value="<?php echo $_POST['user_pass']; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cuser_pass" value="<?php echo $_POST['cuser_pass']; ?>" required>
			</div>
			<input type="text" name="status" value="0" hidden>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p style="font-family: Arial;">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>

</html>