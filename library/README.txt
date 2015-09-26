This directory will be used to hold php scripts that can be used in other scripts as helper functions.
This README should include the script file name and a high level description of what it does. 
It would also be helpful if there were descriptions of the functions and services in the script.
If you add scripts to this library, please include them in this README.

server.config.php ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Include this script so that you can access the server configuration variables. The variables
are stored in $configurationValue array. 

opendb.php ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Sets up the database socket. Allows connection to database table that handles user/pass authentication.
Include the script and use the variable $db_socket as if it was a mysql connection variable.
For some information on mysql functions, check out http://www.w3schools.com/php/default.asp .

closedb.php ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Closes the database socket from opendb.php. Simply include this script when you are done with the socket.