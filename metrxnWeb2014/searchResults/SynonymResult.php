<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Synonym Search Result</title>
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

$result = mysql_query("select distinct B.SourceName src, group_concat(distinct B.synonym) syn from `biodb4`.`metabolitesynonyms` A, `biodb4`.`metabolitesynonyms` B where A.synonym = 'AMP' and A.idStructures = B.idStructures group by B.sourceName");

echo "<table border=1>
<tr bgcolor=#C4D8F1>
<th>SourceName</th>
<th>Synonyms</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['src'] . "</td>";
  echo "<td>" . $row['syn'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
}
getResult("");
?>
</body>
</html>