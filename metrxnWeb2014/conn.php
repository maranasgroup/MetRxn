<?php
   /* if (($_SERVER['SERVER_NAME']!="localhost")){
     echo "invalid connection parameters";
    die();
}*/

function connect()
{
    $username     = "metrxn";
    $pwd                = "costasmaranas";
    $host             = "metrxn.c8z1uro2w4nw.us-west-2.rds.amazonaws.com:3306";    
	//$host             = "ec2-174-129-255-219.compute-1.amazonaws.com:3336";
    if (!($conn=mysql_connect($host, $username, $pwd)))  {
       printf("error connecting to DB");
       exit;
    }
	else 
	return $conn;	
}
?>