<?php if(!isset($_SESSION))
{
session_start();

include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();
	set_time_limit (300);

}
?>
<?php
	function showresults($result)
	{
		$i = 0;
		
                    
		echo "<table border='1' align=center width=90%>";
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
				echo "<td align=center>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administration page</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$anchors_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$headings_css); ?>" rel="stylesheet" type="text/css" />
    <style type="text/css">
	.header {

		width:100%;
		top:0;
		border:none;
	}
	.footer {
		position:absolute;
		bottom:0;
		width:100%;
	}
	.content {
		float:left;
		width:80%;
		position:relative;
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
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar">
	<?php include('../left_data/leftMenu.php'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<div>
<?php

			
		$result = mysql_query("SELECT distinct idLogin,concat('  ',username) `username` FROM `metrxnweb`.`login` where active = 1");
		$resultCount = mysql_affected_rows();	
		
		echo "<form name=userAccess method=post action=adminPage.php>";
		$j = 0;		
		echo "<table border='1'>";
		echo "<th style=border-right-width:0>User access privilege</th><tr>";
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			echo "<td><input type=radio name=radio_val value=".$row['idLogin'].">".$row['username']."</input></td>";	
			$i++;
			$j++;
			if($j == 4)
			{
				echo "<br></tr><tr>";
				$j = 0;
			}
			
		}
		
		echo "</tr><tr><td style=border-right-width:0><input type=hidden name=count value=$resultCount>
					<input type=hidden name=submit_val value = true>
					<input type=submit value=submit />";
		echo "</td></tr></table>";
		echo "</form>";
		
		if(isset($_POST['submit_val']))
		{
			if($_POST['submit_val'] == true)
			{
				echo "<table><tr><td><h3> The user has access to the following data-sources </h3></td></tr><tr><td>";
				
				$result = mysql_query("select B.source,C.username,B.idSourceName,count(distinct D.idStr) `idStrCnt`
				from `metrxn`.`source_user_pin` A, `metrxn`.`source_pin` B,`metrxnweb`.`login` C,metrxn.abbrsynstrsrcview D 
				where A.idSource = B.idSourceName 
				and A.idUser = C.idLogin and C.idLogin =".$_POST['radio_val']."
				and B.idSourceName = D.idSource
        		and D.type = 'reactions'
        		group by B.source,B.idSourceName");
				$resultCount = mysql_affected_rows();
				if($resultCount > 0)
				{
					{
						echo "<form name=user_access_1 method=post action=adminPage.php>";
						$j = 0;		
						echo "<table border='1'>";
						echo "<th bgcolor='#99CCFF' style=border-right-width:0>User access is available for the following metabolic models and databases</th>
						<th bgcolor='#99CCFF'>username</th><th bgcolor='#99CCFF'>reaction resolved count</th><th bgcolor='#99CCFF'></th>";
						$i = 0;
						while ($row = mysql_fetch_array($result))
						{
							echo "<tr><td>".$row['source']."</td>
							<td>".$row['username']."</td>
							<td>".$row['idStrCnt']."</td>
							<td><input type=checkbox name=removeA[".$i."] value=".$row['idSourceName']."></input></td></tr>";
							$i++;
						}
						echo "<tr><td style=border-right-width:0>
							<input type=hidden name=countR value=$resultCount>
							<input type=hidden name=remove_access value=true>
							<input type=hidden name=idUser value=".$_POST['radio_val'].">
							<input type=submit value=submit /> <p>[Check and submit to <b>remove</b> access]</p>";
						echo "</td></tr></table>";
						echo "</form>";
					}				
				
				echo "</td></tr>";
				}
				$result = mysql_query("select B.source,B.idSourceName,count(distinct D.idStr) `idStrCnt` from `metrxn`.`source_pin` B,metrxn.abbrsynstrsrcview D  
					where B.idSourceName not in (select B.idSourceName
				from `metrxn`.`source_user_pin` A, `metrxn`.`source_pin` B,`metrxnweb`.`login` C 
				where A.idSource = B.idSourceName 
				and A.idUser = C.idLogin and C.idLogin =".$_POST['radio_val'].") 
				and B.idSourceName = D.idSource
        		and D.type = 'reactions'
        		group by B.source,B.idSourceName");				
				
				$resultCount = mysql_affected_rows();
				if($resultCount > 0)
				{
					echo "<tr><td><h3> Datasources which the user does not have access </h3></td></tr><tr><td>";
					
					{
						echo "<form name=user_access_2 method=post action=adminPage.php>";
						$j = 0;		
						echo "<table border='1'>";
						echo "<th bgcolor='#99CCFF' style=border-right-width:0>User access is prevented for the following metabolic models and databases</th>
						<th bgcolor='#99CCFF'>reaction resolved count</th>
						<th bgcolor='#99CCFF'></th>";
						$i = 0;
						while ($row = mysql_fetch_array($result))
						{
							echo "<tr><td>".$row['source']."</td>
							<td>".$row['idStrCnt']."</td>
							<td><input type=checkbox name=giveA[".$i."] value=".$row['idSourceName']."></input></td></tr>";
							$i++;
						}
						echo "<tr><td style=border-right-width:0>
							<input type=hidden name=countG value=$resultCount>
							<input type=hidden name=give_access value=true>
							<input type=hidden name=idUser value=".$_POST['radio_val'].">							
							<input type=submit value=submit /> <p>[Check and submit to <b>give</b> access]</p> ";
						echo "</td></tr></table>";
						echo "</form>";
					}
					
				}
				echo "</td></tr>";
				echo "</table>";				
			
			}
		}	
				if($_POST['remove_access'] == true)
				{
					if(isset($_POST['removeA']))
					{
						
						for ($i=0; $i<$_POST['countR'];) 
						{
							if(isset($_POST['removeA'][$i]))
							{
								$query = "delete from `metrxn`.`source_user_pin` where idSource =".$_POST['removeA'][$i]." and idUser =".$_POST['idUser'];								
								mysql_query($query);
								
								$query = "delete from `metrxn`.`source_user` where idSource =".$_POST['removeA'][$i]." and idUser =".$_POST['idUser'];															
								mysql_query($query);
							}
							$i++;
						}
					}
					
				}
				
				if($_POST['give_access'] == true)
				{
					if(isset($_POST['giveA']))
					{
						for ($i=0; $i<$_POST['countG'];) 
						{
							if(isset($_POST['giveA'][$i]))
							{
								
								$query = "insert into `metrxn`.`source_user`(idSource,idUser) values (".$_POST['giveA'][$i].",".$_POST['idUser'].")";								
								mysql_query($query);
							}
							$i++;
						}
					}
				}
			
		

?>

</div>


</body>