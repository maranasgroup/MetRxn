<?php
if (!isset($_SESSION)) {
    session_start();
    include ("conn.php");
    connect();
    include ("pathToGlobalVariables.php");
    include ($pathToGlobalVariables);
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
  <link href="css/labwebsite.css" rel="stylesheet"></link>
  <style>
    .container { padding: 0px !important;}

  </style>
</head>

<body>

<!--navigation-->
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
        <li class="active"><a href="MetRxntest.php"><i class="fa fa-home"></i></a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="browse/BrowseByOrganism_new.php">Organism</a></li>
          <li><a href="browse/comparisons_new.php">Comparisons</a></li>
        </ul>
        </li>
                <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Documentation
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="./Documentation.html">About MetRxn</a></li>
        </ul>
        </li>
        <li><a href="mailto:costas@psu.edu">Contact</a></li>
        <li><a href="MetRxntest.php">Login</a></li>
        <li><a href="http://www.maranasgroup.com">Maranas Group</a></li>
      </ul>
    </div>
  </div>
</nav>
<!--navigation end-->

<!--banner-->
<!-- <div id="researchbanner">
<img class ="img-header" src="./top.jpg" usemap="#headermap" height="100%" width="100%" border="0">
</div> -->
<!--banner end-->

<!--banner end-->
<?php
$query = "Select count(distinct idStr) cnt from `metrxn`.`abbrsynstrsrcview` where type = 'metabolites'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    $metaboliteCount = $row['cnt'];
    // echo $metaboliteCount;
}

$query = "Select max(date) `date` from `metrxn`.`source_pin`";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    $lastUpdateDate = "2013-09-28";
}

$query = "select count(distinct reactionAsCd_id) cnt from metrxn.reaction where reactionAsCd_id is not null";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    $reactionCount = $row['cnt'];
}

$query = "Select count(*) cnt from `metrxn`.`source_pin` where Sourcetype = 'metabolic Model'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    $metabolicModelCount = $row['cnt'];
}

$query = "Select count(*) cnt from `metrxn`.`source_pin` where Sourcetype = 'database'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    $databaseCount = $row['cnt'];
}
?>
<div style="padding: 80px">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1 style="text-align:center">
        Welcome to MetRxn 
        </h1>
        <p style="text-align:center">MetRxn is a comprehensive collection of consistent metabolite and reaction entities for use in metabolic analysis and model construction.  MetRxn's current <?php echo $metaboliteCount; ?> uniquely resolved metabolites and <?php echo $reactionCount; ?> uniquely resolved reactions incorporates data from <a href="statistics/dataSourceDatabase_new.php"><?php echo $databaseCount; ?></a> different metabolic databases and <a href="statistics/dataSourceMetabolicModels_new.php" target="_parent"><?php echo $metabolicModelCount?></a> genome-scale metabolic models.</p>
    </div>
  </div>
  <div class="row" id="search_height">
    <div class="col-md-10 col-md-offset-1" align="center">
        <iframe id="iframeBox" src="search_box/search_new.php" width="900px" scrolling="no" style="visibility:visible;max-height:2000px" align="middle" frameBorder="0">
        </iframe>
    </div>
   </div>
   <div class="row" id="search_dismiss_1">
        <div class="col-md-5 col-md-offset-1">
            <h2 class="howto">Getting Started</h2>
            <ul>
            <li>
            <a href="Documentation.html">Documentation</a>: Quick start guide to the core features of MetRxn</li>
            <li>
            <a href="browse/comparisons_new.php">Comparisons</a>: Compare reactions and metabolites across various organisms</li>
            <li>
            <a href="browse/BrowseByOrganism_new.php">Browse organisms</a>: View all the reactions and metabolites in each organism and export this data in SBML</li>
            <!--li>
            <a href="">Submissions</a>: Submit data to MetRxn</li-->
            </ul>
        </div>
        <div class="col-md-5">
            <img class ="img-header" src="images/metrxn_webpage_graphic.png" usemap="#headermap" height="100%" width="100%" border="0">
        </div>
   </div>
</div>
</div>
<div>
    <div class="container-fluid" id="search_dismiss_2">

      <div class="row">
        <div class="col-md-3 col-md-offset-3">
            <p>Supported By</p>
          <img class ="img-header" src="images/DOE_SC Horizontal.jpg" usemap="#headermap" height="100%" width="80%" border="0">
        </div>
        <div class="col-md-3">
            <img class ="img-header" src="images/powered_100px.gif" usemap="#headermap" height="100%" width="40%" border="0">
        </div>

      </div>
    </div>
</div>
<!--footer begin-->
<footer class="footer">
    <div class="container-fluid bg-footer">
    <p></p>
      <div class="row">
        <div class="col-md-3 col-md-offset-3">
            <p id="footer-title">Costas D. Maranas' office</p>
            <span class="glyphicon glyphicon-map-marker"></span>
            112 Fenske Laboratory<br>
            University Park, PA 16802<br>
            <span class="glyphicon glyphicon-envelope"></span><a href="mailto:costas@psu.edu"> costas@psu.edu</a><br>
            <span class="glyphicon glyphicon-phone"></span> 814.863.9958<br>
            <span class="fa fa-fax"></span> 814.865.7846
        </div>
        <div class="col-md-3">
            <p id="footer-title">Group offices</p>
            147A Fenske Lab – <span class="glyphicon glyphicon-phone"></span> 814.863.1689<br>
            147B Fenske Lab  – <span class="glyphicon glyphicon-phone"></span> 814.863.3385<br>
            149 Fenske Lab –  <span class="glyphicon glyphicon-phone"></span> 814.863.4806
        </div>
      </div>
    </div>
</footer>
<!--footer end-->

</body>

</html>