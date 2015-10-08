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
  user varchar(8) not null,
  pass varchar(8) not null

)
