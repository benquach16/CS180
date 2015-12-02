<?php

    //include lib to access auth db
    include './library/opendb.php';
    
    //set these for error testing
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
    
    //retrieve post values from form,
    $user = $_POST['new_user'];
    $pass = md5($_POST['new_pass']);
    $userID = $_SESSION['curr__id'];
            
    try{
        $db_socket = initSocket();
        
        // Edit the data for a given user id
        $query = "UPDATE auth_list SET user='".$user."' WHERE id=".$_SESSION['curr__id'];
        $statement = $db_socket->prepare($query);
        $statement->execute();
        //$result = $statement->fetchAll();
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        header('Location: index.html?error='."Error: " . $e->getMessage());
        exit;
    } 
       
    //close db
    include './library/closedb.php';
?>