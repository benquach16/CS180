<?php

$servername="localhost";
$username="asdf"; //temp for now, until i figure out issues with username
$password="asdf";
$dbname="posts_db";

// Connect to server
$conn=new mysqli($servername, $username, $password, $dbname);

if ($conn->connection_error) {
	die("Connection failed: " . $conn->connect_error);
}



?>