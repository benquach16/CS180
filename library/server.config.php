<?php
    /*******************************************************************
     * server configuration variable that holds all variable about
     * the servers database and versions.
     * 
     * when adding variable please incluse short comment
     * or description of what the variable does.
     * 
     * ****************************************************************/

//this one is just for show KEK
$configValue['APP_VERSION'] = '1.0.0';

//ip that db is hosted on on the machine
$configValue['DB_HOST'] = 'localhost';

//the engine type of the db
$configValue['DB_ENGINE'] = 'mysql';

//the user name for the mysql db
$configValue['DB_USER'] = 'root';

//the password, pretty dank
$configValue['DB_PASS'] = 'dankmemes';

//the name of the database, 
//this will be set when we figure out our project
$configValue['DB_NAME'] = 'place holder';

//name of table for user/pass. used for verification or creating user
//value can not be set until we set up the db name in mysql
$configValue['DB_USER_TABLE'] = 'place holder';
?>
