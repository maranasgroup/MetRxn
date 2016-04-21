<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
pre {text-indent: 30px}
#tabmenu { color: #000; border-bottom: 1px solid black; margin: 12px 0px 0px 0px; padding: 0px; z-index: 1; padding-left: 10px }
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
#content a:hover { background: #aaaaaa; }
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

<script src="../Jmol-12.0.25-binary/jmol-12.0.25/Jmol.js" type="application/javascript">
</script>
<script language="JavaScript" type="application/javascript">

function callAHAH(url, pageElement, callMessage, errorMessage) {
     document.getElementById(pageElement).innerHTML = callMessage;
     try {
     req = new XMLHttpRequest(); /* e.g. Firefox */
     } catch(e) {
       try {
       req = new ActiveXObject("Msxml2.XMLHTTP");  /* some versions IE */
       } catch (e) {
         try {
         req = new ActiveXObject("Microsoft.XMLHTTP");  /* some versions IE */
         } catch (E) {
          req = false;
         } 
       } 
     }
     req.onreadystatechange = function() {responseAHAH(pageElement, errorMessage);};
     req.open("GET",url,true);
     req.send(null);
	 //showStructure(1);
  }

function responseAHAH(pageElement, errorMessage) {
   var output = '';
   if(req.readyState == 4) {
      if(req.status == 200) {
         output = req.responseText;
         document.getElementById(pageElement).innerHTML = output;
         } else {
         document.getElementById(pageElement).innerHTML = errorMessage+"\n"+output;
         }
      }
  }
function showStructure(tab)
{
	
	jmolInitialize("../Jmol-12.0.25-binary/jmol-12.0.25");
	jmolSetAppletColor("#FFFFFF");
	jmolApplet(300,"load ../Jmol-12.0.25-binary/models/"+tab+".mol; cpk 0.6; spin on; label %e; set labelalignment center; axes; set spin x 15; set spin y 5; set spin z 5; zoom 110;");
	
}  
function makeactive(tab) 
{
<?php
           $var = $_GET["searchString"];
		   $var = 'amp';		   
           $con = mysql_connect("localhost","root","");
        if (!$con)
           {
            die('Could not connect: '. mysql_error());
           }
/* in the while loop, each iteration will disable the tab and div */
$result = mysql_query("SELECT SYNONYM syn,idStructures id,count(distinct sourceName) cnt FROM `biodb4`.`metabolitesynonyms` where synonym = '$var' and idStructures is not null group by SYNONYM,idStructures order by cnt desc;");
while($row = mysql_fetch_array($result))
            {
				echo "document.getElementById(\"tab".$row['id']."\").className = \"\";\n";
				echo "document.getElementById(\"image".$row['id']."\").className = \"hide\";\n";
				
            }
?>
document.getElementById("tab"+tab).className = "active";
document.getElementById("image"+tab).className = "show";
<?php
/*echo "callAHAH('content.php?searchString=".$var."&id='+tab, 'content', 'getting content for tab '+tab+'. Wait...', 'Error');";*/
?>

}
</script>

</head>

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar">
	<?php include('../left_data/leftMenu.htm'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<div>
<ul id="tabmenu" >
<?php
$result = mysql_query("SELECT SYNONYM syn,idStructures id,count(distinct sourceName) cnt FROM `biodb4`.`metabolitesynonyms` where synonym = '$var' and idStructures is not null group by SYNONYM,idStructures order by cnt desc;");
$count = 1;
while($row = mysql_fetch_array($result))
{
	if($count ==1)
	{
	echo "<body onload=\"makeactive(".$row['id'].")\">";
	}	
	$count = $count + 1;
	echo "<li onclick=\"makeactive(".$row['id'].")\"><a class=\"\" id=\"tab".$row['id']."\">".$row['syn']."</a></li>\n";
}
?>
</ul> 
<?php
$result = mysql_query("SELECT SYNONYM syn,idStructures id,count(distinct sourceName) cnt FROM `biodb4`.`metabolitesynonyms` where synonym = '$var' and idStructures is not null group by SYNONYM,idStructures order by cnt desc;");
while($row = mysql_fetch_array($result))
{
echo "<div class=\"hide\" id=\"image".$row['id']."\">\n";	
echo "<script type=\"application/javascript\">\n";
echo "showStructure(".$row['id'].");\n";
$id = $row['id'];
echo "</script>\n";
$result2 = mysql_query("SELECT A.Smiles smiles,trim(Group_concat(distinct concat(' ',B.sourceName))) src FROM `udb`.`structures` A, `biodb4`.`metabolitesynonyms` B where A.idStructures = B.idStructures and A.idStructures = $id and B.synonym = '$var' group by A.Smiles;");
 echo "<table border=1>
            <tr bgcolor=#C4D8F1>
            <th>Source</th>
            <th>SMILES</th>
            </tr>";
while($row2 = mysql_fetch_array($result2))
            {
                echo "<tr>";
                echo "<td>" . $row2['src'] . "</td>";
                echo "<td>" . $row2['smiles'] . "</td>";
                echo "</tr>";
            }
echo "</table>";
$result2 = mysql_query("select distinct B.SourceName src, trim(group_concat(distinct concat(' ',B.synonym))) syn,count(distinct B.synonym) cnt from `biodb4`.`metabolitesynonyms` A, `biodb4`.`metabolitesynonyms` B where A.synonym = '$var' and A.idStructures = B.idStructures and A.idStructures = '$id' group by B.sourceName");						
echo "<table border=1>
        <tr bgcolor=#C4D8F1>
        <th>Source</th>
        <th>Synonyms</th>
        </tr>";
while($row2 = mysql_fetch_array($result2))
          {
          echo "<tr>";
          echo "<td>" . $row2['src'] ."<font color:blue>"."(".$row2['cnt'].")"."</font>"."</td>";
          echo "<td>" . $row2['syn'] . "</td>";
          echo "</tr>";
          }
echo "</table>";

$result2 = mysql_query("select src, trim(group_concat(distinct concat(' ',rxn))) rxn,count(distinct rxn) cnt from (SELECT A.sourceName src,A.reaction rxn FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat('%','.',B.idStructures,'.','%')  and B. synonym = '$var' and A.sourceName = B.sourceName union SELECT A.sourceName,A.reaction  FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat('%','.',B.idStructures,'>>','%')  and B. synonym = '$var' and A.sourceName = B.sourceName union SELECT A.sourceName,A.reaction  FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat(B.idStructures,'.','%')  and B. synonym = '$var' and A.sourceName = B.sourceName union SELECT A.sourceName,A.reaction  FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat('%','>>',B.idStructures,'.','%')  and B. synonym = '$var' and A.sourceName = B.sourceName union SELECT A.sourceName,A.reaction  FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat('%','.',B.idStructures)  and B. synonym = '$var' and A.sourceName = B.sourceName union SELECT A.sourceName,A.reaction  FROM  `biodb4`.`allreactions` A,`biodb4`.`metabolitesynonyms` B  where  A.reactionStructureId like concat('%','>>',B.idStructures)  and B. synonym = '$var' and A.sourceName = B.sourceName) A group by src");		

		echo "<table border=1>
		<tr bgcolor=#C4D8F1>
		<th>Source</th>
		<th>Participating reactions</th>
		</tr>";

		while($row2 = mysql_fetch_array($result2))
		  {
		  echo "<tr>";
		  echo "<td>" . $row2['src'] ."(".$row2['cnt'].")". "</td>";
		  echo "<td>".$row2['rxn'] ." <a href=../browse/reactions.php target=_blank>more . . . </a>". "</td>";
		  echo "</tr>";
		  }
		echo "</table>";
		
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