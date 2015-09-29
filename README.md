# CS180

Set up root in mySQL as username: root, password: dankmemes.

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
