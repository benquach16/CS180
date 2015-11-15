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

		<div class="jumbotron">
			<h1>Latest News!</h1>
			<p>Check out our latest patch notes and features!</p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
		</div>
		<div class = "panel panel-default">
			<div class="panel-heading">
				<h3 class = "panel-title">Homepage</h3>
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
		
		
    </body>
	<script>
	$(document).ready(function(){
		$.ajax({
			url:'library/getFriendsPosts.php',
			complete: function (response)
			{
				console.log(response.responseText);
				var arr = JSON.parse(response.responseText);
				var listOfPosts = document.getElementById("listOfPosts");
				while(listOfPosts.firstChild)
				{
					listOfPosts.removeChild(listOfPosts.firstChild);
				}
				for(var i = 0; i < arr.length; i++)
				{
					//this looks shitty
					var newPost = document.createElement('div');
					newPost.className = "panel panel-primary";
					var heading = document.createElement('div');
					heading.className = "panel-heading";
					var textHeader = document.createTextNode("By " + arr[i][1]);
					heading.appendChild(textHeader);

					var body = document.createElement('div');
					body.className = "panel-body";
					var textBody = document.createTextNode(arr[i][2]);
					body.appendChild(textBody);
			
					newPost.appendChild(heading);
					newPost.appendChild(body);
					listOfPosts.appendChild(newPost);
				}
			}
		});
	});
	</script>
	<div id="chatbar">
      <?php include('./library/chat-bar.html'); ?>
	</div>
</html>
