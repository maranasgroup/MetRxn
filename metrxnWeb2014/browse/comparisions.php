<?php if(!isset($_SESSION))
{
session_start();

include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();

	if(isset($_SESSION['username']))
	{
	session_start();
	$username = $_SESSION['username'];
	}
	else 
	{
	$username = "guest";
	}

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
<!DOCTYPE html>
<html lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>MetRxn Database of Costas D. Maranas. Penn State Department of Chemical Engineering</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--Custom CSS-->
  <link href="../css/labwebsite.css" rel="stylesheet"></link>
  <style>
    .container { padding: 0px !important;}

  </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top navbar-custom" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand hidden-xs" href="index.htm">Penn State | Chemical and Biological Systems Optimization Lab | MetRxn</a>
      <a class="navbar-brand visible-xs" href="index.htm">Penn State | MetRxn</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../MetRxntest.php"><i class="fa fa-home"></i></a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="BrowseByOrganism_new.php">Organism</a></li>
          <li class="active"><a href="comparisons_new.php">Comparisons</a></li>
        </ul>
        </li>
                <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Documentation
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../Documentation.html">About MetRxn</a></li>
        </ul>
        </li>
        <li><a href="mailto:costas@psu.edu">Contact</a></li>
        <li><a href="../MetRxntest.php">Login</a></li>
        <li><a href="http://www.maranasgroup.com">Maranas Group</a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="padding: 20px">
<div class="container-fluid">
  <div class="row">
		<div class="col-md-10 col-md-offset-1 comparision">
			<!-- <div class="comparision"> -->
			    
			      <?php

						
					$result = mysql_query("SELECT source `source`,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
					(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B /*,`metrxn`.`reaction_pin` C*/
					where A.idUser = B.idlogin and B.username = '".$username."' /*and A.idSource = C.idSource*/) and sourceType = 'Metabolic model' order by sourceType,source");
					
					$resultCount = mysql_affected_rows();
					
					echo "<form name=model_comparsion method=post action=statQuery_new.php> ";

					echo "<table valign='top'>";
					$j = 0;				
					echo "<th style='background-color:#99CCFF;'>Metabolic models</th><tr>";
					$i = 0;
					while ($row = mysql_fetch_array($result))
					{
						echo "<td style='border:1px solid black;'><input type=checkbox name=field[".$i."] value=".$row['idSourceName'].">".$row['source']."</input></td>";	
						$i++;
						$j++;
						if($j == 3)
						{
							echo "<br></tr><tr>";
							$j = 0;
						}
						
					}
					echo "</tr><tr><td></td></tr><tr>";
					echo "";
					$result = mysql_query("SELECT source `source`,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
					(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B,`metrxn`.`reaction_pin` C
					where A.idUser = B.idlogin and B.username = '".$username."' and A.idSource = C.idSource) and sourceType = 'database' 
					order by sourceType,source");
					
					$j = 0;				
					echo "<th style='background-color:#99CCFF;'>Databases</th><tr>";
					
					while ($row = mysql_fetch_array($result))
					{
						echo "<td style='border:1px solid black;'><input type=checkbox name=field[".$i."] value=".$row['idSourceName'].">".$row['source']."</input></td>";	
						$i++;
						$j++;
						if($j == 3)
						{
							echo "<br></tr><tr>";
							$j = 0;
						}
						
					}
					
					
					echo "</tr><tr><td style=border-right-width:0>
								<input type=hidden name=count value=$resultCount>
								<input type=hidden name=val value=5>
								<input type=submit value=submit />";
								
					echo "</td></tr></table>";
					echo "</form>";
			?>

		</div>
	</div>
</div></div>
</body>