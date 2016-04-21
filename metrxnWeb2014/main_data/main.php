<?php
include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome Page</title>
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
<link href="<?php echo relativePath(getcwd(),$metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo relativePath(getcwd(),$anchors_css); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo relativePath(getcwd(),$headings_css); ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	color: #3032A1;
}
img {
	min-width: 600px;	
}
iframe{
	
		border:0;
		z-index:10;		
	}
</style>
</head>

<body>

<!--<h1>
      		Welcome to MetRxn
</h1>
<p>MetRxn is a comprehensive collection of consistent metabolite and reaction entities for use in metabolic analysis and model construction.  MetRxn's current <a href="/MetRxn/browse/AE.php" target="_parent">62,345</a> unique metabolites and <a href="../browse/reactions.php" target="_parent">56142</a> unique reactions incorporates data from <a href="../statistics/dataSourceDatabase.php " target="_parent">6</a> different metabolic databases and <a href="../statistics/dataSourceMetabolicModels.php" target="_parent">32</a> genome-scale metabolic models.</p>
-->
<!--<div>
<table align="center">
<iframe src="../search_box/search.php" width="100%" scrolling="no" style="max-height:500px">
</iframe>
</table>
</div>-->

<div style="z-index:1">
<table align="center">
  <tr>
    <td align="left"><h2 class="howto">Getting Started</h2>
<ul>
<li>
<a href="<?php echo relativePath(getcwd(),$Documentation_php); ?>" target="_parent">Documentation</a>: Quick start guide to the core features of MetRxn</li>
<li>
<a href="<?php echo relativePath(getcwd(),$comparisions_php); ?>" target="_parent">Comparisons</a>: Compare reactions and metabolites across various organisms</li>
<li>
<a href="<?php echo relativePath(getcwd(),$BrowseByOrganism_php); ?>" target="_parent">Browse organisms</a>: View all the reactions and metabolites in each organism and export this data in SBML</li>
<!--li>
<a href="">Submissions</a>: Submit data to MetRxn</li-->
</ul></td>
    <td align="center"><p><img name="MainImage" src="<?php echo relativePath(getcwd(),$metrxn_webpage_graphic_png); ?>" width="20%" alt="" style="background-color: #FFFFFF" align="left"/></p></td>
  </tr>
</table>
</div>
</body>
</html>