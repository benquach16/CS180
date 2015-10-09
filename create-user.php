<?php
    //set these for error testing
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    $error_msg = "";
    //include lib to access auth db
    include './library/opendb.php';
    
    //retrieve post values from form, 
    $user = $_POST['new_user'];
    $pass = md5($_POST['new_pass']);
    
    //check if user name already exists
    $result = null;
    try{
        $db_socket = initSocket();
        $query = "SELECT user FROM ".$configValue['DB_USER_TABLE']." WHERE user = '".$user."'";
        $statement = $db_socket->prepare($query);
        $statement->execute();
        //$result = $statement->fetchAll();
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        header('Location: index.html?error='."Error: " . $e->getMessage());
        exit;
    }
    
    if($statement->rowCount() < 1){
        $query =  "INSERT INTO ".$configValue['DB_USER_TABLE']." (user, pass)".
            " VALUES (:user, :pass);";
        $statement = $db_socket->prepare($query);
        $statement->bindParam(':user', $user);
        $statement->bindParam(':pass', $pass);
        $statement->execute();
        
        header('Location: index.html');
    } else {
        header('Location: index.html?error=res problem');
        exit;
    }
    
    //close db
    include './library/closedb.php';
?>
