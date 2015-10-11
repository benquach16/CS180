<?php
    //set these for error testing
    /*
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
    */

    //first we create a new session id, too simple, fix later
    srand(make_seed());
    //get random val between 1-9
    $rand = rand(1,9);
    //merge rand value with hashed ip addr
    $session_id = $rand . md5($_SERVER['REMOTE_ADDR']);
    
    //if session id is valid
    if(session_valid_id($session_id)){
        //set session id
        session_id($session_id);
        //expires in 1hr
        ini_set('session.gc_maxlifetime', 3600);
        //session_set_cookie_params(3600);
        session_start();
    } else {
        header('Location: index.html?error=failed to start session');
    }
    
    include './library/opendb.php';
    $db_socket = initSocket();
    $user = $_POST['login_user'];
    $pass = md5($_POST['login_pass']);
    
    $query = "SELECT id, user FROM ".$configValue['DB_USER_TABLE'].
        " WHERE user = '".$user."' AND pass = '".$pass."'";
    $statement = $db_socket->prepare($query);
    $statement->execute();
    
    if($statement->rowCount() == 1){
        //grab id and user to store in session
        $result = $statement->fetchAll();
        $id = $result[0]['id'];
        
        $_SESSION['logged_in'] = true;
        $_SESSION['curr_user'] = $user;
        $_SESSION['curr_id'] = $id;
        //session_write_close();
        
        header('Location: hud.php?id='.$_SESSION['curr_id'].$id);
        exit;
    } else {
        header('Location: index.html?error=no user found');
        exit;
    }
    
    include './library/closedb.php';
    
    function session_valid_id($session_id)
    {
        return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session_id) > 0;
    }
    
    function make_seed()
    {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }
?>
