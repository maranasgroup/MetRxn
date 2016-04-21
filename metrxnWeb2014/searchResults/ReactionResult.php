<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reaction Search Results</title>
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="../metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="../anchors.css" rel="stylesheet" type="text/css" />
	<link href="../headings.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
	table
	{
	border-collapse:collapse;
	margin:20px;
	}
	td
	{
	padding:2px;
	}
	</style>
</head>

<body>
<?php
echo $_GET["query"];
function getResult($x)
{
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("my_db", $con);

$result = mysql_query("SELECT A.sourceName src,group_concat(distinct A.reaction) Reactions FROM `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B where A.reactionStructureId like concat('%','.',B.idStructures,'.','%') and B. synonym = 'AMP' and A.sourceName = B.sourceName group by A.sourceName");

echo "<table border=1>
<tr bgcolor=#C4D8F1>
<th>SourceName</th>
<th>Reactions</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['src'] . "</td>";
  echo "<td>" . $row['Reactions'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
}
getResult("");
?>
</body>
</html>
<!--;-->