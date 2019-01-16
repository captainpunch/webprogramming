<?php	// Grant Schorgl Assignment 10 11/8/2016
require ('includes/config.inc.php'); 
if (!isset($page_title)) {
	$page_title = 'Welcome To Lake of the Ozarks!';
}
session_start();
include ('includes/header.html');

?>
<div class="container">
	<div class="container">
	<?php 
	if (isset($_SESSION['first_name'])) {
				echo '<h4 align="left">Welcome ';
				echo $_SESSION['first_name'];

				echo '!</h4>';
			} 
?>


	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
			
			
					<div id="carousel" class="carousel slide" data-ride="carousel">
						<!-- Menu -->
						<ol class="carousel-indicators">
							<li data-target="#carousel" data-slide-to="0" class="active"></li>
							<li data-target="#carousel" data-slide-to="1"></li>
							<li data-target="#carousel" data-slide-to="2"></li>
						</ol>
						
						<!-- Items -->
						<div class="carousel-inner">
							
							<div class="item active">
								<img src="includes/images/landing1.jpg" alt="Slide 1" />
							</div>
							<div class="item">
								<img src="includes/images/landing2.jpg" alt="Slide 2" />
							</div>
							<div class="item">
								<img src="includes/images/landing3.jpg" alt="Slide 3" />
							</div>
						</div> 
						<a href="#carousel" class="left carousel-control" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a href="#carousel" class="right carousel-control" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div>
					
					
				<div class="row">
					<div class="col-md-6">
						<div >
							<h1 id="mainhead">Visit the Ozarks</h1>
								<p>Conveniently located in the heart of Missouri, The Lake of the Ozarks is the Midwest's premier lake resort destination, offering world-class boating, golfing, shopping and fishing, and a wide variety of lodging, restaurants, state parks, and other recreational activities to suit any budget and taste. Lake of the Ozarks vacations are defined by the Lake and its many waterfront accommodations, restaurants, recreational and entertainment venues. </p>
				
				
				
				
							<h2 >Life at the Lake</h2>
								<p>It takes a thriving community of diverse businesses to support a popular vacation destination like the Lake of the Ozarks. Businesses in and around the Lake of the Ozarks area offer everything a visitor or resident could require for a vacation, a meeting or conference, a second home--even for a lifetime. At the Lake of the Ozarks, we're proud of the numerous businesses that have chosen to set up shop here. You'll find all the services you need right here at the Lake of the Ozarks.</p>
					
						</div>
					</div>
			
			
					<div class="col-md-6">
					<div> 
						<br> 
					</div>
						<div style="padding-top:50px;">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/YHyd8mWgCrU" frameborder="0" align="center" ></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
	<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail First" src="includes/images/golf.jpg" />
							<div class="caption">
								<h2>Golf</h2>	
								<p> The Ozarfks offers many golf courses to choose from put-put to majestic 18 hole golf courses overlooking the open water.</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail Second" src="includes/images/shopping.jpg" />
							<div class="caption">
								<h2> Shopping </h2>
								<p>Locations around the Lake offer premium outlet locations and fantastic resurants. </p>	
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
							<div class="thumbnail">
								<img alt="Bootstrap Thumbnail Third" src="includes/images/hiking.jpg" />
								<div class="caption">
									<h2> Biking / Hiking </h2>
									<p> take a mountain tail and let the ozark hills amaze you with breathtaking views.</p>	
								</div>
							</div>
					</div>
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail Third" src="includes/images/helicopter.jpg" />
							<div class="caption">
								<h2>Tours</h2>
								<p> Tours range from escaping onto the lake for a cruse threw the calm waters to taking a helicopter ride over the water for a birds eye view. </p>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div style="padding:50px;">
</div
<?php include ('includes/footer.html'); ?> 