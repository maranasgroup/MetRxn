<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showResult(str)
{
if (str.length==0)
  {
  document.getElementById("livesearch").innerHTML="";
  document.getElementById("livesearch").style.border="0px";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
    document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
xmlhttp.open("GET","livesearch.php?q="+str,true);
xmlhttp.send();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	
	<link href="/MetRxn/metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="/MetRxn/anchors.css" rel="stylesheet" type="text/css" />
	<link href="/MetRxn/headings.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	color: #3032a1;
}
</style>
</head>

<body>
<div align="center">
<form action="/MetRxn/searchResults/results.php" method="get" target="_parent" >
	                <p>&nbsp;                    </p>
	                <p>
                    
                    
                    
                    <input type="text" name="searchString" size=50 maxlength="100" onkeyup="showResult(this.value)" align="left" title="Enter your search keywords here eg. oxygen.">
					<input type="submit" alt="Search Button" title="Search MetRxn" value="Search MetRxn">
					<a href="javascript:windowOpenWithSize('/MetRxn/userManualForward.do?printerFriendlyView=true#quickSearch', 600, 500)" title="Go the MetRxn help pages to learn more about 'Quick Search'."><!--
						Help
--></a>

					<br/><br/>

					<a href="/MetRxn/AdvancedSearch/advancedSearch.php" target="_parent">Advanced Search</a> |
					<a href="/MetRxn/aboutMetRxnForward.do">About MetRxn</a>

<br/>
					<br/>
	                </p>
</form>
</div>
</body>
</html>