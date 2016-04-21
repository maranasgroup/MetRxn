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
<title>Enter new source information here</title>
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
if(isset($_POST['submit']))
{
	$submit = $_POST['submit'];
	$sourceName = $_POST['sourceName'];	
	$Organism = $_POST['Organism'];
	$sourceType = $_POST['sourceType'];
	$Strain = $_POST['Strain'];
	$version = $_POST['version'];
	$username = $_SESSION['username'];
	$pubmedId = $_POST['pubmedId'];	
	$linkout = $_POST['linkout'];
	if($submit == 'Insert') 
	{		
	if(trim($sourceName) != "")
		{
			
		if(trim($Organism) != "")
		{
			$query = mysql_query("select distinct source from `metrxn`.`source_pin` where source = '$sourceName'");
			$numrows = mysql_num_rows($query);
			if ($numrows != 0) 
			{ 
				echo("<font color=red size=5>This source name exists in the database, please choose a unique source name</font>");
			}
			else
			{
			//insert the source values and return the unique source id
			//$query = mysql_query("insert into `metrxn`.source(source,Organism,sourceType,date,idUser,Strain,Version,pubmed) 
			//select $sourceName,$Organism,$sourceType,curdate(),idLogin,$Strain,$version,$pubmedId from `metrxnweb`.`login` where username = $username");
			$query = mysql_query("insert into `metrxn`.source(source,Organism,sourceType,date,idUser,Strain,Version,pubmed,linkout) 
			select '$sourceName','$Organism','$sourceType',curdate(),idLogin,'$Strain','$version','$pubmedId','$linkout' from `metrxnweb`.`login` where username = '$username'");
			$numrows = mysql_num_rows($query);
			echo $numrows;
			}
		}
		else
			echo("<font color=red size=5>Please enter the organism name, this field cannot be left blank</font>");	
		}
	else
		echo("<font color=red size=5>Please enter a unique source name, this field cannot be left blank</font>");
	}				



}
?>
<?php
echo "<h1>Enter source information here</h1>";
?>
<form action="InsertSourceDetails.php" method="POST">
  <table>
    <tr>
      <td>Enter the source name</td>
      <td><input type="text" name="sourceName"
			value="<?php if(isset($_POST['sourceName'])) $_POST['sourceName'];?>"></td>
    </tr>
	<tr>
      <td>Enter the Organism name</td>
      <td><input type="text" name="Organism"
			value="<?php if(isset($_POST['Organism'])) $_POST['Organism'];?>"></td>
    </tr>
	<tr>
      <td>Choose source type</td>
      <td>
		  <input type="radio" name="sourceType" value="Metabolic model" <?php if(isset($_POST['sourceType']))if($_POST['sourceType'] == 'Metabolic model') echo "checked";?> checked/> Metabolic model	  
		  <input type="radio" name="sourceType" value="database" <?php if(isset($_POST['sourceType']))if($_POST['sourceType'] == 'database') echo "checked";?>/>	  Database
	  </td>
    </tr>
	
    <tr>
      <td>Enter the Strain</td>
      <td><input type="text" name="Strain"
			value="<?php if(isset($_POST['Strain'])) $_POST['Strain'];?>"></td>
    </tr>
    <tr>
      <td>Enter the version</td>
		  <td>
			<input type="text" name="version" value="<?php if(isset($_POST['version'])) $_POST['version'];?>">
		  </td>
    </tr>
    <tr>
      <td>Username</td>
		<td>
			<input type="text" name="username" disabled value="<?php echo $_SESSION['username'];$_SESSION['username'];?>">
		</td>
    </tr>
	<tr>
      <td>Enter pubmed id</td>
		<td>
			<input type="text" name="pubmedId" value="<?php if(isset($_POST['pubmedId']))$_POST['pubmedId'];?>">
		</td>
    </tr>	
    <tr>
      <td>Enter link to this source</td>
		<td>
			<input type="text" name="linkout" value="http://www.ncbi.nlm.nih.gov/pubmed/">
		</td>
    </tr>  
	  <td>Click to submit</td>
      <td><input type="submit" name="submit" value="Insert"></td>
    </tr>
  </table>
</form>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd -->
</html>
