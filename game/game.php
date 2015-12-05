<?php session_start();
?>
<!doctype html>
<head> 
    <title>Pet Battles</title>
	<script type="text/javascript" src="js/phaser.min.js"></script>
	<script> var curPlayerID = <?php echo $_SESSION['curr_id']; ?>; console.log(curPlayerID); </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/0.3.14/peer.js"></script>
	<script type="text/javascript" src="./Utils.js"></script>
	<script type="text/javascript" src="./Grid.js"></script>
	<script type="text/javascript" src="./Projectile.js"></script>
	<script type="text/javascript" src="./Grenade.js"></script>
	<script type="text/javascript" src="./Player.js"></script>
	<script type="text/javascript" src="./Bar.js"></script>
	<script type="text/javascript" src="./Weapon.js"></script>
    <style type="text/css">
        body {
			margin: auto;
        }
    </style>
</head>
<body>
    <?php include('../library/nav-bar.html'); ?>
	<script type="text/javascript" src="./GameManager.js"></script>
</body>
</html>