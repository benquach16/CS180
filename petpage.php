<!doctype html>
<html style="height: 100%;">  
    <body>
            <?php include('./library/nav-bar.html'); ?>
    <?php
        //pull information from database
        include './library/opendb.php';
        
    ?>
    </body>     


    <?php   // Connect to user db...apparently not needed and I wasted my time QQ
     $db = mysql_connect("localhost","root","dankmemes"); 
     if (!$db) {
        die("Database connection failed miserably: " . mysql_error());
     }
     else {
       // echo "We in the Database Database", "<br/>\n";
     }
     
    $db_select = mysql_select_db("test",$db);
     if (!$db_select) {
        die("Database selection also failed miserably: " . mysql_error());
     }
     else {
       // echo "Database Database", "<br/>\n";
     }
     
     $result = mysql_query("SELECT * FROM auth_list", $db);
     if (!$result) {
     die("Database query failed: " . mysql_error());
     }
     else {
       // echo "Database Database", "<br/>\n"; 
        
     } 
    ?>

    <!-- For reasons unknown to me, the php call was bitching
         when put below the CSS area, so it's thrown up here 
         and it mostly still works.                 #Swag -->
    <div id="Welcome">
            <!-- add html//js for account features-->
            <!-- ability to display character (pet) avatar-->
            <!-- perhaps display character inventory? how do we design this?-->
            <!-- maybe we can store an inventory as a JSON object in mysql-->
            <H1>Welcome back, <?php include('/library/getUser.php'); getUser(); ?>!</H1>
    </div>

    <!-- CSS styles for div sections -->
    <style>
    #Youtube {
        position:relative;
        line-height:1px;
        background-color:black;
        height:281px;
        width:493px;
        top: 5%;
        right: 5%;
        float:none;
        border-style:ridge;
        border-color:red;
        border-width:6px;
        padding:0px;    
    }
    #Welcome {
        top:0px;
        background-color:black;
        color:white;
        text-align:center;
        padding:5px;
    }
    #Sidebar {
        line-height:50px;
        position:absolute;        
        background-color: hsla(352, 47%, 44%, .4);
        float:left;
        width:10%;
        height:100%;
        padding:20px;
    }
    #FakeButton {
        position:relative;
        border:2px solid black;
        width:120px;
        height:45px;
        border-radius:7%;
        background-color:hsla(10, 100%, 0%, .3);
        color:white;
        padding: 0px 25px 25px 25px;
        
    }
    
    #MetaButton {
        position:relative;
        border:2px solid black;
        width:120px;
        height:45px;
        border-radius:7%;
        background-color:hsla(10, 100%, 0%, .3);
        color:white;
        padding: 15px 25px 25px 25px;
        
    }
    #Wall {
        position:relative;
        background-color: hsla(0, 0%, 50%, .5);
        float:right;
        border:2px solid black;
        width:90%;
        height:100%;        
        padding:10px;
    }    
    </style>

    <head> <!-- Title of page -->
        <title>Pet Page</title>
    </head>

    <body style="height: 100%;"> 
        <div id="Wall"> <!-- Facebooky part of page WIP-->
            <div id="Youtube" style="float:right; position:relavtive;">    
                    <body> <!-- Emmbedded youtube video...for style later -->
                        <iframe width="480" height="270" src="http://www.youtube.com/embed/eW6sEkTGbUc" 
                         style="position:relative;"
                         >
                        </iframe>    
                    </body>   
            </div> 
        </div>
        
            <div id="Sidebar"> <!-- Didn't realize there was buttons, so here's some fake ones WIP-->
            
                <div id="FakeButton">
                    Friends
                </div>
                <br>
                <div id="FakeButton">
                    Pets
                </div>
                <br>
                <div id="FakeButton">
                    Costumes
                </div>
                <br>
                <div id="FakeButton">
                    Pictures
                </div>
                <br>
                
                <button id="MetaButton" style="background-color:lightred;" type="button" class="btn";
                onClick="location.href='http://localhost/petpage/nothing_here.php'">Friends</button>
                <button id="MetaButton" style="background-color:lightred;"  type="button" class="btn";
                onClick="location.href='https://google.com'">Pets</button>
                <button id="MetaButton" style="background-color:lightred;" type="button" class="btn";
                onClick="location.href='https://facebook.com'">Costumes</button>
                <button id="MetaButton" style="background-color:lightred;" type="button" class="btn";
                onClick="location.href='https://en.wikipedia.org/wiki/G-Dragon'">Pictures</button>
                
            </div>     
    </body>
    
</html>



<?php   // Close DB connection
 mysql_close($db);
?>