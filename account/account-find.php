<?php session_start(); ?>

<!doctype html>
<html>
	<head>
		<title>Find User</title>
	</head>
	<body>
		<?php include ('../library/nav-bar.html');?>
		<div class="row">
		<div class="col-lg-6">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="searchButton">Go!</button>
				</span>
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
		</div><!-- /.row -->

		<!--table goes here-->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Found Users</h3>
			</div>

	
			<div class="panel-body">
				<ul class="list-group" id ="listOfUsers">
	
				</ul>
			</div>
		</div>
	
	<script type="text/javascript">
		var searchButton = document.getElementById("searchButton");
		searchButton.onclick = function()
		{
			//create a table
			//do an ajax query then populate the table
			$.ajax({
				url:'../library/searchUsers.php',
				complete: function (response)
				{
					console.log(response);
					//delete table elements then populate them with new elements
					
				}
			});
		}
	</script>
	</body>
	<div id="chatbar">
		<?php include ('../library/chat-bar.html');?>
	</div>
</html>
