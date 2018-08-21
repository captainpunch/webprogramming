<?php # Script 10.2 - delete_user.php
// This page is for deleting a user record.
// This page is accessed through view_users.php.
session_start();
require ('includes/config.inc.php'); 
$page_title = 'Delete a User';
include ('includes/header.html');

// check user level
if ($_SESSION['user_level'] != 1) {
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}
//echo '<div class="container">';
// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.

		// acces error 
	echo '<p class="alert-error"> page was accesses improperly.</p> <p class="alert-error"> You will be redirected in <b>10 seconds</b> or  ';
	echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
	
		// auto redirect in 10 seconds
	header( 'refresh:10;url=view_users.php');
    //echo'<a href="#" class="btn btn-primary btn-lg active" role="button">Back</a>';
	//echo '<button class="btn" href="view_users.php">follow this link to go back</button>';
	include ('includes/footer.html'); 
	exit();
}

require_once (MYSQL);

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM users2 WHERE user_id=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p class=" alert alert-sucess">The user has been deleted.</p>';
			echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
			//auto redirect 
			header( "refresh:10;url=view_users.php" ); 
			
			// button to redirect to users 
				
			
		} else { // If the query did not run OK.
			echo '<p class="alert">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p>The user has NOT been deleted.</p>';	
		echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
	}

} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT CONCAT(last_name, ', ', first_name) FROM users2 WHERE user_id=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_BOTH);
		
		// Display the record being deleted:
		echo '<h3>Name: ' . $row[0] . '</h3>';
		
		// Create the form:
		echo ' ';
		?>


	
	<form class="form-horizontal" action="delete_user.php" method="post">
	<fieldset>
	<!-- Form Name -->
	<legend>Delete User</legend>
Are you sure you want to delete this user?
		<div class="form-group">
		<div class="col-md-1">
		  
		  <label class="radio-inline" for="sure">
			<input  name="sure" type="radio" value="Yes">
			Yes
		</label> 
		<label class="radio-inline" for="sure">
			<input name="sure" type="radio" value="No" checked="checked">		
			No
		  </label>
		  </div>
		</div>
	
		<!-- Button -->
		<div class="form-group">
		  <div class="col-md-4 control-label" ></div>
		  <div class="col-md-4">
			<input id="singlebutton" type="submit" name="submit" value="Delete User" class="btn btn-primary">
		  </div>
		</div>
		<?PHP echo '<input type="hidden" name="id" value="' . $id . '" />';?>
	</fieldset>
</form>
	<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>
	<?PHP
		
	} else { // Not a valid user ID.
		echo '<p class="alert-error">This page has been accessed in error.</p>';
		echo '<a class="btn btn-primary" href= "view_users.php" >follow this to go back</a>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
//echo '</div>';
include ('includes/footer.html');
?>