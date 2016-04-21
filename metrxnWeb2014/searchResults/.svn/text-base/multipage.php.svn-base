<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../Jmol-12.0.25-binary/jmol-12.0.25/Jmol.js" type="application/javascript">
</script> 
</head>

<body>
<!-- while using a php, we can break the code between a php and a html multiple times-->
<?php
$con = mysql_connect("localhost","root","");
        if (!$con)
            {
            die('Could not connect: ' . mysql_error());
            }
		if (!($limit))
			{
     		$limit = 10;
			}	
		if (!($page))
			{
     		$page = 0;
			}
		$numresults = mysql_query("SELECT 'atp' name FROM `biodb4`.`metabolitesynonyms` limit 1;");
		while($row = mysql_fetch_array($numresults))
            {
		echo "<script type=\"text/javascript\">\n";
		echo "alert(\"load ../Jmol-12.0.25-binary/models/".$row['name'].".mol; cpk 0.6; spin on; label %e; set labelalignment center; axes; set spin x 15; set spin y 5; set spin z 5; zoom 110;\");\n";
		
		echo "jmolInitialize(\"../Jmol-12.0.25-binary/jmol-12.0.25\");\n";
		echo "jmolSetAppletColor(\"#FFFFFF\");\n";
		
		echo "jmolApplet(500,\"load ../Jmol-12.0.25-binary/models/".$row['name'].".mol; cpk 0.6; spin on; label %e; set labelalignment center; axes; set spin x 15; set spin y 5; set spin z 5; zoom 110;\");\n";
		
		echo "</script>\n\n";
			}
			
?>
</body>
</html>