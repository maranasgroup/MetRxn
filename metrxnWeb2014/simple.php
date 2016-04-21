<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.example {
	
	top:0;
	position:absolute;
}
.bottom{
	bottom:0;
	position:absolute;
	
}
.page {
	float:left;
	position:relative;
}
</style>
</head>

<body>
<div class="page">
<?php include('left_data/leftMenu.htm'); ?>
</div>
<div class="example">
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

        $result = mysql_query("SELECT A.Smiles smiles,Group_concat(B.sourceName) src FROM `udb`.`structures` A, `biodb4`.`metabolitesynonyms` B where A.idStructures = B.idStructures and B.synonym = 'amp' group by A.Smiles;");

        echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Source</th>
            <th>Smiles</th>
            </tr>";

        while($row = mysql_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['src'] . "</td>";
                echo "<td>" . $row['smiles'] . "</td>";
                echo "</tr>";
            }

        echo "</table>";

        mysql_close($con);
        }
        getStructures("");
?>
</div>
<div class="bottom">
<?php

        function getSynonyms($x)
        {
        $var = $_GET["searchString"];
        $con = mysql_connect("localhost","root","");
        if (!$con)
          {
          die('Could not connect: ' . mysql_error());
          }

        mysql_select_db("my_db", $con);

        $result = mysql_query("select distinct B.SourceName src, group_concat(distinct B.synonym) syn from `biodb4`.`metabolitesynonyms` A, `biodb4`.`metabolitesynonyms` B where A.synonym = 'amp' and A.idStructures = B.idStructures group by B.sourceName");

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
        getSynonyms("");
?>
</div>
</body>
</html>