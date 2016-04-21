<?php
include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);
connect();
/*copy from here*/
if(isset($_SESSION['username']))
{
session_start();
$username = $_SESSION['username'];
}
else 
{
$username = "guest";
}
/*copy to here, DO NOT forget to copy the select line*/

mysql_select_db("metrxn") or die("Database not found for you");
$livesearch = mysql_real_escape_string(addslashes($_POST['livesearch']));
$livesearch = str_replace(' ','%',$livesearch);
$type = mysql_real_escape_string(addslashes($_POST['type']));
//echo $username;
if($type == "ec")
{
$result = mysql_query("SELECT distinct Abbreviation `syn` 
FROM `metrxn`.`abbreviationsynonym_pin` A, `metrxn`.`abbrsynrxnsrc_pin` B
where A.idAbbreviationsSynonym = B.idAbbrSyn
and Abbreviation like '$livesearch%' and type = '$type' 
and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
where A.idUser = B.idlogin and B.username = '".$username."') limit 4 ;") or die(mysql_query());
}
else
{
$result = mysql_query("SELECT distinct syn FROM `metrxn`.`abbrsynstrsrcview` where syn like '%$livesearch%' and type = '$type' 
and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
where A.idUser = B.idlogin and B.username = '".$username."')
limit 4 ;") or die(mysql_query());
}

function boldText($partialText,$fullValue) {
	$lengthp = strlen($partialText);
	$lengthf = strlen($fullValue);
	
	$blength = $lengthp - $lengthf;
	
	$notbolded = substr($fullValue, 0,$blength);
	$bolded = substr($fullValue, $blength);
	
	return $notbolded."<strong>".$bolded."</strong>"; 
	 
}

while ($row = mysql_fetch_assoc($result)) {
		echo "<div id='link' onclick='addText(\"".$row['syn']."\")'>".boldText($livesearch,$row['syn'])."</div>";
}
?>