<?php
    // included so we have access to server variables
    include (dirname(__FILE__).'/server.config.php');
    
    //create the mysql query string
    $db_engine = $configValue['DB_ENGINE'];
    $db_user = $configValue['DB_USER'];
    $db_pass = $configValue['DB_PASS'];
    $db_host = $configValue['DB_HOST'];
    $db_name = $configValue['DB_NAME'];
    
    $db_connection = $db_engine.':host='.$db_host.';dbname='.$db_name;

    $db_socket = null;
    try{
        $db_socket = new PDO($db_connection, $db_user, $db_pass);
        $db_socket->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'Connection to database failed: '.$e->getMessage();
    }
?>
