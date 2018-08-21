<?php # Script 18.10 - forgot_password.php
// This page allows a user to reset their password, if forgotten.
session_start();
require ('includes/config.inc.php'); 
$page_title = 'Forgot Your Password';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require (MYSQL);

	// Assume nothing:
	$uid = FALSE;

	// Validate the email address...
	if (!empty($_POST['email'])) {

		// Check for the existence of that email address...
		$q = 'SELECT user_id FROM users2 WHERE email="'.  mysqli_real_escape_string ($dbc, $_POST['email']) . '"';
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM); 
		} else { // No database match made.
			echo '<p class="alert alert-danger">The submitted email address does not match those on file!</p>';
		}
		
	} else { // No email!
		echo '<p class="alert alert-danger">You forgot to enter your email address!</p>';
	} // End of empty($_POST['email']) IF.
	
	if ($uid) { // If everything's OK.

		// Create a new, random password:
		$p = substr ( md5(uniqid(rand(), true)), 3, 10);

		// Update the database:
		$q = "UPDATE users2 SET pass=SHA1('$p') WHERE user_id=$uid LIMIT 1";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Send an email:
			
			
			
			echo '<p class="alert alert-success">Your password to log into The Ozarks has been temporarily changed to <strong>' . $p . '</strong>. Please log in using this password and this email address. Then you may change your password to something more familiar.';
			echo '<a class="btn btn-primary" href="login.php">Login</a>';
			echo '<p>';
			
			// Print a message and wrap up:
			
			mysqli_close($dbc);
			include ('includes/footer.html');
			exit(); // Stop the script.
			
		} else { // If it did not run OK.
			echo '<p class="alert alert-danger">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
		}

	} else { // Failed the validation test.
		echo '<p class="alert alert-danger">Please try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>
 
<form class="form-horizontal" action="forgot_password.php" method="post">
	<fieldset>
		<legend>Reset Your Password</legend>
			<div class="form-group">
				  <label class="col-md-4 control-label" for="email"> E-mail:</label>  
				  <div class="col-md-4">
				  <input  name="email" type="text" size="15" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control input-md">
				  </div>
				</div>
				<div class="form-group">
					  <div class="col-md-4 control-label" ></div>
					  <div class="col-md-4">
						<input id="singlebutton" type="submit" name="submit" value="Reset Password" class="btn btn-primary">
					  </div>
					</div>
		</fieldset>
</form>

<?php include ('includes/footer.html'); ?>