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
<title>Login</title>
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
<?php
connect();
$username = $_POST['username'];
$password = $_POST['password'];
$metrxnHomePath = relativePath(getcwd(),$MetRxn_php);
if ($username) {
	if ($password) {
		/*$connect = mysql_connect("localhost","root","") or die("could not connect to the db");*/
		/*mysql_select_db("metrxnweb") or die ("could not find this db");*/
		$query = mysql_query("SELECT * FROM metrxnweb.login where username = '".$username."'");
		$numrows = mysql_num_rows($query);
		if ($numrows) {

			while ($row = mysql_fetch_assoc($query)) {
				$dbpassword = $row['password'];
				$dbusername = $row['username'];
				$active = $row['active'];

				if ($active =='0') {
					die("The user is not active, please check your mail to activate your login. Click here to send your activation link again <a href=resendActivationLink.php>Activate</a>");
				}

				if ($dbpassword == $password&&$dbusername == $username) {
					echo "you have logged in successfully and a session has been established";
					$_SESSION['username'] = $dbusername;
					echo "<a href = '$metrxnHomePath'> click here <a> ".$_SESSION['username'];
				}
				else {
					die("the password is wrong ").$dbpassword;
				}
			}
		}
		else {
			die("invalid username");
		}
	}
	else{
		die("please enter a password");
	}

}
else
{
	die("please enter a userName");
}
?>
</td>
</tr>
</table>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>

