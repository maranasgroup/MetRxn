<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Advanced Search</title>
<style type="text/css">
	.header {

		width:100%;
		top:0;
		border:none;


	}
	.footer {
		
		bottom:0;
		position:absolute;
		width:100%;
		clear:both;
	}
	.content {
		
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
<?php
if ($_SESSION['username']) {
}
else {
	die("Please login to view the page");
}
?>
<div>
<h1> Advanced Search </h1>
<table>
<tr>
<td>
Search by Enzyme
</td>
<td> 			<input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
				 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">
</td>                            
</tr>

<tr>                 
<td>
Search by Organism
</td>
<td> 			<input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
				 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">
</td>                            
</tr>
<tr>
<td>                            
Search by Database 			</td><td><input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
				 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">
</td>                            
</tr>
<tr>
<td>                            
Search by gene Name	</td><td><input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
			 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">                                                   
</td>                            
</tr>
<tr>
<td>                            
Search by reaction Name	</td><td><input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
			 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">                                                   
</td>                            
</tr>
<tr>
<td>                            
Search by Pathway	</td><td><input type="text" name="enzyme" size=50 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
			 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">                                                   
</td>                            
</tr>                            
<tr>
<td>                            
Search by Molecular weight 	</td><td><input type="text" name="enzyme" size=24 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
						  	<input type="text" name="enzyme" size=24 maxlength="100" onKeyUp="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
				 			<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">                                                   
</td>                            
</tr>
</table>
</div>
<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>
                 
</body>

</html>