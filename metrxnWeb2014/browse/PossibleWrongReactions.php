<?php if(!isset($_SESSION))
{
session_start();
if (isset($_SESSION['username'])) {
	include("..\conn.php");
	connect();
	set_time_limit (300);
}
else {
	die("Please login to view the page");
}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reactions which may be correctly identified as unbalanced</title>
</head>
<?php
function showresults($result)
	{
		
		$i = 0;
		
                    
		echo "<table border='1' align=center width=500>";
		$num_fields = mysql_num_fields($result);
		$spacing = 100/$num_fields;
		while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				echo "<th bgcolor='#99CCFF' align='center'>$columnName</th>";
				$i++;
			}
			
			
		while ($row = mysql_fetch_array($result)) 
		{
			$i = 0;
			echo "<tr>";
            while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				
				echo "<td align=center style=max-width:100>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
?>
<body>
<?php
if(isset($_POST['val'])) 
{
	if($_POST['val'] == 5)	
	{
				
		if(isset($_POST['field']))
		//echo sizeof($_POST['field']);
		$arr = $_POST['field'];
		$idAbbr = "";
		for ($i=0; $i<$_POST['count'];) 
		{
			if(isset($_POST['field'][$i]))
			{
				//echo $_POST['field'][$i]."<br />";
				$idAbbr = $idAbbr.","."'".$_POST['field'][$i]."'";
			}
				$i++;
				
		}
		$idAbbr =  preg_replace('/,/', '', $idAbbr, 1);
		
		
		$ref =0;
		$query = "select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_POST['idSrc']."'
        and B.idRxn not in (select distinct C.idRxn from `metrxn`.`abbreviationsynonym_pin` A,
`metrxn`.`abbrsynrxnsrc_pin` B, `metrxn`.`rxnatomsum_pin` C
where A.abbreviation in 
(".$idAbbr.")
and A.idSource = '".$_POST['idSrc']."'
and A.idAbbreviationsSynonym = B.idAbbrSyn
and B.idRxn = C.idRXn)
and sum <> 0";
			
		//echo $query;	
		if($idAbbr != "")
		{
			//echo $idAbbr;
			//echo $_POST['idSrc'];
			$result = mysql_query("$query");
			echo "<tr><td><h2 align=center>Filtered reaction information</h2></td></tr>";
			echo "<tr><td>";
			showresults($result);
			echo "Number of results: " . mysql_affected_rows();
			echo "</tr></td>";
			
			echo "<h2 align=center>Reactions off by charge</h2>";
		 
		 $query = "select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
				concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_POST['idSrc']."'
				and sum <> 0
				and B.atom = 'charge'
				and B.idRxn in (select distinct idRxn from `metrxn`.`rxnatomsum_pin` where idRxn = B.idRxn
				and atom not in ('H','charge') group by idRxn having sum(abs(sum)) = 0)
				AND B.idRxn not in (select distinct C.idRxn from `metrxn`.`abbreviationsynonym_pin` A,
				`metrxn`.`abbrsynrxnsrc_pin` B, `metrxn`.`rxnatomsum_pin` C
				where A.abbreviation in 
				(".$idAbbr.")
				and A.idSource = '".$_POST['idSrc']."'
				and A.idAbbreviationsSynonym = B.idAbbrSyn
				and B.idRxn = C.idRXn)";
		 	$result = mysql_query($query);
			
			echo "<tr><td>";
			showresults($result);
			echo "Number of results: " . mysql_affected_rows();
			echo "</tr></td>";
		
		echo "<h2 align=center>Remaining</h2>";	
		$query = "select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
				concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_POST['idSrc']."'
				and sum <> 0
				and B.atom = 'charge'
				and B.idRxn not in (select distinct idRxn from `metrxn`.`rxnatomsum_pin` where idRxn = B.idRxn
				and atom not in ('H','charge') group by idRxn having sum(abs(sum)) = 0)
				AND B.idRxn not in (select distinct C.idRxn from `metrxn`.`abbreviationsynonym_pin` A,
				`metrxn`.`abbrsynrxnsrc_pin` B, `metrxn`.`rxnatomsum_pin` C
				where A.abbreviation in 
				(".$idAbbr.")
				and A.idSource = '".$_POST['idSrc']."'
				and A.idAbbreviationsSynonym = B.idAbbrSyn
				and B.idRxn = C.idRXn)";	
			
		$result = mysql_query($query);
		
			echo "<tr><td>";
			showresults($result);
			echo "Number of results: " . mysql_affected_rows();
			echo "</tr></td>";	
		
		$query = "Select source from metrxn.source_pin where idSourceName = ".$_POST['idSrc'];	
		
		$result = mysql_query($query);
		echo "<tr><td>";
			showresults($result);			
		echo "</tr></td>";	
		}
	}
}
?>
</body>
</html>