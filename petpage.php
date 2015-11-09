
<?php session_start() ?>
<link rel="stylesheet" type="text/css" href='sidebar.css'>	
<!doctype html>
<body>

	<style>
		
	</style>
	<?php include('./library/nav-bar.html'); ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<div class="media">
					<div class="media-left">
						<a href="#">
							<img class="media-object" src="/resources/images/bunny_trans.gif" alt="...">
						</a>
					</div>

				</div>

									<div class="media-body">
						<h4 class="media-heading">Pet Name</h4>
					</div>
			</div>
			<div class="col-sm-10">
				<div class="row">

					<div class="col-md-8">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="What are you thinking?" id="postBox">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="postButton">Post</button>
							</span>
						</div><!-- /input-group -->

						
						<div class = "panel panel-default">
							<div class="panel-heading">
								<h3 class = "panel-title">Your posts</h3>
							</div>
							<div class ="panel-body">
								<ul class="list-group" id="listOfPosts">

									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title">Panel title</h3>
										</div>
										<div class="panel-body">
											Panel content
										</div>
									</div>
								</ul>
							</div>
						</div>

					</div>

					
				</div>
			</div>
		</div>
	</div>
	
	
</body>
<script>
	var postButton = document.getElementById("postButton");

	
</script>
<div id = "chatbar">
	<?php include('./library/chat-bar.html'); ?>
</div>
</html>
