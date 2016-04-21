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
		position:absolute;
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
<table width="100%">
<tr>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
</tr>
<tr>
<td>

</td>
<td align=center>
<font size=5>MetRxn is currently down for scheduled maintenance, please visit us back on 14/12/2011</font> 
</td>
<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>
</tr>
</table>