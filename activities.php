
<?php	// Grant Schorgl Assignment 10 11/8/2016
require ('includes/config.inc.php'); 

	$page_title = 'Recreation';

session_start();
include ('includes/header.html');
?>
<div class="container-fluid">
	<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail First" src="includes/images/golf.jpg" />
							<div class="caption">
								<h2>Golf</h2>	
								<p> The Ozarks offers many golf courses to choose from putt-putt to majestic 18 hole courses overlooking the open water.</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail Second" src="includes/images/shopping.jpg" />
							<div class="caption">
								<h2> Shopping </h2>
								<p>Locations around the Lake offer premium outlet locations and fantastic restaurants. </p>	
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
									<p> take a mountain trail and let the ozark hills amaze you with breathtaking views.</p>	
								</div>
							</div>
					</div>
					<div class="col-md-6">
						<div class="thumbnail">
							<img alt="Bootstrap Thumbnail Third" src="includes/images/helicopter.jpg" />
							<div class="caption">
								<h2>Tours</h2>
								<p> Tours range from escaping onto the lake for a cruise through the calm waters to taking a helicopter ride over the water for a birds eye view. </p>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?PHP include ('includes/footer.html');?> 