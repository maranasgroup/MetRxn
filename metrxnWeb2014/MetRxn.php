<?php
if (!isset($_SESSION)) {
	session_start();
	include ("conn.php");
	connect();
	include ("pathToGlobalVariables.php");
	include ($pathToGlobalVariables);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!-- InstanceBegin template="/Templates/new_template_no_menus.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="description" content="Reaction/Metabolite Standardization and Congruency Across Databases and Genome-Scale Metabolic Models"/>
   <meta name="author" content="PSU Web Team" />
   <meta name="keywords" content="chemical compounds, costas maranas,chemical compound,metabolic,Optknock,compound, ontology, biology, UniProt, ascii name, names, nomenclature, chemical, formula, IUPAC, IUPAC name, synonyms, chemical ontology, periodic table, MetRxn, Genome Scale Metabolic Model, Flux Balance"/>
   <meta http-equiv="Content-Language" content="en" />
   <meta http-equiv="Window-target" content="_top" />
   <meta name="no-email-collection" content="http://www.unspam.com/noemailcollection/" />
   <meta name="generator" content="Dreamweaver 8" />
   <meta name="language" content="en"/>
   <meta name="revisit-after" content="14 days"/>
<!-- InstanceBeginEditable name="doctitle" -->
   <title>
    MetRxn Home
	</title>
   	<!-- <link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" /> -->
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="<?php echo relativePath(getcwd(), $metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(), $anchors_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(), $headings_css); ?>" rel="stylesheet" type="text/css" />
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
	iframe {
			border: 0;
	}
	.center-block {float: none !important}
	</style>
</head>

<body>
<!-- <table id="main_table">
<tr> -->
<div class="container-fluid">
<div class="row">
    <iframe src="<?php echo relativePath(getcwd(), $top_data_htm); ?>" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<!-- </tr> -->
<!-- <tr> -->
<div class="row">
<div class="col-md-2 sidebar">	
   	<iframe src="<?php echo relativePath(getcwd(), $left_Menu_php); ?>" height="450" scrolling="no">
    </iframe>
</div>
<!-- <td> -->
<!-- <div style="width:100%" align="center"> -->

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
<!--?php include('/main_data/main.php'); ?-->
<div class="col-md-10">
    <div id="intro" style="width:900px" align="center">
        <h1>
                    Welcome to MetRxn <font size=2>(Last updated on <?php echo $lastUpdateDate ?>)</font>, <font size=2 color = 'red'>version 2.0 will be made available by July 2014 </font>
        </h1>
        <p>MetRxn is a comprehensive collection of consistent metabolite and reaction entities for use in metabolic analysis and model construction.  MetRxn's current <?php echo $metaboliteCount; ?> uniquely resolved metabolites and <?php echo $reactionCount; ?> uniquely resolved reactions incorporates data from <a href="<?php echo relativePath(getcwd(), $dataSourceDatabase_php); ?>" target="_parent"><?php echo $databaseCount; ?></a> different metabolic databases and <a href="<?php echo relativePath(getcwd(), $dataSourceMetabolicModels_php); ?>" target="_parent"><?php echo $metabolicModelCount?></a> genome-scale metabolic models.</p>
    </div>

    <div id="searchbox" align="left">
        <iframe id="iframeBox" src="<?php echo relativePath(getcwd(), $search_php); ?>" width="900px" scrolling="no" style="visibility:visible;max-height:2000px">
        </iframe>
    </div>

    <div id="main">
        <iframe src="<?php echo relativePath(getcwd(), $main_php); ?>" width="100%" height="500px" scrolling="no">
        </iframe>
    </div>

	<div id="footer">
    <iframe src="<?php echo relativePath(getcwd(), $footer_php); ?>" height="60" width="100%" scrolling="no">
    </iframe>
    </div>
</div>
</div>
</div>
</body>
<!-- InstanceEnd -->

</html>

