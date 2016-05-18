<?php if(!isset($_SESSION))
{
session_start();


include("pathToGlobalVariables.php");
include($pathToGlobalVariables);

$connPath = relativePath(getcwd(),$conn_php);
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
          <li><a href="comparisons_new.php">Comparisons</a></li>
        </ul>
        </li>
                <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Documentation
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="active"><a href="../Documentation.html">About MetRxn</a></li>
        </ul>
        </li>
        <li><a href="mailto:costas@psu.edu">Contact</a></li>
        <li><a href="../MetRxntest.php">Login</a></li>
        <li><a href="http://www.maranasgroup.com">Maranas Group</a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="padding: 80px">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
		<?php
			function getInfo($con)
			{           
			        include($con);
						connect();
			        $result = mysql_query("select source,linkout from `metrxn`.`source` where sourceType = 'Metabolic model' order by source;");
				
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
</div></div></div></div>


<!--footer begin-->
<footer class="footer">
    <div class="container-fluid bg-footer">
      <div class="row">
        <div class="col-md-3 col-md-offset-3">
            <p id="footer-title">Costas D. Maranas' office</p>
            <span class="glyphicon glyphicon-map-marker"></span>
            112 Fenske Laboratory<br>
            University Park, PA 16802<br>
            <span class="glyphicon glyphicon-envelope"></span><a href="mailto:costas@psu.edu"> costas@psu.edu</a><br>
            <span class="glyphicon glyphicon-phone"></span> 814.863.9958<br>
            <span class="fa fa-fax"></span> 814.865.7846
<!--             <img class ="img-header" src="images/powered_100px.gif" usemap="#headermap" height="100%" width="100%" border="0"> -->
        </div>
        <div class="col-md-3">
            <p id="footer-title">Group offices</p>
            147A Fenske Lab – <span class="glyphicon glyphicon-phone"></span> 814.863.1689<br>
            147B Fenske Lab  – <span class="glyphicon glyphicon-phone"></span> 814.863.3385<br>
            149 Fenske Lab –  <span class="glyphicon glyphicon-phone"></span> 814.863.4806
<!--             <img class ="img-header" src="images/DOE_SC Horizontal.jpg" usemap="#headermap" height="100%" width="100%" border="0"> -->
        </div>
      </div>
    </div>
</footer>
<!--footer end-->
</body>
</html>