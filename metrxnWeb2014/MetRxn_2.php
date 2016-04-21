<?php if(!isset($_SESSION))
{
session_start();
include("conn.php");
connect();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!-- InstanceBegin template="/Templates/new_template_no_menus.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="description" content="Reaction/Metabolite Standardization and Congruency Across Databases and Genome-Scale Metabolic Models"/>
   <meta name="author" content="PSU Web Team" />
   <meta name="keywords" content="chemical compounds, chemical compound, compound, ontology, biology, UniProt, ascii name, names, nomenclature, chemical, formula, IUPAC, IUPAC name, synonyms, chemical ontology, periodic table"/>
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
<!--frameset rows="155,*,60" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="top_data/top.htm" name="topFrame" noresize="noresize" scrolling="NO">
  <frameset rows="*" cols="160,*" framespacing="0" frameborder="no" border="0">
    <frame src="left_data/leftMenu.htm" name="leftFrame" noresize="noresize" scrolling="NO">
    
    <frameset rows="*,*" cols="*" framespacing="0" frameborder="no" border="0" >
    	<frame src="main_data/main.php" name="mainFrame">
        <frame src="search_box/search.php" name="searchFrame">
	 </frameset>
  </frameset>
<frame src="footer_data/footer.html" name="footerFrame">
</frameset>

<noframes>
</noframes-->
<body>
<table>
<tr>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
</tr>
<tr>
<td>
<div class="leftbar">
	<?php include('left_data/leftMenu.php'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
</td>
<td>
<div class="content" align="center">
<div style="width:100%" align="center">
<?php
$query = "Select count(distinct idStr) cnt from `metrxn`.`abbrsynstrsrcview` where type = 'metabolites'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$metaboliteCount = $row['cnt'];
}

$query = "Select max(date) `date` from `metrxn`.`source_pin`";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$lastUpdateDate = $row['date'];
}

$query = "select count(distinct reactionAsCd_id) cnt from metrxn.reaction where reactionAsCd_id is not null";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$reactionCount = $row['cnt'];
}

$query = "Select count(*) cnt from `metrxn`.`source_pin` where Sourcetype = 'metabolic Model'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$metabolicModelCount = $row['cnt'];
}

$query = "Select count(*) cnt from `metrxn`.`source_pin` where Sourcetype = 'database'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$databaseCount = $row['cnt'];
}
                        

?>
<!--?php include('/main_data/main.php'); ?-->
    <div align="left" style="width:700px">
        <h1>
                    Welcome to MetRxn <font size=2>(Last updated on <?php echo $lastUpdateDate ?>)</font>
        </h1>
        <p>MetRxn is a comprehensive collection of consistent metabolite and reaction entities for use in metabolic analysis and model construction.  MetRxn's current <?php echo $metaboliteCount; ?> uniquely resolved metabolites and <?php echo $reactionCount;?> uniquely resolved reactions incorporates data from <a href="statistics/dataSourceDatabase.php " target="_parent"><?php echo $databaseCount;?></a> different metabolic databases and <a href="statistics/dataSourceMetabolicModels.php" target="_parent"><?php echo $metabolicModelCount?></a> genome-scale metabolic models.</p>
    </div>

    <div>
        <iframe src="search_box/search.php" width="100%" scrolling="no" style="visibility:visible;max-height:600px">
        </iframe>
    </div>

    <div>
        <iframe src="main_data/main.php" width="100%" height="500px" scrolling="no">
        </iframe>
    </div>
</div>
</div>    
</td>
</tr>

</table>

<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>

</body>
<!-- InstanceEnd -->

</html>

