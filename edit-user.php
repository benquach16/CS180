<?php
    session_start();
    //include lib to access auth db
    include './library/opendb.php';
    
    //retrieve post values from form,
    $user = $_POST['new_user'];
    $pass = md5($_POST['new_pass']);
    $userID = $_SESSION['curr_id'];
    
    // Update username
    if ( strlen($user) == 0 ) {
      // do nothing
    }
    else {
      $db_socket = initSocket();
      $query = "UPDATE auth_list SET user='".$user."' WHERE id=".$_SESSION['curr_id'];
      $statement = $db_socket->prepare($query);
      $statement->execute();
    }
    
    // Update password
    if ( strlen($_POST['new_pass']) == 0 ) {
      // do nothing
    }
    else {
      $db_socket = initSocket();
      $query = "UPDATE auth_list SET pass='".$pass."' WHERE id=".$_SESSION['curr_id'];
      $statement = $db_socket->prepare($query);
      $statement->execute();
    }
    
    //close db
    include './library/closedb.php';
    
    header("Location: http://localhost/hud.php");
die();
?>
