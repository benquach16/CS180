<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        include($_SERVER['DOCUMENT_ROOT']."/library/server.config.php");
        echo $configValue['PEER_KEY'];
    }