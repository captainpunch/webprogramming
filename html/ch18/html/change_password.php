<?php # Script 18.11 - change_password.php
// This page allows a logged-in user to change their password.
session_start();
require ('includes/config.inc.php'); 
$page_title = 'Change Your Password';
include ('includes/header.html');

// If no first_name session variable exists, redirect the user:


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('includes/mysqli_connect.php');
			
	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (preg_match ('/^(\w){4,20}$/', $_POST['password1']) ) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	if ($p) { // If everything's OK.

		// Make the query:
		$q = "UPDATE users2 SET pass=SHA1('$p') WHERE user_id={$_SESSION['user_id']} LIMIT 1";	
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email, if desired.
			echo '<h3>Your password has been changed.</h3>';
			mysqli_close($dbc); // Close the database connection.
			include ('includes/footer.html'); // Include the HTML footer.
			exit();
			
		} else { // If it did not run OK.
		
			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>'; 

		}

	} else { // Failed the validation test.
		echo '<p class="error">Please try again.</p>';		
	}
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<form class="form-horizontal" action="change_password.php" method="post">
	<fieldset>
	<!-- Form Name -->
	<legend>Change Password</legend>
	
		<div class="form-group">
		  <label class="col-md-4 control-label" for="password1">Password:</label>  
		  <div class="col-md-4">
		  <input  name="password1" type="password" size="15" maxlength="20"  class="form-control input-md">
		  <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="password2">Confirm Password:</label>  
		  <div class="col-md-4">
		  <input  name="password2" type="password" size="15" maxlength="20"  class="form-control input-md">
		  </div>
		</div>

		<!-- Button -->
		<div class="form-group">
		  <div class="col-md-4 control-label" ></div>
		  <div class="col-md-4">
			<input id="singlebutton" type="submit" name="submit" value="Register" class="btn btn-primary">
		  </div>
		</div>

	</fieldset>
</form>


<?php include ('includes/footer.html'); ?>