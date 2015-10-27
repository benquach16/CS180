<?php
  session_start();
  // access to the db
  include('./getUser.php');
  include (dirname(__FILE__).'/server.config.php');
  include_once (__DIR__."./opendb.php");
  
  $user=getUser();
  //$user='filler';

  // get users post data
  // $_GET['new_post'];
  $post = $_POST['new_post'];
   
  // push the post to db
  $db_socket = initSocket();
  $query = "INSERT INTO ".$configValue['DB_POST_TABLE']." (user, post)".
      "VALUES(:user, :post);";
  $statement = $db_socket->prepare($query);
  $statement->bindParam(':user', $user);
  $statement->bindParam(':post', $post);
  $statement->execute();
  
  include (__DIR__.'./closedb.php');
  
?>