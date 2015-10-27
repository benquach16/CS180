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
					console.log(response.responseText);
					//var arr = response.responseText; //implicit conversion to STRING
					//convert STRING into array
					var arr = JSON.parse(response.responseText);
					//delete table elements then populate them with new elements
					var list = document.getElementById("listOfUsers");
					//clear list
					while(list.firstChild)
						list.removeChild(list.firstChild);
					for(var i = 0; i < arr.length; i ++)
					{
						var username = arr[i][1];
						var li = document.createElement("li");
						li.className = "list-group-item";
						var text = document.createTextNode(username);
						li.appendChild(text);

						var button = document.createElement("button");
						button.className = "btn btn-default";
						var buttonText = document.createTextNode("Add Friend");
						button.appendChild(buttonText);

						var userID = arr[i][0];
						button.id = userID;
						button.usern = username;
						button.onclick = function()
						{
							//this.id = userID;
							//the jank is real
							var tmp = this.id;
							var usrn = this.usern;
							var currID = <?php echo $_SESSION['curr_id'] ?>;
							if(currID != tmp)
							{
								swal(
								{
									title: "Add friend",
									text: "Do you want to ask " + this.usern + " to be your friend?",
	    	    	                showCancelButton: true,
		        	                confirmButtonText: "Confirm",
		            	            closeOnConfirm: false
		     	        	    },
					            function()
			                    {
					                $.ajax(
									{
				     	            	url:'../library/sendFriendNotification.php',
				    	                data:{tmp:tmp, usrn:usrn},
				        	            complete: function (response) {
				                        console.log(response.responseText);
			    	 	    	        }
		            	            });
		                	        swal("Request Sent!", usrn + " has been sent a friend request!", "success");
		                    	});
							}
							else
							{
								swal("Cannot add yourself as a friend");
							}
	
						}
						li.appendChild(button);
						list.appendChild(li);
						
					}
				}
			});
		}
	</script>
	</body>
	<div id="chatbar">
		<?php include ('../library/chat-bar.html');?>
	</div>
</html>
