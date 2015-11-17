
<?php session_start() ?>
<!doctype html>
<body>
	<title>PetPage</title>
	<style>
		
	</style>
	<?php include('./library/nav-bar.html'); ?>

	<div class="container center-text">
		<div class="row">
      
      <!-- left sidebar  -->
			<div class="col-md-3">
				<div class="media">
					<div class="media-left" id = "picContainer">
						<!-- <img class="media-object" src="/resources/images/bunny_trans.gif" alt="..." id = "petPic"> -->
					</div>

				</div>

				<div class="media-body">
					<h4 class="media-heading" id = "petName">Pet Name</h4>
				</div>
			</div>
      
      <!-- main body  -->
			<div class="col-md-9">
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
<script src="library/render.js"></script>
<script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>
<script>
	var postButton = document.getElementById("postButton");
	var postBox = document.getElementById("postBox");
    disp_posts();
    


	jQuery.extend({
		getValues: function(url, method, data, type)
		{
	    	var result = null;
			$.ajax({
	        	url: url,
	            type: method,
				data: data,
				dataType: type,
	            //contentType: 'application/json',
				async: false,
				success: function(data) {
					result = jQuery.parseJSON(data);
				},
	                        error: function(xhr){
	                            result = jQuery.parseJSON(xhr.responseText);
	                        }
			});
			return result;
		}
	});

	function display_pet()
	{
		//this is fucking horrible
		//throw this in a js file please
		var petImage = document.getElementById("petPic");
		var picContainer = document.getElementById("picContainer");			
		var petName = document.getElementById("petName");

		var petList = $.getValues("account/get-pet.php", "GET", "user_id=<?php echo $_SESSION['curr_id']; ?>", "application/x-www-form-urlencoded");
		var img = petList.pet_list[0].base;
		petName.innerText = petList.pet_list[0].name;

		container = new PIXI.Container(0x66FF99);
		var canvas = document.createElement('CANVAS');
		canvas.height = 230;
		canvas.width = 230;
	
		addImg(img,container,canvas);
	

		picContainer.appendChild(canvas);
		renderer = new PIXI.autoDetectRenderer(canvas.width, canvas.height, {view: canvas});
		renderer.render(container);
		requestAnimationFrame( function(timestamp)
		{
			animate(timestamp);
		});


		for(var i = 0; i < petList.pet_list.length; i++)
		{
			
		}
	}

	function animate(timestamp)
	{
		renderer.render(container);
		requestAnimationFrame( function(timestamp)
		{
			animate(timestamp);
		});	
	}

	

	display_pet();
	
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
