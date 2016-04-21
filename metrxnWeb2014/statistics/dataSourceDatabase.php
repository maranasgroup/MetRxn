<?php if(!isset($_SESSION))
{
session_start();


include("pathToGlobalVariables.php");
include($pathToGlobalVariables);

$connPath = relativePath(getcwd(),$conn_php);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datasource databases</title>
   	<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="anchors.css" rel="stylesheet" type="text/css" />
	<link href="headings.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
	.header {

		width:100%;
		top:0;
		border:none;


	}
	.search {
		overflow:scroll;
	}
	.footer {
		position:relative;
		bottom:0;
		width:100%;
	}
	.content {
		float:left;
		width:130%;
		position:relative;
		background-position:center;
		
	}
	.leftbar{
		float:left;
		width:20%;
		position:relative;



		}
	iframe{
		border:0;		
	}
	table
	{
	border-collapse:collapse;
	margin:20px;
	}
	td
	{
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
<table>
<tr>
<div class="header">
    <iframe src="<?php echo relPath($top_data_htm); ?>" width="100%" height="160" scrolling="no">
    </iframe>
</div>
</tr>
<tr>
<td>
<div class="leftbar">	
   	<iframe src="<?php echo relPath($left_Menu_php); ?>" height="450" scrolling="no">
    </iframe>
</div>
</td>
<td>
<div align="center" width="100%" scrolling="no">
<?php
		
        function getInfo($con)
            {
           
        include($con);
			connect();

        //mysql_select_db("my_db", $con);

        $result = mysql_query("select source,linkout from `metrxn`.`source` where sourceType = 'database' order by source;");
		
		echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Database name</th>
            <th>Link</th>
            </tr>";
			
		 while($row = mysql_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['source'] . "</td>";
                echo "<td> <a href=" . $row['linkout'] . "  target=_blank>". $row['linkout'] ."</td>";
                echo "</tr>";				
            }
			echo "</table>";


        }
		getInfo($connPath);
?>

</div>
</td>
</tr>
</table>

<div class="footer">
    <iframe src="<?php echo relativePath(getcwd(),$footer_php); ?>" height="60" width="100%" scrolling="no">
    </iframe>
</div>
</body>
</html>