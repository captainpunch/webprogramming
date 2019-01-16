<?php # Script 18.6 - register.php
// This is the registration page for the site.
require ('includes/config.inc.php');
$page_title = 'Register';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	// Need the database connection:
	require ('includes/mysqli_connect.php');
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$fn = $ln = $e = $p = FALSE;
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = $trimmed['first_name'];
	} else {
		echo '<p class="alert alert-danger">Please enter your first name!</p>';
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = $trimmed['last_name'];
	} else {
		echo '<p class="alert alert-danger">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = $trimmed['email'];
	} else {
		echo '<p class="alert alert-danger">Please enter a valid email address!</p>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = $trimmed['password1'];
		} else {
			echo '<p class="alert alert-danger">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="alert alert-danger">Please enter a valid password!</p>
		<p>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</p>';
	}
	
	if ($fn && $ln && $e && $p) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users2 WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0) { // Available.

			// Create the activation code:
			$a = md5(uniqid(rand(), true));

			// Add the user to the database:
			$q = "INSERT INTO users2 (email, pass, first_name, last_name, active, registration_date) VALUES ('$e', SHA1('$p'), '$fn', '$ln', '$a', NOW() )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// post the acivation link with the sucess page 
				$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				
				echo '<p>here is your activation link fo tyour account';
				echo $body;
				echo '<p>';
				
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				echo '<p class="alert alert-danger">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		} else { // The email address is not available.
			echo '<p class="alert alert-danger">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	} else { // If one of the data tests failed.
		echo '<p class="alert alert-danger">Please try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>
<form class="form-horizontal" action="register.php" method="post">
	<fieldset>
	<!-- Form Name -->
	<legend>Register1</legend>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="first_name">First Name:</label>  
		  <div class="col-md-4">
		  <input  name="first_name" type="text" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="last_name">Last Name:</label>  
		  <div class="col-md-4">
		  <input  name="last_name" type="text" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="email"> E-mail:</label>  
		  <div class="col-md-4">
		  <input  name="email" type="text" size="15" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control input-md">
		  </div>
		</div>
		
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