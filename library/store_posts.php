<?php
  session_start();
  // access to the db
  include('./getUser.php');
  include (dirname(__FILE__).'/server.config.php');
  include_once (__DIR__."./opendb.php");
  
  $userid=$_SESSION['curr_id'];
  $user=$_SESSION['curr_user'];
  $post = $_GET['postData'];
   
  // push the post to db
  $db_socket = initSocket();
  $query = "INSERT INTO ".$configValue['DB_POST_TABLE']." (userid, user, post) ".
      "VALUES (:userid, :user, :post);";
  $statement = $db_socket->prepare($query);
  $statement->bindParam(':userid', $userid);
  $statement->bindParam(':user', $user);
  $statement->bindParam(':post', $post);
  $statement->execute();
  
  echo "test";

  include (__DIR__.'./closedb.php');
  
?>