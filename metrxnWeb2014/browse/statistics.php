<?php if(!isset($_SESSION))
{
session_start();
if (isset($_SESSION['username'])) {
	include("..\conn.php");
	connect();
	set_time_limit (300);
}
else {
	die("Please login to view the page");
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MetRxn Statistics</title>
</head>
<style type="text/css">
pre {
	text-indent: 30px
}
#tabmenu {
	color: #000;
	margin: 12px 0px 0px 0px;
	padding: 0px;
	z-index: 1;
	padding-left: 10px
}
#tabmenu li {
	display: inline;
	overflow: hidden;
	list-style-type: none;
}
#tabmenu a, a.active {
	color: #000;
	background: #C4D8F1;
	border: 1px solid black;
	padding: 2px 5px 0px 5px;
	margin: 0px;
	text-decoration: none;
	cursor: hand;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#tabmenu a.active {
	background: #ffffff;
	border-bottom-color: #FFF;
}
#tabmenu a:hover {
	color: #fff;
	background: #ADC09F;
}
#tabmenu a:visited {
	color: #E8E9BE;
}
#tabmenu a.active:hover {
	background: #ffffff;
	color: #DEDECF;
}
#content {
	text-align: justify;
	background: #ffffff;
	padding: 20px;
	border-top: none;
	z-index: 2;
	float: left;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#content a {
	text-decoration: none;
	color: #E8E9BE;
}
#content a:hover {
	background: #aaaaaa;
}
#result a:hover {
	background: #aaaaaa;
	font-size: 16px;
	text-decoration: overline
}
#result a {
	text-decoration: none;
	color: #000
}
.hide {
	display: none;
}
.show {
 display:!important;
}
table {
	border-collapse: collapse;
	margin: 20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
.footer {
	position: relative;
	bottom: 0;
	width: 100%;
}
iframe {
	border: 0;
}
.leftbar {
	float: left;
	width: 20%;
	position: relative;
}
.header {
	width: 100%;
	top: 0;
	border: none;
}
</style>
<body>
<div class="header"><!---This div contains the top header--->
  <iframe
                src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no"> </iframe>
</div>
<div class="leftbar"
             style="opacity: 1; filter: alpha(opacity =100)">
<!---This div contains the left menu--->
<?php include('../left_data/leftMenu.php'); ?>
</div>
<div>
  <table width="100%">
    <tr>
      <table border="1">
          <th width="200" bgcolor="#99CCFF" align="center">#</th>
          <th width="600" bgcolor="#99CCFF" align="center">Statistical Information</th>
          <tr align="center">
          <td>1</td>
          <td><a href="statistics.php?val=1">Total Number of reactions and metabolites source wise</a></td>
        </tr>
        <tr align="center">
          <td>2</td>
          <td><a href="statistics.php?val=2">Ambiguous information</a></td>
        </tr>
        <tr align="center">
          <td>3</td>
          <td><a href="statistics.php?val=3">Stoichiometric inconsistencies</a></td>
        </tr>
        <tr align="center">
          <td>4</td>
          <td><a href="statistics.php?val=4">Metabolites and reactions with Partial atomistic details</a></td>
        </tr>
        <tr align="center">
          <td>5</td>
          <td><a href="statistics.php?val=5">Comparision of metabolic models and databases</a></td>
        </tr>
        <tr align="center">
          <td>6</td>
          <td><a href="statistics.php?val=6">Comparision of pre-curation and post-curation data</a></td>
        </tr>
        <tr align="center">
          <td>7</td>
          <td><a href="statistics.php?val=7">Numbers by atomistic details</a></td>
        </tr>
        <tr align="center">
          <td>8</td>
          <td><a href="statistics.php?val=8">Curation information by iteration</a></td>
        </tr>
        <tr align="center">
          <td>9</td>
          <td><a href="statistics.php?val=9">Data resolved by phonetic algorithm</a></td>
        </tr>
      </table>
    </tr>
    <tr align="right">
    <?php
	function showresults($result)
	{
		$i = 0;
		
                    
		echo "<table border='1' align=center width=90%>";
		$num_fields = mysql_num_fields($result);
		$spacing = 100/$num_fields;
		while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				echo "<th bgcolor='#99CCFF' align='center'>$columnName</th>";
				$i++;
			}
			
			
		while ($row = mysql_fetch_array($result)) 
		{
			$i = 0;
			echo "<tr>";
            while ($i < $num_fields) 
			{
				$meta = mysql_fetch_field($result, $i);
				$columnName = $meta->name;
				echo "<td align=center>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
	?>
      <?php
if(isset($_GET['val']))
{
	if($_GET['val'] == 1)
	{
		echo "<h2 align=center>Total Number of reactions and metabolites source wise</h2>";
		
		$result = mysql_query("SELECT source `Source name`,count(distinct abbreviation) `Count on acronyms`,type ,sourceType `Source type` FROM 
			`metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
			where A.idSource = B.idSourceNAme
			group by source,type,sourceType
			order by sourceType desc,source");
		
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct concat(abbreviation,source)) `Count on acronyms`,type ,sourceType `Source type` FROM 
			`metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
			where A.idSource = B.idSourceNAme
			group by type,sourceType
			order by sourceType desc");	
		
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct concat(abbreviation,source)) `Count on acronyms`,type  FROM 
			`metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
			where A.idSource = B.idSourceNAme
			group by type");	
		
		showresults($result);
		
	}
	else if($_GET['val'] == 2)
	{
		
		echo "<h2 align=center>Ambiguous information</h2>";
		/*Ambiguity arises out of synonyms and not acronyms*/
		$result = mysql_query("select count(distinct syn) `Count on distinct metabolite names`,
		source `Source name`,type,sourcetype `Source type`,cnt1 `Count on distinct canonical structures`,
		cnt2 `Count on distinct absolute structures` from
		(SELECT syn,source,type,sourceType,
		count(distinct cd_hash) cnt1,count(distinct idStr) cnt2 
		FROM `metrxn`.`abbrsynstrsrcview`
		group by syn,source,type,sourceType) A
		group by source,type,sourcetype,cnt1,cnt2 order by source,type");
		showresults($result);
		
		$result = mysql_query("select count(distinct syn) `Count on distinct metabolite names`,
		type,sourcetype `Source type`,cnt1 `Count on distinct canonical structures`,
		cnt2 `Count on distinct absolute structures` from
		(SELECT syn,type,sourceType,
		count(distinct cd_hash) cnt1,count(distinct idStr) cnt2 
		FROM `metrxn`.`abbrsynstrsrcview`
		group by syn,type,sourceType) A
		group by type,sourcetype,cnt1,cnt2 order by type");
		showresults($result);
		
		$result = mysql_query("select count(distinct syn) `Count on distinct metabolite names`,
		type,cnt1 `Count on distinct canonical structures`,
		cnt2 `Count on distinct absolute structures` from
		(SELECT syn,source,type,
		count(distinct cd_hash) cnt1,count(distinct idStr) cnt2 
		FROM `metrxn`.`abbrsynstrsrcview`
		group by syn,type) A
		group by type,cnt1,cnt2 order by type");
		showresults($result);	
		
	}	
	else if($_GET['val'] == 3)
	{
		
		echo "<h2 align=center>Stoichiometric inconsistencies</h2>";
			
		
		$result = mysql_query("SELECT count(distinct A.idRxn) `Number of Unbalanced reactions`,
		idSrc `Source id`,source `Source Name`,concat('<a href=statQuery.php?idSrc=',idSrc,'&val=',3,'&src=',source,'>','-->','</a>') `view` 
		FROM `metrxn`.`rxnatomsum_pin` A,`metrxn`.`abbrsynrxnsrc_pin` B,`metrxn`.`source_pin` C		
		where A.idRxn = B.idRxn
		and sum <> 0			
		and B.idSrc = C.idSourceName
		group by idSrc,source,`view`");
		showresults($result);
	}
	else if($_GET['val'] == 4)
	{
		echo "<h2 align=center>Metabolites and reactions with partial atomistic details</h2>";
		
		$result = mysql_query("SELECT count(distinct B.abbr) `Count on acronyms`,source `Source name`,type,sourceType `Source type` 
		FROM `jchem`.`importedstructures` A,`metrxn`.`abbrsynstrsrcview` B
		where cd_structure like '%R#%'
		and A.cd_id = B.idStr
		group by source,type,sourceType;");
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct concat(B.abbr,source)) `Count on acronyms`,type,sourceType `Source type` 
		FROM `jchem`.`importedstructures` A,`metrxn`.`abbrsynstrsrcview` B
		where cd_structure like '%R#%'
		and A.cd_id = B.idStr
		group by type,sourceType;");
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct concat(B.abbr,source)) `Count on acronyms`,type 
		FROM `jchem`.`importedstructures` A,`metrxn`.`abbrsynstrsrcview` B
		where cd_structure like '%R#%'
		and A.cd_id = B.idStr
		group by type;");
		showresults($result);
	}
	else if($_GET['val'] == 5)
	{
			
		$result = mysql_query("SELECT distinct concat(source,'(',sourceType,')') `source`,idSourceName FROM `metrxn`.`source_pin`");
		$resultCount = mysql_affected_rows();
		echo "<form name=model_comparsion method=post action=statQuery.php>";
		$j = 0;		
		echo "<table border='1'>";
		echo "<th style=border-right-width:0>Comparision of metabolic models and databases</th><tr>";
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			echo "<td><input type=checkbox name=field[".$i."] value=".$row['idSourceName'].">".$row['source']."</input></td>";	
			$i++;
			$j++;
			if($j == 4)
			{
				echo "<br></tr><tr>";
				$j = 0;
			}
			
		}
		
		echo "</tr><tr><td style=border-right-width:0><input type=hidden name=count value=$resultCount>
					<input type=hidden name=val value=5>
					<input type=submit value=submit />";
		echo "</td></tr></table>";
		echo "</form>";
		
	}
	else if($_GET['val'] == 6)
	{
		
		echo "<h2 align=center>Comparision of pre-curation and post-curation data </h2>";

		
		$result = mysql_query("select count(distinct Abbreviation) `Count on acronyms`,source,type,sourceType `Source type`,curation 
		from (SELECT B.Abbreviation,C.source,A.rel_type,'pre' `curation`,type,sourceType FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and rel_type = 'original'
		union 
		(SELECT B.Abbreviation,C.source,A.rel_type,'post' `curation`,type,sourceType FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and A.idAbbrsyn not in (select idAbbrsyn from `metrxn`.`abbrsynstrsrc_pin` where rel_type = 'original')))
		A group by source,curation,type,sourceType;");
		showresults($result);
		
		$result = mysql_query("select count(distinct abbr_src) `Count on acronyms`,type,sourceType `Source type`,curation 
		from (SELECT concat(B.Abbreviation,B.idSource) abbr_src,A.rel_type,'pre' `curation`,type,sourceType FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and rel_type = 'original'
		union 
		(SELECT concat(B.Abbreviation,B.idSource) abbr_src,A.rel_type,'post' `curation`,type,sourceType FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and A.idAbbrsyn not in (select idAbbrsyn from `metrxn`.`abbrsynstrsrc_pin` where rel_type = 'original')))
		A group by curation,type,sourceType;");
		showresults($result);
		
		$result = mysql_query("select count(distinct abbr_src) `Count on acronyms`,type,curation 
		from (SELECT concat(B.Abbreviation,B.idSource) abbr_src,A.rel_type,'pre' `curation`,type FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and rel_type = 'original'
		union 
		(SELECT concat(B.Abbreviation,B.idSource) abbr_src,A.rel_type,'post' `curation`,type FROM `metrxn`.`abbrsynstrsrc_pin` A, 
		`metrxn`.`abbreviationsynonym_pin` B,`metrxn`.`source_pin` C
		where A.idAbbrsyn = B.idAbbreviationsSynonym
		and A.idSrc = C.idSourceName
		and A.idAbbrsyn not in (select idAbbrsyn from `metrxn`.`abbrsynstrsrc_pin` where rel_type = 'original')))
		A group by curation,type;");
		showresults($result);
	}
	else if($_GET['val'] == 7)
	{
		
		echo "<h2 align=center>Numbers by atomistic details</h2>";
		
		
		$result = mysql_query("SELECT count(distinct abbr) `Count on acronyms`,source,sourceType `Source Type`,type,'partial' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure like '%R#%'
		group by source,sourceType,type
		union
		SELECT count(distinct abbr) `Count on acronyms`,source,sourceType `Source Type`,type,'full' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure not like '%R#%'
		group by source,sourceType,type
		union
		select count(distinct abbreviation) `Count on acronyms`,source,sourceType `Source Type`,type,'none' `Atomistic details` from `metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
		where A.idSource = B.idSourceName
		and A.Abbreviation not in (select distinct abbr from `metrxn`.`abbrsynstrsrcview` where idSource = A.idSource)
		group by source,sourceType,type;");
		
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct CONCAT(abbr,source)) `Count on acronyms`,sourceType `Source Type`,type,'partial' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure like '%R#%'
		group by sourceType,type
		union
		SELECT count(distinct concat(abbr,source)) `Count on acronyms`,sourceType `Source Type`,type,'full' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure not like '%R#%'
		group by sourceType,type
		union
		select count(distinct concat(abbreviation,source)) `Count on acronyms`,sourceType `Source Type`,type,'none' `Atomistic details` from `metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
		where A.idSource = B.idSourceName
		and A.Abbreviation not in (select distinct abbr from `metrxn`.`abbrsynstrsrcview` where idSource = A.idSource)
		group by sourceType,type;");
		
		showresults($result);
		
		$result = mysql_query("SELECT count(distinct CONCAT(abbr,source)) `Count on acronyms`,type,'partial' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure like '%R#%'
		group by type
		union
		SELECT count(distinct concat(abbr,source)) `Count on acronyms`,type,'full' `Atomistic details`  FROM `metrxn`.`abbrsynstrsrcview` A,`jchem`.`importedstructures` B
		where A.idStr = B.cd_id
		and B.cd_structure not like '%R#%'
		group by type
		union
		select count(distinct concat(abbreviation,source)) `Count on acronyms`,type,'none' `Atomistic details` from `metrxn`.`abbreviationsynonym_pin` A,`metrxn`.`source_pin` B
		where A.idSource = B.idSourceName
		and A.Abbreviation not in (select distinct abbr from `metrxn`.`abbrsynstrsrcview` where idSource = A.idSource)
		group by type;");
		
		showresults($result);
		
	}
	else if($_GET['val'] == 8)
	{
		
		echo "<h2 align=center>Curation information by iteration</h2>";
		
		$ref = 1;
		$result = mysql_query("SELECT count(distinct abbr) `Count on acronyms`,
		source,sourceType `Source type`,type,pass `Iterative Step`,
		concat('<a href=statQuery.php?idSrc=',idSource,'&type=',type,'&pass=',pass,'&val=8','>','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview`
		where pass <> 0 
		group by source,sourceType,type,pass,`view`
		having count(distinct rel_type) = 1;");
		showresults($result);
		
		$ref = 2;
		$result = mysql_query("SELECT count(distinct concat(abbr,source)) `Count on acronyms`,sourceType `Source type`,
		type,pass `Iterative Step`,concat('<a href=statQuery.php?type=',type,'&pass=',pass,'&val=8','>','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview`
		where pass <> 0 
		group by sourceType,type,pass,`view`;");
		showresults($result);
		
		$ref = 3;
		$result = mysql_query("SELECT count(distinct concat(abbr,source)) `Count on acronyms`,
		type,pass `Iterative Step`,
		concat('<a href=statQuery.php?type=',type,'&pass=',pass,'&val=8','>','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview`
		where pass <> 0 
		group by type,pass,`view`;");
		showresults($result);
	}
	else if($_GET['val'] == 9)
	{
		
		echo "<h2 align=center>Data resolved by phonetic algorithm</h2>";		
		
		$result = mysql_query("SELECT count(distinct abbr) `Count on acronyms`,
		type,source,match_type_control,concat('<a href=statQuery.php?type=',type,'&idSrc=',idSource,'&val=9','>','-->','</a>') `view`  
		FROM `metrxn`.`abbrsynstrrxnsrcview`
		where match_type_control is not null
		group by type,source,match_type_control;");
		showresults($result);
	}
}

?>
    </tr>
  </table>
</div>

</body>
</html>