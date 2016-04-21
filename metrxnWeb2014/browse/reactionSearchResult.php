<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reaction search results</title>
<style type="text/css">
table
	{
	border-collapse:collapse;
	margin:20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	overflow:scroll;
	}
.footer {
		position:absolute;
		bottom:0;
		width:100%;
	}
iframe{
		border:0;
	}
	
.leftbar{
		float:left;
		width:20%;
		position:relative;
		
		}
	.header {

		width:100%;
		top:0;
		border:none;
		


	}
	#result a:hover { background: #aaaaaa; font-size:16px;text-decoration:overline}
#result a {text-decoration:none; color:#000}
</style>
<script src="../Jmol-12.0.25-binary/jmol-12.0.25/Jmol.js" type="application/javascript">
</script>
<script language="JavaScript" type="application/javascript">
function showStructure(tab)
{
	
	jmolInitialize("../Jmol-12.0.25-binary/jmol-12.0.25");
	jmolSetAppletColor("#FFFFFF");
	jmolApplet(150,"load ../Jmol-12.0.25-binary/models/"+tab+".mol; set labelalignment center; zoom 110;");
	
	
}
</script>
</head>

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar"">
	<?php include('../left_data/leftMenu.htm'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<div id="result">

<?php
           	$searchString = $_GET["searchString"];
	   		$source = $_GET["source"];
		   
		   
		   
		   $con = mysql_connect("localhost","root","");
        if (!$con)
           {
            die('Could not connect: '. mysql_error());
           }
		  
		   $result = mysql_query("SELECT distinct EquationChngdSeperator eq,equation,sourceName src FROM `BioDb4`.`ModelReactions` WHERE ModelReactions = '".$searchString."' AND sourceNAme = '".$source."'");
		    
			while($row = mysql_fetch_array($result))
            {			
				echo "<table border=1>
            	<tr bgcolor=#C4D8F1>
				<th>Source Id</th>
            	<th>Source</th>
				<th>Reactions as represented in other models</th>
            	</tr>";

				$result2 = mysql_query("SELECT distinct concat('<a href=../browse/reactionSearchResult.php?source=',replace(ReplicaSource,' ','&#32;'),' target=_parent>',equation,'</a>') repsrc,ReplicaSource,ModelId FROM `InterMediate`.`OverlapInfo_".$source."` A, `BioDb4`.`ModelReactions` B 
				where A.sourceName = '".$source."' AND A.reaction = '".$row['eq']."' and A.reactionReplica = B.EquationChngdSeperator and B.sourceName = A.ReplicaSource AND A.metaboliteMatchCount >=3 order by ReplicaSource,metaboliteMatchCount desc");
				while($row2 = mysql_fetch_array($result2))
				{
					echo "<tr>";
					echo "<td>" . $row2['ModelId'] . "</td>";
					echo "<td>" . $row2['ReplicaSource'] . "</td>";
                	echo "<td>" . $row2['repsrc'] . "</td>";
                	echo "</tr>";
				}
				echo "</table>";
				
			}
mysql_close($con);			
?>
</div>
<!--<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>	-->	   
</body>
</html>