<?php if(!isset($_SESSION))
{
session_start();
include("..\conn.php");
connect();
set_time_limit (300);

if(isset($_SESSION['username']))
{
session_start();
$username = $_SESSION['username'];
}
else 
{
$username = "guest";
}
	{
	$accessLevel = "guest";
	$result = mysql_query("select accessLevel from `metrxnweb`.`login` where username = '".$username."'");
	while ($row = mysql_fetch_array($result))
		{
			$accessLevel = $row['accessLevel'];
			if(!$accessLevel == 'admin')
			die();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Assign metabolites with structures</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
<link href="../metRxnContents.css" rel="stylesheet" type="text/css" />
<link href="../anchors.css" rel="stylesheet" type="text/css" />
<link href="../headings.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.header {
	width:100%;
	top:0;
	border:none;
}
.footer {
	position:absolute;
	bottom:0;
	width:100%;
}
.content {
	float:left;
	width:80%;
	position:relative;
}
.leftbar {
	float:left;
	width:20%;
	position:relative;
}
iframe {
	border:0;
}
table {
	border-collapse:collapse;
	margin:20px;
}
td {
	padding:2px;
}
.imageframe {
}
img {
	margin:20px;
	float:left;
}
#structure {
	float:left;
}
#synonym {
	bottom:1;
	float:none;
}
</style>
</head>

<body>
<div class="header">
  <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no"> </iframe>
</div>
<div class="leftbar">
<?php include('../left_data/leftMenu.php'); ?>
<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<?php
function showresults($result,$heading)
	{
		echo "<h1>$heading</h1>";
		$i = 0;
		
                    
		echo "<table border='1' align=center>";
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
				
				echo "<td align=center style=max-width:100>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
function showresultsWithCheckBox($result,$heading,$checkall)
	{
	/*This can be called only inside a form*/
	
		echo "<h1>$heading</h1>";
		$i = 0;		
                    
		echo "<table border='1' align=center>";
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
				
				echo "<td align=center style=max-width:100>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}	
?>
<?php
echo "<h1>Choose a source to fix in the drop down</h1>";
?>
<form action="MetaboliteStructureAssignment.php" method="POST">
	<select name="Organism">
				<?php
                    if (isset($_POST['submit'])) {
                        echo "<option value='" . $_POST["Organism"] . "'>" . $_POST["Organism"] . "</option>";
                    } else {
                        echo "<option value=''>---------------</option>";
                    }

                    $result = mysql_query("SELECT DISTINCT source,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
					(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
					where A.idUser = B.idlogin and B.username = '".$username."') order by source;");
					
                    while ($row = mysql_fetch_array($result)) {
                        echo "<option value='" . $row['source'] . "'>" . $row['source'] . "</option>";
                    }
				?>
		<input type="submit" name = "submit" value="Submit1" />
    </select>				


<?php
if(isset($_POST['submit']))
echo "<table>";
if($_POST['submit'] == 'Submit1')
  
	{
		$result = mysql_query("SELECT A.Abbreviation,C.ExternalDbId,C.externalDb,group_concat(distinct synonym) `Synonyms to identify`,
			group_concat(distinct D.syn) `Matched synonyms` 
			FROM `metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B,`temp`.`metabolitesimport` C,`metrxn`.`abbrsynstrsrcview` D
			where A.idSource = B.idSourceName
			and B.source = C.sourceName
			and A.abbreviation = C.abbreviation
			and A.synonym = C.synonyms
			and B.Source = '".$_POST['Organism']."'
			and C.externalDbid = D.abbr
			and C.externalDb = D.source
			and A.idAbbreviationsSynonym not in (select idAbbrsyn from `metrxn`.`abbrsynstrsrc_pin` where idSrc = 51)
			group by A.Abbreviation;") ;
		showresults($result,'Data matched with external Id as provided in the original file');
	}
  echo "</table>";
?>  
</form>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd -->
</html>
