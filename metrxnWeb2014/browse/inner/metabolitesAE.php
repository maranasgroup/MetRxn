<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse by metabolite names</title>
<link rel="stylesheet" href="tab.css" type="text/css" />
</head>

<body>

<table border="0">

<tr>
<td>
<div id=tab>
<h1>Browse for metabolites</h1>
<ul>
	<li id="selected"><a href="AE.php">A-E</a></li>
	<li><a href="FJ.php">F-J</a></li>
	<li><a href="KO.php">K-O</a></li>
	<li><a href="PT.php">P-T</a></li>
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

        $result = mysql_query("SELECT distinct synonym,substring(smiles,1,20) smiles,replace(synonym,'>','&gt;') ln FROM `biodb4`.`synonymsforPage` where synonym like ('A%') or synonym like ('B%') or synonym like ('C%') or synonym like ('D%') or synonym like ('E%') order by length(synonym)desc,synonym limit 1000;");

       	echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Metabolites</th>
            <th>SMILES</th>
            </tr>";

        while($row = mysql_fetch_array($result))
            {
                echo "<tr style=width:600>";
                echo "<td>" . $row['synonym'] . "</td>";
                echo "<td style=width:200>" . $row['smiles'] ."<a href=http://localhost/MetRxn/searchResults/results.php?searchString=".$row['ln'].">. . .</a>"."</td>";
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