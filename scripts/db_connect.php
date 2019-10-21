<?php
//Connection string
$db=mysqli_connect("localhost","aido727_RO","readonly","aido727_items");
//Check connection
if (mysqli_connect_errno($db))
{
	$connection_result = 1;
	$connection_message = "Failed to connect to database: " . mysqli_connect_error();
}
else
{
	$connection_result = 0;
	$connection_message = "Database connected OK";
}
?>