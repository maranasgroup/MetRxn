<?php 
if(!isset($_SESSION))
{
session_start();
include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title></title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
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

<?php
if(!isset($_SESSION))
{
session_start();

}
session_destroy();
$indexPath = relativePath(getcwd(),$index_php);
echo "you have been logged out, click here to return <a href = '$indexPath' target = '_parent'> return </a>"
?>

</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>

