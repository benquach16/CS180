
<?php session_start() ?>
<!doctype html>
<body>

	<style>
		
	</style>
	<?php include('./library/nav-bar.html'); ?>

	<div class="container center-text">
		<div class="row">
      
      <!-- left sidebar  -->
			<div class="col-md-2">
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
      
      <!-- main body  -->
			<div class="col-md-10">
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
	var postBox = document.getElementById("postBox");
    disp_posts();
    
	//lets do an ajex request here
	postButton.onclick = function(){
    var postData = postBox.value;
      // Stores user post in database
      $.ajax({
        url:"./library/store_posts.php",
        data:{postData:postData},
		complete: function(response)
		{
			console.log(response.responseText);
		}
      });
          disp_posts();
    }
    
    function disp_posts() {    
         // Returns JSON object with all user posts
         $.ajax({
            url:"./library/fetch_post.php",
            complete: function (response) {
                console.log(response.responseText);          
                
                // Reset list after each refresh
                while ( listOfPosts.firstChild) {
                    listOfPosts.removeChild(listOfPosts.firstChild);
                }
                
                // create divs here
                var postList = JSON.parse(response.responseText);
                for ( var i = postList.length - 1; i >= 0; i--)  {
                    // Sets div elements
                    var newPost = document.createElement('div');
                    newPost.className = "panel panel-primary";
                    var heading = document.createElement('div');
                    heading.className = "panel-heading";
                    var textHeader = document.createTextNode("By " + postList[i][0]);
                    heading.appendChild(textHeader);
                    var body = document.createElement('div');
                    body.className = "panel-body";
                    var textBody = document.createTextNode(postList[i][1]);
                    body.appendChild(textBody);
                    
                    // Attaches elements to div, and then div array
                    newPost.appendChild(heading);
                    newPost.appendChild(body);
                    listOfPosts.appendChild(newPost);
                }
            }
        });
    } 

</script>

<div id = "chatbar">
	<?php include('./library/chat-bar.html'); ?>
</div>
</html>
