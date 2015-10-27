<!doctype html>

<html style="height: 100%;">
  
    <?php include('./library/nav-bar.html'); ?>
    <div id="Welcome">
            <!--     <H1>Welcome back, <?php include('/library/getUser.php'); getUser(); ?>!</H1> -->
    </div>

 <!-- CSS styles for div sections -->
     <style>
        #Youtube {
            position:relative;
            line-height:1px;
            background-color:black;
            height:270px;
            width:36%;
            top: 0%;
            right: 0%;
            float:none;
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
        
        #MetaButton {
            position:relative;
            width:120px;
            height:45px;
            background-color:hsla(10, 100%, 0%, .3);
            color:white;
            padding: 15px 25px 25px 25px;
            
        }
        #Wall {
            position:relative;
            background-color: hsla(0, 0%, 50%, .5);
            float:right;
            width:85%;
            height:100%;        
            padding:0px;
        }
        #Posts{
            height:224px
        }
        .form-inline{
            float:left;
            padding-top:2%;
            padding-bottom:2%;
            width:64%;
            background-image: url("http://cdn.myanimelist.net/images/anime/8/76479.jpg");
        }
    </style>
    
    <head> <!-- Title of page -->
        <title>Pet Page</title>
    </head>

    <body style="height: 100%;">
        <div id="Wall" > <!-- Facebooky part of page WIP-->
            <div id="Youtube" style="float:right; position:relavtive;">    
                    <body> <!-- Emmbedded youtube video...for style later -->
                        <iframe width=100% height=100% src="http://www.youtube.com/embed/eW6sEkTGbUc" 
                         style="position:relative;"
                         >
                        </iframe>    
                    </body>   
            </div>
            
            <!-- Wall posts -->
            <form action='./library/store_post.php' class="form-inline" role="Post"  >
                <div id="Posts" class="form-group_2">
                    <div class="col-sm-7">
                        <input name='new_post' type="text" class='form-control input-md'  placeholder="How are you feeling?">
                    </div>
                    <button type="button" class="btn btn-default col-md-2">Post!</button>
                </div>                
            </form>

          <!-- <div id="Post_List" >          
            <?php
            
              include_once (__DIR__."./library/opendb.php");
              $db_socket = initSocket();
              $query = "SELECT * FROM  ".$configValue['DB_POST_TABLE']."";
              
              $statement = $db_socket->prepare($query);
              $statement->execute();
              
              $loop = $statement->rowCount();
              
              while($loop > 0)
              {
                $res = $statement->fetchAll();
                echo $res[0]['post'];
                //echo '<div style="background-color:black; color:white; padding:20px;">'.$row['post'].' '<br></br>'.$row['user'].'</div>';
                $loop = $loop-1;
              }
              include (__DIR__.'./library/closedb.php');
            ?>  -->          
        </div>

        <div id="sidebar">
            <iframe src="./library/nv-nav-bar.html" width=15% height=700px></iframe>
        </div>
      
    </body>    
</html>