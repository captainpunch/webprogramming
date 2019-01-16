<?php # Script 10.3 - edit_user.php
// This page is for editing a user record.
// This page is accessed through view_users.php.

$page_title = 'Edit a User';
session_start();
require ('includes/config.inc.php'); 
include ('includes/header.html');
echo '<h1>Edit a User</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="alert alert-warning">This page has been accessed in error.</p>';
	echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
	include ('includes/footer.html'); 
	exit();
}

require_once (MYSQL); 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	// check for admin 
	if (empty($_POST['admin']) && !is_numeric($_POST['admin'])) {
		$errors[] = 'You forgot to enter an admin choice.';
	} else {
		$a = trim($_POST['admin']);
	}
		
	
	
	if (empty($errors)) { // If everything's OK.
	
		//  Test for unique email address:
		$q = "SELECT user_id FROM users2 WHERE email='$e' AND user_id != $id";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
			
				$q = "UPDATE users2 SET first_name='$fn', last_name='$ln', email='$e', user_level='$a' WHERE user_id=$id LIMIT 1";
				$r = @mysqli_query ($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

					// Print a message:
					echo '<p class="alert alert-success">The user has been edited.</p>';	
				
				} else { // If it did not run OK.
				
					echo '<p class="alert">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
					echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
						}
			
						

		} else { // Already registered.
			echo '<p class="alert alert-danger">The email address has already been registered.</p>';
				}
		
	} else { // Report the errors.

		echo '<p class="alert alert-danger">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
	
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT first_name, last_name, email, user_level FROM users2 WHERE user_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:

?>

<form class="form-horizontal" action="edit_user.php" method="post">
	<fieldset>
	<!-- Form Name -->
	<legend>Edit User</legend>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="first_name">First Name:</label>  
		  <div class="col-md-4">
		  <input  name="first_name" type="text" size="15" maxlength="20" value="<?PHP echo $row[0]; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="last_name">Last Name:</label>  
		  <div class="col-md-4">
		  <input  name="last_name" type="text" size="15" maxlength="40" value="<?PHP echo $row[1]; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="email"> E-mail:</label>  
		  <div class="col-md-4">
		  <input  name="email" type="text" size="15" maxlength="60" value="<?PHP echo $row[2]; ?>" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" >
				Admin:	
			</label>
			<div class="col-md-4">
				<input type="radio" name="admin" value="1" <?PHP if ($row[3] == '1') echo 'checked="checked"';?>> Yes  
				<input type="radio" name="admin" value="0" <?PHP if ($row[3] == '0') echo 'checked="checked"';?>> No
			</div>
		</div>
		<!-- Button -->
		<div class="form-group">
		  <div class="col-md-4 control-label" ></div>
		  <div class="col-md-4">
			<input id="singlebutton" type="submit" name="submit" value="Submit Edits" class="btn btn-primary">
		  </div>
		</div>
		
		<input type="hidden" name="id" value="<?PHP echo $id; ?>" />
		
	</fieldset>
</form>
<?PHP
echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';

} else { // Not a valid user ID.
	echo '<p class="alert">This page has been accessed in error.</p>';
	echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
}

mysqli_close($dbc);
include ('includes/footer.html');
?>