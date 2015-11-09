
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
  
	//lets do an ajex request here
	postButton.onclick = function(){
  var postData = postBox.value;
    $.ajax({
      url:"./library/store_posts.php",
      data:{postData:postData}
    });
  }
	
  $.ajax({
    url:"./library/fetch_post.php",
    complete: function (response) {
      console.log(response.responseText);
    }
  });

</script>

<div id = "chatbar">
	<?php include('./library/chat-bar.html'); ?>
</div>
</html>
