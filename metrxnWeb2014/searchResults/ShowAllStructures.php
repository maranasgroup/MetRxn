<?php session_start();
include("..\conn.php");
connect();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Structures</title>
<script type="text/javascript"
	SRC="http://www.chemaxon.com/marvin/marvin.js"></script>

</head>

<body>
<?php
$fileType = $_GET['fileType'];
$type = $_GET['type'];
?>

<table>

<tr>
<td>

<?php

$result = mysql_query("SELECT DISTINCT cd_id,@cnt := @cnt + 1 `cnt` FROM Jchem.importedstructures,(Select @cnt := -1) B 
	WHERE cd_hash = '".$_GET['cd_hash']."';");
	//echo $_GET['cd_hash'];
$fileType = $_GET['fileType'];
$type = $_GET['type'];
$resultCount = mysql_affected_rows();
		
	if($resultCount >= 3)
	{
		$colval = 3;		
	}
	else if($resultCount < 3)
	{
		$colval = $resultCount;
	}
	
	if($resultCount % $colval == 0)
	{
		
		$rowval = $resultCount/$colval;
	}
	else 
	{
		$rowval = floor($resultCount/$colval + 1);
	}
	
echo "<script type=text/javascript>\n";

if($type == "reactions")
	{
		echo "mview_begin('../marvin', ".($colval*500).", ".($rowval*300).");\n";
		//echo "mview_begin('../marvin', 600, 300);\n";
	}
	else
	{
		echo "mview_begin('../marvin', ".($colval*400).", ".($rowval*200).");\n";
		//echo "mview_begin('../marvin', 400, 200);\n";
	}
	
	echo "mview_param('rows', '".$rowval."');\n";
	echo "mview_param('cols', '".$colval."');\n";
	
	while($row9 = mysql_fetch_array($result))
	{
		echo "mview_param('cell".$row9['cnt']."', '|../StructureFile/".$row9['cd_id'].".".$fileType."');\n";
/*			echo "mview_param('mol', '../StructureFile/".$row9['cd_id'].".".$fileType."');\n";*/
	}	
	echo "mview_end();\n";
	echo "</script>";
	
?>
</td>
</tr>
<tr>
<th>Various Stereoisomers of this <?php if($type=="metabolites" )echo 'metabolite'; else echo 'reaction'; echo nl2br("\n") ?></th>
<td>


</td>
</tr>
</body>
</html>
