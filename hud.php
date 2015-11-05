<?php session_start(); ?>
<!doctype html>
<html>
    <head>
        <title>INSIDE</title>
    </head>
    <body>

      <?php include('./library/nav-bar.html'); ?>

        <script>
            
        </script>
		<div class = "container center-text">


			<div class = "panel panel-default">
				<div class="panel-heading">
					<h3 class = "panel-title">Homepage</h3>
				</div>

				<div class ="panel-body">
					<ul class="list-group" id="listOfPosts">
						<li class="list-group-item">

	<button type="button" class="btn btn-default btn-lg">
	  <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star
	</button>
						</li>
					</ul>
				</div>
			</div>		
		</div>

		
    </body>
	<div id="chatbar">
      <?php include('./library/chat-bar.html'); ?>
	</div>
</html>
