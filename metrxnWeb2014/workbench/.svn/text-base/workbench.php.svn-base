<?php session_start();?>
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
<script type="text/javascript" SRC="../marvin/marvin.js"></script> 

</head>

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar"">
	<?php include('../left_data/leftMenu.php'); ?>
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
		   echo "<table><tr><td>";
		   
		   echo "<script type=text/javascript>\n";
		   echo "mview_begin('../marvin', 400, 200);\n";
		   echo "mview_param('mol', '../10042.rxn');\n";
		   echo "mview_end();\n";
		   echo "</script>";
		   
		   
		   
		   
			while($row = mysql_fetch_array($result))
            {	
				
				{
					$result1 = mysql_query("SELECT A.abbr,group_concat(concat('<a href=http://localhost/MetRxn/searchResults/results.php?searchString=',synonym,'>',synonym,'</a>')) syn FROM `intermediate`.`reactionabbreviation` A,
					`intermediate`.`synonymidstructuresabbr` B
					where A.reaction = '".$row['eq']."'
					and A.abbr = B.abbr
					and A.sourceName = B.sourceName
					and A.sourceName = '".$source."'
					group by A.abbr;");
					
					echo "<table border=1>
					<h4 >Abbreviations and the corresponding metabolite names for the reaction equation '" .$row['eq']."' as mentioned in the metabolic model of ".$source."</h4>
            		<tr bgcolor=#C4D8F1>
					<th>Abbreviation</th>
            		<th>Metabolite names</th>					
            		</tr>";
					
					while($row1 = mysql_fetch_array($result1))
				{
					echo "<tr>";
					echo "<td>" . $row1['abbr'] . "</td>";
					echo "<td>" . $row1['syn'] . "</td>";
                	
                	echo "</tr>";
				}
				}
				
				{
					$result2 = mysql_query("SELECT distinct concat('<a href=workbench.php?searchString=',ModelReactions,'&source=',replace(ReplicaSource,' ','&#32;'),' target=_parent>',equation,'</a>') repsrc,ReplicaSource,ModelId FROM `InterMediate`.`OverlapInfo_".$source."` A, `BioDb4`.`ModelReactions` B 
				where A.sourceName = '".$source."' AND A.reaction = '".$row['eq']."' and A.reactionReplica = B.EquationChngdSeperator and B.sourceName = A.ReplicaSource AND A.metaboliteMatchCount >=3 order by ReplicaSource,metaboliteMatchCount desc");
				
				echo "<table border=1>
								
            	<tr bgcolor=#C4D8F1>
				<th>Source Id</th>
            	<th>Source</th>
				<th>Reactions as represented in other models</th>
            	</tr>";
				
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
				
				$temp_table = "test.temp_abbr_cnfdnc_score_".$source.$searchString;
				{
					mysql_query("create temporary table test.temp_abbr_cnfdnc_score_".$source.$searchString." select distinct A.abbr,C.idStructures,C.cnt,D.smiles from `intermediate`.`synonymidstructuresabbr` A,`intermediate`.`reactionabbreviation` B,
							(select distinct C.idStructures,count(distinct C.sourceNAme) cnt 
								from `InterMediate`.`OverlapInfo_".$source."` A,
								`intermediate`.`reactionabbreviation` B,
								`intermediate`.`synonymidstructuresabbr` C
								where A.reaction = '".$row['eq']."'
								and A.metaboliteMatchCount >= 3
								and A.reactionReplica = B.reaction
								and A.replicaSource = B.sourceName
								and B.abbr = C.abbr
								and B.sourceName = C.sourceName
								group by C.idStructures) C,
								`udb`.`structures` D
								where A.abbr = B.abbr
								and A.sourceName = B.sourceName
								and B.reaction = '".$row['eq']."'
								and B.sourceName = '".$source."'
								and A.idStructures = C.idStructures
								and A.idStructures = D.idStructures
								order by A.abbr,C.cnt desc;");
					
					$result3 = mysql_query("select distinct abbr,idStructures,cnt,smiles from test.temp_abbr_cnfdnc_score_".$source.$searchString);
					
				echo "<table border=1>
           		<tr bgcolor=#C4D8F1>
				<th>abbreviation Id</th>
            	<th>SMILES</th>				
            	</tr>";
				$abbr_1 = "";
				$smiles_1 = "";
				$score_1 = "";				
				while($row3 = mysql_fetch_array($result3))
				{
					if($abbr_1 == "")
					{
						$abbr_1 = $row3['abbr'];
						
					}
					if($smiles_1 == "")
					{
						$smiles_1 = $row3['smiles'];
						
					}
					if($score_1 == "")
					{
						$score_1 = $row3['cnt'];
						
					}
					
					echo "<tr>";
					echo "<td>" . $row3['abbr'] . "</td>";
					echo "<td>" . $row3['smiles'] . "</td>";
                	
                	echo "</tr>";
				}
				
				
				echo "</table>";
				}
				
			}
			echo "</td></tr></table>";
mysql_close($con);			
?>
</div>
<!--<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>	-->	   
</body>
</html>