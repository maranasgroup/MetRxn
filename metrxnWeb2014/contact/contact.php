<?php 
session_start(); 
include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documentation</title>
   	<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="<?php echo relativePath(getcwd(),$metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$anchors_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$headings_css); ?>" rel="stylesheet" type="text/css" />

<style type="text/css">
a:link {
	color: #3032A1;
}
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
<table>
<tr>
<div class="header">
    <iframe src="<?php echo relativePath(getcwd(),$top_data_htm);?>" width="100%" height="160" scrolling="no">
    </iframe>
</div>
</tr>
<tr>
<div class="leftbar">	
   	<iframe src="<?php echo relativePath(getcwd(),$left_Menu_php); ?>" height="450" scrolling="no">
    </iframe>
</div>
<td>
<img src="maranas.jpg" height = "200"/>
<p>
Costas D. Maranas - email: <a href="mailto:costas@engr.psu.edu">costas@engr.psu.edu</a> 
<br />
PhD, Chemical Engineering, Princeton University, 1995
</p>
</td>
<td width="30">
</td>
<td>
<img src="suthers.jpg"  height = "200"/>
<p>
Patrick Suthers - email: <a href="mailto:pfs13@psu.edu">pfs13@psu.edu</a>
<br />
PhD, Chemical Engineering, University of Wisconsin, 2005
</p>
</td>
<td width="30">
</td>
<td>
<img src="akhil.png"  height = "200"/>
<p>
Akhil Kumar - email: <a href="mailto:azk172@psu.edu">azk172@psu.edu</a>
<br />
Graduate Student, Huck Institutes of the Life Sciences, Pennsylvania State University
</p>
</td>
</tr>
</table>
</body>
</html>
