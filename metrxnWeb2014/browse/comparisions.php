<?php if(!isset($_SESSION))
{
session_start();

include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();

	if(isset($_SESSION['username']))
	{
	session_start();
	$username = $_SESSION['username'];
	}
	else 
	{
	$username = "guest";
	}

}
?>
<?php
	function showresults($result)
	{
		$i = 0;
		
                    
		echo "<table border='1' align=center width=90%>";
		$num_fields = mysql_num_fields($result);
		$spacing = 100/$num_fields;
		while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				echo "<th bgcolor='#99CCFF' align='center'>$columnName</th>";
				$i++;
			}
			
			
		while ($row = mysql_fetch_array($result)) 
		{
			$i = 0;
			echo "<tr>";
            while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				echo "<td align=center>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Model comparisions</title>


<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="<?php echo relativePath(getcwd(),$metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$anchors_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$headings_css); ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
pre {
	text-indent: 30px
}
#tabmenu {
	color: #000;
	margin: 12px 0px 0px 0px;
	padding: 0px;
	z-index: 1;
	padding-left: 10px
}
#tabmenu li {
	display: inline;
	overflow: hidden;
	list-style-type: none;
}
#tabmenu a, a.active {
	color: #000;
	background: #C4D8F1;
	border: 1px solid black;
	padding: 2px 5px 0px 5px;
	margin: 0px;
	text-decoration: none;
	cursor: hand;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#tabmenu a.active {
	background: #ffffff;
	border-bottom-color: #FFF;
}
#tabmenu a:hover {
	color: #fff;
	background: #ADC09F;
}
#tabmenu a:visited {
	color: #E8E9BE;
}
#tabmenu a.active:hover {
	background: #ffffff;
	color: #DEDECF;
}
#content {
	text-align: justify;
	background: #ffffff;
	padding: 20px;
	border-top: none;
	z-index: 2;
	float: left;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#content a {
	text-decoration: none;
	color: #E8E9BE;
}
#content a:hover {
	background: #aaaaaa;
}
#result a:hover {
	background: #aaaaaa;
	font-size: 16px;
	text-decoration: overline
}
#result a {
	text-decoration: none;
	color: #000
}
.hide {
	display: none;
}
.show {
 display:!important;
}
table {
	border-collapse: collapse;
	margin: 20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
.footer {
	position: relative;
	bottom: 0;
	width: 100%;
}
iframe {
	border: 0;
}
.leftbar {
	float: left;
	width: 20%;
	
}
.comparision {
	float: none;
	width: 70%;
	position: relative;
}
.header {
	width: 100%;
	top: 0;
	border: none;
}
</style>
</head>
<body>
<table>
<tr>
<div class="header">
    <iframe src="<?php echo relativePath(getcwd(),$top_data_htm);?>" width="100%" height="160" scrolling="no">
    </iframe>
</div>
</tr>
<tr>
<div class="leftbar">	
   	<iframe src="<?php echo relativePath(getcwd(),$left_Menu_php); ?>" height="450" scrolling="no">
    </iframe>
</div>
<div class="comparision">
    
      <?php

			
		$result = mysql_query("SELECT source `source`,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
		(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B /*,`metrxn`.`reaction_pin` C*/
		where A.idUser = B.idlogin and B.username = '".$username."' /*and A.idSource = C.idSource*/) and sourceType = 'Metabolic model' order by sourceType,source");
		
		$resultCount = mysql_affected_rows();
		
		echo "<form name=model_comparsion method=post action=statQuery.php>";
		echo "<table valign='top'>";
		$j = 0;				
		echo "<th style='background-color:#99CCFF;'>Metabolic models</th><tr>";
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			echo "<td style='border:1px solid black;'><input type=checkbox name=field[".$i."] value=".$row['idSourceName'].">".$row['source']."</input></td>";	
			$i++;
			$j++;
			if($j == 3)
			{
				echo "<br></tr><tr>";
				$j = 0;
			}
			
		}
		echo "</tr><tr><td></td></tr><tr>";
		echo "";
		$result = mysql_query("SELECT source `source`,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
		(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B,`metrxn`.`reaction_pin` C
		where A.idUser = B.idlogin and B.username = '".$username."' and A.idSource = C.idSource) and sourceType = 'database' 
		order by sourceType,source");
		
		$j = 0;				
		echo "<th style='background-color:#99CCFF;'>Databases</th><tr>";
		
		while ($row = mysql_fetch_array($result))
		{
			echo "<td style='border:1px solid black;'><input type=checkbox name=field[".$i."] value=".$row['idSourceName'].">".$row['source']."</input></td>";	
			$i++;
			$j++;
			if($j == 3)
			{
				echo "<br></tr><tr>";
				$j = 0;
			}
			
		}
		
		
		echo "</tr><tr><td style=border-right-width:0>
					<input type=hidden name=count value=$resultCount>
					<input type=hidden name=val value=5>
					<input type=submit value=submit />";
					
		echo "</td></tr></table>";
		echo "</form>";
		


?>

</div>
</tr>
</table>
</body>