<?php
   /* if (($_SERVER['SERVER_NAME']!="localhost")){
     echo "invalid connection parameters";
    die();
}*/

function connect()
{
    $username     = "metrxnWeb";
    $pwd                = "login@123";
    $host             = "130.203.234.86";    
	//$host             = "ec2-174-129-255-219.compute-1.amazonaws.com:3336";
    if (!($conn=mysql_connect($host, $username, $pwd)))  {
       printf("error connecting to DB");
       exit;
    }
	else 
	return $conn;	
}
?>