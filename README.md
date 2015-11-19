# CS180
By Benjamin Quach, Calvin Deng, Mark De Ruyter, Tony Mazza, and Dylan De Los Santos

To set this up , please install the LAMP stack for your operating system. Initialize the git repository in your apache http folder, and set the remotes to track this repository with the command "git remote add origin http://github.com/benquach16/CS180", then pull

Set up root in mySQL as username: root, password: *********.

Also set up a table named auth_list with columns

    id int(6) unsigned auto-increment primary key,
    user varchar(32),
    pass varchar(32)

then set the user varable to a non-unique key value.

    alter table auth_list add key ( skill_id );

use google to fin how to create and alter tables in mysql,
then use the values given above

should I set up something to automate this process? 
it seems redundant once everyone has the table.


USE THIS FOR USER DATABASE  

    CREATE TABLE auth_list(
    id int(6) auto_increment not null primary key,
    user varchar(32) not null,
    pass varchar(32) not null,
	currency int(8) not null
    );

USE THIS FOR NOTIFICATIONS DATABASE


    CREATE TABLE notifications_list(
	id int(6) auto_increment not null primary key,
	receiver_id int(6) not null,
	sender_id int(6) not null,
	notification_type int(6) not null,
	sender varchar(32) not null,
	message varchar(512) not null
	);

USE THIS FOR FRIENDS DATABASE

	CREATE TABLE friends_list(
	id_A int(6) not null,
	id_B int(6) not null);

USER THIS FOR POSTS DATABASE

create table user_posts (
    id int(6) auto_increment not null primary key,
    userid int(6) not null,
    user varchar(32) not null,
    post varchar(2048) not null
)