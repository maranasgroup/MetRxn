<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../Jmol-12.0.25-binary/jmol-12.0.25/Jmol.js" type="application/javascript">
</script>
</head>

<body>
<?php
		$searchString = $_GET['searchString'];
		$id = $_GET['id'];
		$con = mysql_connect("localhost","root","");
        if (!$con)
          {
          die('Could not connect: ' . mysql_error());
          }

        mysql_select_db("my_db", $con);

        $result = mysql_query("select distinct B.SourceName src, trim(group_concat(distinct concat(' ',B.synonym))) syn,count(distinct B.synonym) cnt from `biodb4`.`metabolitesynonyms` A, `biodb4`.`metabolitesynonyms` B where A.synonym = '$searchString' and A.idStructures = B.idStructures and A.idStructures = '$id' group by B.sourceName");

        echo "<table border=1>
        <tr bgcolor=#C4D8F1>
        <th>Source</th>
        <th>Synonyms</th>
        </tr>";
		
        while($row = mysql_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['src'] ."<font color:blue>"."(".$row['cnt'].")"."</font>"."</td>";
          echo "<td>" . $row['syn'] . "</td>";
          echo "</tr>";
          }
        echo "</table>";

        mysql_close($con);
?>

</body>
</html>