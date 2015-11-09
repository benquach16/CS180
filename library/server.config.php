<?php
    /*******************************************************************
     * server configuration variable that holds all variable about
     * the servers database and versions.
     * 
     * when adding variable please incluse short comment
     * or description of what the variable does.
     * 
     * ****************************************************************/

global $configValue;

//this one is just for show KEK
$configValue['APP_VERSION'] = '1.0.0';

//ip that db is hosted on on the machine
$configValue['DB_HOST'] = 'localhost';

//the engine type of the db
$configValue['DB_ENGINE'] = 'mysql';

//the user name for the mysql db
$configValue['DB_USER'] = 'root';

//the password, pretty dank
$configValue['DB_PASS'] = getenv('DB_AUTH_PW');

//the name of the database, 
//this will be set when we figure out our project
$configValue['DB_NAME'] = 'test';

//name of table for user/pass. used for verification or creating user
//value can not be set until we set up the db name in mysql
$configValue['DB_USER_TABLE'] = 'auth_list';
$configValue['DB_FRIENDS_LIST'] = 'friends_list';
$configValue['DB_NOTIFICATIONS_LIST'] = 'notifications_list';
$configValue['DB_POST_TABLE'] = 'user_posts';

//this is depricated KEK
//$configValue['DB_ITEM_TABLE'] = 'item_list';

$configValue['DB_PET_TABLE'] = 'pet_list';
$configValue['DB_INV_TABLE'] = 'inv_list';
$configValue['DB_TEAM_TABLE'] = 'team_list';
?>
