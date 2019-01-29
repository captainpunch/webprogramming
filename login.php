<?php # Script 18.8 - login.php
// This is the login page for the site.

require ('includes/config.inc.php'); 
$page_title = 'Login';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	
	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = $_POST['email'];
	} else {
		$e = FALSE;
		echo '<p class="alert alert-danger">You forgot to enter your email address!</p>';
	}
	
	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = $_POST['pass'];
	} else {
		$p = FALSE;
		echo '<p class="alert alert-danger">You forgot to enter your password!</p>';
	}
	
	if ($e && $p) { // If everything's OK.
	require (MYSQL);
		// Query the database:
		$q = "SELECT `user_id`, `first_name`, `user_level` FROM `users2` WHERE `pass` = SHA1('$p') AND `email` = '$e'";		
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (@mysqli_num_rows($r) == 1) { // A match was made.

			// Register the values:
			session_start();
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC); 
			mysqli_free_result($r);
			mysqli_close($dbc);
			unset($dbc);
							if (isset($_SESSION['first_name'])) {
				echo 'Welcome ';
				echo $_SESSION['first_name'];
				echo '!';
			} 
			// Redirect the user:
			$url = index.php; // Define the URL.
			ob_end_clean(); // Delete the buffer.
			header("Location: 'index.php'");
			
			exit(); // Quit the script.
			include ('includes/footer.html');
				
		} else { // No match was made.
			echo '<p class="alert alert-danger">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
			mysqli_close($dbc);
		}
		
	} else { // If everything wasn't OK.
		echo '<p class="alert alert-danger">Please try again.</p>';
		mysqli_close($dbc);
	}
	


} // End of SUBMIT conditional.
?>

<form class="form-horizontal" action="login.php" method="post">
	<fieldset>
	<!-- Form Name -->
	<legend>Login</legend>
	
		<div class="form-group">
		  <label class="col-md-4 control-label" for="email"> E-mail:</label>  
		  <div class="col-md-4">
		  <input  name="email" type="text" size="15" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="pass">Password:</label>  
		  <div class="col-md-4">
		  <input  name="pass" type="password" size="15" maxlength="20"  class="form-control input-md">
		  </div>
		</div>
		<!-- Button -->
		<div class="form-group">
		  <div class="col-md-4 control-label" ></div>
		  <div class="col-md-4">
			<input id="singlebutton" type="submit" name="submit" value="Login" class="btn btn-primary">
		  </div>
		</div>
	</fieldset>
</form>


<?php include ('includes/footer.html'); ?>