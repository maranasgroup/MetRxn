<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Upload</title>
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

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar">
	<?php include('../left_data/leftMenu.php'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<br />

<!--<p><label for="file">Select a file:</label> <input type="file"
name="userfile" id="file"> <br />
Input source/Organism <input type="text" name="sourceNAme" />
<br /> 
<button>Upload File</button>
<p>
</form>-->

<table>
<tr>
<td>
<div class="GetToken">

<form action="" method="post" enctype="multipart/form-data">
<table title="Please enter the details below to generate a token">
<tr>
<td>
Enter the Organism Name: </td><td><input type="text" name="oname" />
</td>
</tr>
<tr>
<td>
Enter the url: </td><td><input type="text" name="url" />
</td>
</tr>
<tr>
<td>
Enter the pubmed Id: </td><td><input type="text" name="pubmed" />
</td>
</tr>
<tr>
<td>
Select the data source type: </td><td>
<select name="sourceType">
<option value="Metabolic model">Metabolic model</option>
<option value="database">Database</option>
</select>
</td>
</tr>

<tr>
<td>
Select the uploadfile: </td><td><input type="file" name="userfile" />
</td>
</tr>

<tr>
<td>
</td><td><input type="submit" value="submit"/>
</td>
</tr>
</form>
</div>
</td>
</tr>
<tr>
<td>
<div class="producedToken">
<?php
if($_POST['submit'] == 'submit'){	
include('../conn.php');
$upload_path = 'files/';
if(!is_writable($upload_path))
 {
 	die('You cannot upload to the specified directory');
 }
$filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).

$tmpfileName = $_FILES['userfile']['tmp_name'];

if(move_uploaded_file($tmpfileName,$upload_path . $filename))
         echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
      else
         echo 'There was an error during the file upload.  Please try again.';  
}
		 
?>
</div>
</td>
</tr>
<tr>
<td>
<div class="uploadFile">
</div>
</td>
</tr>
</table>

</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd -->
</html>

