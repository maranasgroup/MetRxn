<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse metabolites P-T</title>
<link rel="stylesheet" href="tab.css" type="text/css" />
</head>

<body>

<table rules="none">

<tr>
<td>
<div id=tab>
<h1>Browse for metabolites</h1>
<ul>
	<li><a href="AE.php">A-E</a></li>
	<li><a href="FJ.php">F-J</a></li>
	<li><a href="KO.php">K-O</a></li>
	<li id="selected"><a href="PT.php">P-T</a></li>
    <li><a href="UZ.php">U-Z</a></li>
</ul>
</div>
</td>
</tr>
<tr>
<td>
<?php

        function getStructures($x)
            {
            $var = $_GET["searchString"];
            $con = mysql_connect("localhost","root","");
        if (!$con)
            {
            die('Could not connect: ' . mysql_error());
            }

        mysql_select_db("my_db", $con);

        $result = mysql_query("SELECT distinct synonym,sourceName src FROM `biodb4`.`synonymsforPage` where synonym like ('P%') or synonym like ('Q%') or synonym like ('R%') or synonym like ('S%') or synonym like ('T%') order by length(synonym)desc,synonym limit 1000;");

       	echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Synonym</th>
            <th>Source</th>
            </tr>";

        while($row = mysql_fetch_array($result))
            {
                echo "<tr>";
                echo "<td style=width:40%>" . $row['synonym'] . "</td>";
                echo "<td style=width:40%>" . $row['src'] . "</td>";
                echo "</tr>";
            }

        echo "</table>
		";

        mysql_close($con);
        }
        getStructures("");
?>
</td>
</tr>
</table>
</body>
</html>