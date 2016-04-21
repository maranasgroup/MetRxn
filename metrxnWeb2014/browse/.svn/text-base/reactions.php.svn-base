<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Results</title>
<style type="text/css">
pre {text-indent: 30px}
#tabmenu { color: #000; margin: 12px 0px 0px 0px; padding: 0px; padding-left: 10px; azimuth:far-right}
#tabmenu li { display: inline; overflow: hidden; list-style-type: none; }
#tabmenu a, a.active {
	color: #000;
	background: #C4D8F1;
	border: 1px solid black;
	padding: 2px 5px 0px 5px;
	margin: 0px;
	text-decoration: none;
	cursor:hand;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#tabmenu a.active {
	background: #ffffff;
	border-bottom-color:#FFF;	
}
#tabmenu a:hover { color: #fff; background: #ADC09F; }
#tabmenu a:visited { color: #E8E9BE; }
#tabmenu a.active:hover { background: #ffffff; color: #DEDECF; }
#content {
	text-align: justify;
	background: #ffffff;
	padding: 20px;
	border-top: none;
	z-index: 2;
	float:left;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#content a { text-decoration: none; color: #E8E9BE; }
#content a:hover { background: #aaaaaa;}
#result a:hover { background: #aaaaaa; font-size:16px;text-decoration:overline}
#result a {text-decoration:none; color:#000}
.hide {
	display:none;

	
	
}
.show{
	display:!important;
	
}
table
	{
	border-collapse:collapse;
	margin:20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	overflow:scroll;
	}
.footer {
		position:relative;
		bottom:0;
		width:100%;
	}
iframe{
		border:0;
	}
	
.leftbar{
		float:left;
		width:20%;
		position:relative;
		
		}
	.header {

		width:100%;
		top:0;
		border:none;


	}				
</style>
<script language="JavaScript" type="application/javascript">
function makeactive(tab) 
{	
<?php
              	   
           $con = mysql_connect("localhost","root","");
        if (!$con)
           {
            die('Could not connect: '. mysql_error());
           }
/* in the while loop, each iteration will disable the tab and div */
$result = mysql_query("SELECT distinct @rownum:=@rownum +1 num, sourceNAme FROM (select distinct sourceName from `InterMediate`.`SynonymIdStructuresAbbr` order by sourceName) A,(SELECT @rownum:=0) B;");
while($row = mysql_fetch_array($result))
            {
				echo "document.getElementById(\"tab".$row['num']."\").className = \"\";\n";
				echo "document.getElementById(\"result".$row['num']."\").className = \"hide\";\n";
				
            }
?>
document.getElementById("tab"+tab).className = "active";
document.getElementById("result"+tab).className = "show";
}
</script>

</head>

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar"">
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
<div id="tabmenu">
<ul>
<?php
$result = mysql_query("SELECT distinct @rownum:=@rownum +1 num, sourceNAme FROM (select distinct sourceName from `InterMediate`.`SynonymIdStructuresAbbr` order by sourceName) A,(SELECT @rownum:=0) B;");
$count = 1;
while($row = mysql_fetch_array($result))
{
	if($count ==1)
	{
	echo "<body onload=\"makeactive(".$row['num'].")\">";
	}	
	$count = $count + 1;
	echo "<li onclick=\"makeactive(".$row['num'].")\"><a class=\"\" id=\"tab".$row['num']."\">".$row['sourceNAme']."</a></li>\n";
}
?>
</ul>
</div>
<div id="result">  
<?php
$result = mysql_query("SELECT distinct @rownum:=@rownum +1 num, sourceNAme FROM (select distinct sourceName from `InterMediate`.`SynonymIdStructuresAbbr` order by sourceName) A,(SELECT @rownum:=0) B;");
while($row = mysql_fetch_array($result))
{
echo "<div class=\"show\" id=\"result".$row['num']."\">\n";	
$result2 = mysql_query("SELECT FunctionalCategory,trim(Group_concat(distinct concat('<a href=../workbench/workbench.php?searchString=',ModelReactions,'&source=',replace(sourceName,' ','&#32;'),' target=_parent>',equation,'</a>'))) eq FROM `BioDb4`.`ModelReactions` WHERE sourceName = '".$row['sourceNAme']."' AND FunctionalCategory IS NOT NULL GROUP BY FunctionalCategory");
 echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Functional Category</th>
            <th>Reactions(".$row['sourceNAme'].")</th>
            </tr>";
while($row2 = mysql_fetch_array($result2))
            {
                echo "<tr>";
                echo "<td>" . $row2['FunctionalCategory'] . "</td>";
                echo "<td>" . $row2['eq'] . "</td>";
                echo "</tr>\n";
            }
echo "</table>\n";		
echo "</div>\n";
}
mysql_close($con);
?>
</div>
<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>
</body>
</html>