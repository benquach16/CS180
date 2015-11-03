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
        <p>you logged in, yeah! <?php echo $_SESSION['curr_user']; ?></p>
		</div>

		
    </body>
	<div id="chatbar">
      <?php include('./library/chat-bar.html'); ?>
	</div>
</html>
