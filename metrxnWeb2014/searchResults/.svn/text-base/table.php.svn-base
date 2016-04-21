<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>results</title>
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
<h1>
Search Results
</h1>
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

$result = mysql_query("select ecNumber,substrate,reactionPartners,organism,date,BrendaInchi FROM `brenda`.`substratedummy` limit 0,15");

echo "<table border=1>
<tr bgcolor=#C4D8F1>
<th>EC Number</th>
<th>Substrate</th>
<th>ReactionPartners</th>
<th>Organism</th>
<th>Date</th>
<th>InchiKey</th>

</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['ecNumber'] . "</td>";
  echo "<td>" . $row['substrate'] . "</td>";
  echo "<td>" . $row['reactionPartners'] . "</td>";
  echo "<td>" . $row['organism'] . "</td>";
  echo "<td>" . $row['date'] . "</td>";
  echo "<td>" . $row['BrendaInchi'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
}
getResult("");
?>
</body>
</html>