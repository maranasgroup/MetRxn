<?php 
if(!isset($_SESSION))
{
session_start();
include("conn.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Login</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="../metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="../anchors.css" rel="stylesheet" type="text/css" />
	<link href="../headings.css" rel="stylesheet" type="text/css" />
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