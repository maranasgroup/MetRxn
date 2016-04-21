<?php if(!isset($_SESSION))
{
session_start();

include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();
	set_time_limit (300);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Query results</title>
	<link href="<?php echo relativePath(getcwd(),$metRxnContents_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$anchors_css); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo relativePath(getcwd(),$headings_css); ?>" rel="stylesheet" type="text/css" />
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
}
.header {
	width: 100%;
	top: 0;
	border: none;
}
</style>
</head>
<body><tr>
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
<div>
  <?php
function showresults($result)
	{
		
		$i = 0;
		
                    
		echo "<table border='1' align=center width=100%>";
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
				
				echo "<td align=center style=max-width:100%>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
?>
  <?php
echo "<table width=70%>";
if(isset($_POST['val'])) 
{
	if($_POST['val'] == 5)
	{
	
	if(isset($_POST['field']))
	//echo sizeof($_POST['field']);
	$arr = $_POST['field'];
	$idSrc = "";
	for ($i=0; $i<$_POST['count'];) {
		if(isset($_POST['field'][$i]))
		{
			//echo $_POST['field'][$i]."<br />";
			$idSrc = $idSrc.",".$_POST['field'][$i];
		}
			$i++;
			
	}
	$idSrc =  preg_replace('/,/', '', $idSrc, 1);
	
	$queryCheck = "select group_concat(distinct source separator ', ') `src`,count(distinct source) cnt from metrxn.source_pin A where A.idSourceName in (".$idSrc.")
		and A.idSourceName not in (select distinct idSource 
		from `metrxn`.`abbrsynstrsrcview` where type = 'reactions' and idSource in (".$idSrc."));";
	
	//echo $queryCheck;
	
	$resultCheck = mysql_query($queryCheck);
	while($rowCheck = mysql_fetch_array($resultCheck))
	{
		if($rowCheck['cnt'] > 0)
		{
			echo nl2br("\n\n<font size=3>Reactions from <b>".$rowCheck['src']."</b> are yet to be resolved for full atomistic details</font>");
		}
	}
	
	
	$ref = 100;
	$query = "SELECT distinct organism,sourceType `type` from metrxn.source_pin where idSourceName in (".$idSrc.")
		order by organism,sourceType";
		
	//echo $query;	
	if($idSrc != "")
	{
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=left>This page shows the result for the comparisions between the following metabolic models and databases</h2></td></tr>";
		echo "<tr><td align=left>";
		showresults($result);
		echo "</tr></td>";
	}	
	
	$ref =0;
	$query = "SELECT count(distinct cd_hash) `Canonical structures`,count(distinct abbr) `Abbreviations`,count(distinct syn) `Full names`, 
		concat(source,' (',sourceType,') ') `Source`,type `Type` FROM `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$idSrc.")
		group by `Source`,type";
		
	//echo $query;	
	if($idSrc != "")
	{
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=left>Total number of metabolites and reactions for each metabolic model or database</h2></td></tr>";
		echo "<tr><td align=left>";
		showresults($result);
		echo "</tr></td>";
	}
	
	$ref =1;
	$query = "select count(*) `Canonical structures`,`Intersection`,type `Type`,`Sources`,`view` from 
		(SELECT group_concat(distinct source order by source separator ', ') `Sources`,
		group_concat(distinct syn order by source separator ', ') `Metabolite synonyms`,
		group_concat(distinct abbr order by source separator ', ') `Metabolite acronyms`,
		count(distinct source) `Intersection`,type, 
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct idSource order by idSource),'&CntSrc=',count(distinct source),'&type=',type,'&AllSrc=$idSrc','&ref=".$ref.">','-->','</a>') `view`
		 FROM `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$idSrc.")
		group by cd_hash,type
		having count(distinct source) <= ".sizeof($_POST['field']).") A 
		group by `Intersection`,`Sources`,`Type`,`view` order by `Type`,`Intersection` desc";
		
	//echo $query;	
	if($idSrc != "")
	{
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=left>Number of non redundant metabolite and reaction overlaps based on <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp123'>canonical SMILES</a></h2></td></tr>";
		
		
		
		echo "<tr><td><p>Please follow the links below to download the corresponding comparision in SBML</p></tr></td>";
		
			
		
			
		
		
		echo "<tr><td align=left>";
		showresults($result);
		echo "</tr></td>";
	}
	
	$ref =2;
	$query = "select count(distinct abbr)`Count on acronyms`,type,`Count on source`,
		`Source names`,source `Overlap with source`,`view` from 
		(SELECT group_concat(distinct A.source order by A.source separator ', ') `Source names`,count(distinct A.source) `Count on source`,
		B.abbr,B.type,B.source,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct A.idSource order by A.idSource separator ', '),'&CntSrc=',count(distinct A.source),'&qrySrc=',B.idSource,'&type=',B.type,'&AllSrc=$idSrc','&ref=".$ref.">','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`abbrsynstrsrcview` B 
		where A.idsource in (".$idSrc.") and B.idsource in (".$idSrc.") 
		and A.cd_hash = B.cd_hash 
		group by A.cd_hash,type,B.abbr,B.type,B.source having count(distinct A.source) <= ".sizeof($_POST['field'])." 
		and count(distinct A.source) > 1) A 
		group by `Source names`,type,`Overlap with source`,`Count on source`,`view` order by type,`Count on acronyms` desc;";
		
	//echo $query;	
	if($idSrc != "")
	{
		/*$result = mysql_query("$query");
		echo "<tr><td><h2 align=center>Count on metabolites and reactions based on canonical structures for individual source</h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
		*/
	}
	
	$ref =3;
	$query = "select count(*) `Isomeric structures`,`Intersection`,type,`Sources`,`view` from 
		(SELECT group_concat(distinct source order by source separator ', ') `Sources`,
		group_concat(distinct syn order by source separator ', ') `Metabolite synonyms`,
		group_concat(distinct abbr order by source separator ', ') `Metabolite acronyms`,
		count(distinct source) `Intersection`,type,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct idSource order by idSource separator ', '),'&CntSrc=',count(distinct source),'&type=',type,'&AllSrc=$idSrc','&ref=".$ref.">','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$idSrc.")
		group by idStr,type
		having count(distinct source) <= ".sizeof($_POST['field']).") A 
		group by `Intersection`,`Sources`,type,`view` order by type,`Intersection` desc";
		
	if($idSrc != "") 
	{
		$result = mysql_query("$query");
		
		echo "<tr><td><h2 align=left>Number of non redundant metabolite and reaction overlaps based on <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp546'>isomeric SMILES</a></h2></td></tr>";
		
		echo "<tr><td><p>Please follow the links below to download the corresponding comparision in SBML</p></tr></td>";
		
		echo "<tr><td align=left>";
		showresults($result);
		echo "</tr></td>";
	}
	
	$ref =4;
	$query = "select count(distinct abbr)`Count on acronyms`,type,`Count on source`,
		`Source names`,source `Overlap with source`,`view` from 
		(SELECT group_concat(distinct A.source order by A.source separator ', ') `Source names`,count(distinct A.source) `Count on source`,
		B.abbr,B.type,B.source,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct A.idSource order by A.idSource separator ', '),'&CntSrc=',count(distinct A.source),'&qrySrc=',B.idSource,'&type=',B.type,&AllSrc=$idSrc,'&ref=".$ref.">','-->','</a>') `view`
		FROM `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`abbrsynstrsrcview` B 
		where A.idsource in (".$idSrc.") and B.idsource in (".$idSrc.") 
		and A.idStr = B.idStr 
		group by A.idStr,type,B.abbr,B.type,B.source having count(distinct A.source) <= ".sizeof($_POST['field'])." 
		and count(distinct A.source) > 1) A 
		group by `Source names`,type,`Overlap with source`,`Count on source`,`view` order by type,`Count on acronyms` desc;";
		
		
	if($idSrc != "")
	{
		/*$result = mysql_query("$query");
		echo "<tr><td><h2 align=center>Count on metabolites and reactions based on absolute structures for individual source</h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
		*/
	}	
	$ref = 5;
	$query = "select sum(distinct cd_hash) `Count on transformations`,type,`Count on source`,`Source names`,`view`
		from ( select count(A.idStr) `cd_hash`,count(distinct source) `Count on source`,
		group_concat(distinct source order by source separator ', ') `Source names`,type,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct idSource order by idSource separator ', '),'&CntSrc=',count(distinct idSource),'&type=',A.type,'&ref=".$ref.">','-->','</a>') `view`
		from `metrxn`.`abbrsynstrrxnsrcview`A,`Jchem`.`importedstructures` B
		where idSource  in (".$idSrc.")
		and rxn_abs_cd_id is not null
		and rxn_abs_cd_id = B.cd_id
		and type = 'reactions'
		group by B.cd_hash
		having count(distinct idSource) <= ".sizeof($_POST['field'])."
		and count(distinct idSource) > 1) a
		group by `Count on source`,`Source names`,`view`
		order by `Count on source` desc";
		
		
	/*if($idSrc != "")
	{
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=left>Overlap in reactions when co-factors, protons and water molecules are omittted</h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
		
	}
	*/
	$ref = 6;
	$query = "select count(distinct rxn_abs_Cd_id) `Count on transformations`,type,`Count on source`,`Source names`,`view`
		from (
		select rxn_abs_cd_id,count(distinct source) `Count on source`,
		group_concat(distinct source order by source separator ', ') `Source names`,type,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct idSource order by idSource separator ', '),'&CntSrc=',count(distinct idSource),'&type=',type,'&ref=".$ref.">','-->','</a>') `view`
		from `metrxn`.`abbrsynstrrxnsrcview`A
		where idSource  in (".$idSrc.")
		and rxn_abs_cd_id is not null
		and type = 'reactions'
		group by rxn_abs_cd_id
		having count(distinct idSource) <= ".sizeof($_POST['field'])."
		and count(distinct idSource) > 1) a
		group by `Count on source`,`Source names`,`view`
		order by `Count on source` desc";
		
	if($idSrc != "")
	{
		/*
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=center>Overlap in reactions when co-factors, protons and water molecules are omittted for absolute structures </h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
		*/
	}

	$ref =7;
	$query = "select count(*) `Isomeric structures`,`Intersection`,type,`Sources`,`view` from 
					(SELECT group_concat(distinct source order by source separator ', ') `Sources`,
		group_concat(distinct syn order by source separator ', ') `Metabolite synonyms`,
		group_concat(distinct abbr order by source separator ', ') `Metabolite acronyms`,
		count(distinct source) `Intersection`,type,
		concat('<a href=statQuery.php?SrcGrp=',group_concat(distinct idSource separator ', '),'&CntSrc=',count(distinct source),'&type=',type,'&ref=".$ref.">','-->','</a>') `view` 
		FROM `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$idSrc.")
		group by idStr,type
		having count(distinct source) <= ".sizeof($_POST['field']).") A 
		group by `Intersection`,`Sources`,type,`view` order by type,`Intersection` desc";
		
	if($idSrc != "") 
	{
		/* $result = mysql_query("$query");
		
		echo "<tr><td><h2 align=left>Number of non redundant metabolite and reaction overlaps based on <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp546'>isomeric SMILES</a></h2></td></tr>";
		echo "<tr><td align=left>";
		showresults($result);
		echo "</tr></td>"; */
	}	
	
		
		
	echo "</table></tr>";
	}
}
if(isset($_GET['val']))
if($_GET['val'] == 3)
{
		if(isset($_GET['idRxn']))
		{
			$result = mysql_query("SELECT idRxn,Atom,sum FROM `metrxn`.`rxnatomsum_pin` where idRxn = ".$_GET['idRxn']);
			showresults($result);
			
			$result = mysql_query("SELECT abbreviation,group_concat(distinct synonym separator ', ') `Metabolite names`,A.idStr,
				A.idRxn,B.formula,B.location,a.reactionASAbbreviation,
				A.oldStoichiometry,A.compartment,B.subscript `charge` 
				FROM `metrxn`.`oldstoichiostrabbrrxn_pin` A,metrxn.joinAtomOldStoichiometry_pin B,`metrxn`.`atominfotable_pin` C
				where A.idRxn = B.idRxn
				and A.idRxn = ".$_GET['idRxn']."
				and B.idRxn = ".$_GET['idRxn']."
				and A.idStr = B.idStr
				and A.idRxn = C.idReaction
				and B.idStr = C.idStr
				AND A.LOCATION = B.LOCATION
				and B.atom = 'charge'
				group by abbreviation,A.idStr,
				A.idRxn,formula,B.location,a.reactionASAbbreviation,
				A.oldStoichiometry,`charge`,A.compartment order by location");
			showresults($result);
		}
		else 
		{
		echo "<h2 align=center>Reactions where elements others than H and 'charge' are unbalanced for ".$_GET['src']."</h2>";
			
		
		/*$result = mysql_query("select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_GET['idSrc']."'
				and sum <> 0 and atom <>'charge' 	and atom <> 'H'");*/
				
		$result = mysql_query("select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`,
    count(distinct D.abbreviation) originalNoAbbreviation,
    count(distinct F.abbr) identifiedAbbreviation
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B,
                `metrxn`.`abbrsynrxnsrc_pin` C,`metrxn`.`abbreviationsynonym_pin` D,
                `metrxn`.`atominfotable_pin` E,`metrxn`.`abbrsynstrrxnsrcview` F
				where A.idReaction = B.idRxn
				and A.idSource = '".$_GET['idSrc']."'
				and B.sum <> 0 and 
                B.atom <>'charge'
                and B.atom <> 'H'
                and A.idReaction = C.idRxn
                and C.idabbrSyn = D.idAbbreviationsSynonym
                and D.type = 'metabolites'
                and E.idReaction = C.idRxn
                and E.idStr = F.idStr
                and E.idReaction = F.idRxn
                and F.type = 'metabolites'                
                group by `Reactions as metabolite acronyms`,`view`;");
		
				
		showresults($result);
		
		 echo "Number of results: " . mysql_affected_rows();
		
		echo "<h2 align=center>All Unbalanced reactions for ".$_GET['src']."</h2>";
			
		
		$result = mysql_query("select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_GET['idSrc']."'
				and sum <> 0");
		showresults($result);
		
		 echo "Number of results: " . mysql_affected_rows();
		 
		 echo "<h2 align=center>Reactions off by one hydrogen only for ".$_GET['src']."</h2>";
		 
		 $result = mysql_query("select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_GET['idSrc']."'
				and sum <> 0
				and B.atom = 'H'
				and B.idRxn in (select distinct idRxn from `metrxn`.`rxnatomsum_pin` where idRxn = B.idRxn
				and atom <> 'H' group by idRxn having sum(abs(sum)) = 0)");
		showresults($result);
		
		 echo "Number of results: " . mysql_affected_rows();
		 
		 echo "<h2 align=center>Reactions off by charge for ".$_GET['src']."</h2>";
		 
		 $result = mysql_query("select distinct A.reactionAsAbbreviation `Reactions as metabolite acronyms`,
		concat('<a href=statQuery.php?idRxn=',B.idRxn,'&val=3','>','-->','</a>')  `view`
				from `metrxn`.`reaction_pin` A,`metrxn`.`rxnatomsum_pin` B
				where A.idReaction = B.idRxn
				and A.idSource = '".$_GET['idSrc']."'
				and sum <> 0
				and B.atom = 'charge'
				and B.idRxn in (select distinct idRxn from `metrxn`.`rxnatomsum_pin` where idRxn = B.idRxn
				and atom not in ('H','charge') group by idRxn having sum(abs(sum)) = 0)");
		showresults($result);
		
		 echo "Number of results: " . mysql_affected_rows();
		 
		 $query = "select Abbreviation,E.formula,E.subscript `charge`,count(distinct B.idRxn) RxnCount,D.idStr from `metrxn`.`rxnatomsum_pin` A,
			`metrxn`.`abbrsynrxnsrc_pin` B,`metrxn`.`abbreviationsynonym_pin` C,
			`metrxn`.`abbrsynstrsrc_pin` D,`metrxn`.`atominfotable_pin` E
			where A.idRxn = B.idRxn
			and B.iDAbbrsyn = C.idAbbreviationsSynonym
			and B.iDAbbrsyn = D.iDAbbrsyn
			and B.idRxn = E.idReaction
			and B.idSrc = ".$_GET['idSrc']."
			and D.idStr = E.idStr
			and A.sum <> 0
			and E.atom = 'charge'
			group by Abbreviation,D.idStr
			order by RxnCount desc;";
		$result = mysql_query($query);
		$resultCount = mysql_affected_rows();
		echo "<form name=wrongAssociations method=post action=PossibleWrongReactions.php>";
		$j = 0;		
		echo "<table border='1'>";
		echo "<th>IdStr</th><th>RxnCount</th><th>formula</th><th>Charge</th><th style=border-right-width:0>Mark wrong associations here</th><tr>";
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			echo "<tr><td>".$row['idStr']."</td><td>".$row['RxnCount']."</td><td>".$row['formula']."</td><td>".$row['charge']."</td><td><input type=checkbox name=field[".$i."] value=".$row['Abbreviation'].">".$row['Abbreviation']."</input></td></tr>";	
			$i++;
			$j++;
			
			
		}
		
		echo "<tr><td style=border-right-width:0><input type=hidden name=count value=$resultCount>
					<input type=hidden name=val value=5>
					<input type=hidden name=idSrc value=".$_GET['idSrc'].">
					<input type=submit value=submit />";
		echo "</td></tr></table>";
		echo "</form>";
		
		//showresults($result);
		//and atom <>'charge' 	and atom <> 'H'
		}
		
}
else if($_GET['val'] == 8)
{
	if(isset($_GET['idSrc']))
		{
		$query = "select A.idStr,A.abbr,A.syn,A.pass,A.type,A.reactionAsAbbreviation,A.idRxn,
		group_concat(distinct C.syn separator ', ') `Metabolites identified in the previous pass`
		from `metrxn`.`abbrsynstrrxnsrcview_pin` A,`metrxn`.`abbrsynstrrxnsrcview_pin` B,`metrxn`.`abbrsynstrsrcview` C
		where A.type = '".$_GET['type']."' and A.idSource = '".$_GET['idSrc']."' 
		and A.pass = '".$_GET['pass']."' and A.idRxn = B.idRxn 
		and B.idStr = C.idStr
		and C.type = 'metabolites'
		and C.pass = A.pass - 1
		group by A.idStr,A.abbr,A.syn,A.pass,A.type,A.reactionAsAbbreviation,A.idRxn
		order by A.abbr";
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=center></h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
		}
	else
	{
		$query = "select A.idStr,A.cd_hash,A.abbr,A.source,A.syn,A.pass,A.type,A.reactionAsAbbreviation,A.idRxn,
		group_concat(distinct C.syn separator ', ') `Metabolites identified in the previous pass`
		from `metrxn`.`abbrsynstrrxnsrcview_pin` A,`metrxn`.`abbrsynstrrxnsrcview_pin` B,`metrxn`.`abbrsynstrsrcview` C
		where A.type = '".$_GET['type']."' 
		and A.pass = '".$_GET['pass']."' and A.idRxn = B.idRxn 
		and B.idStr = C.idStr
		and C.pass = A.pass - 1
		group by A.idStr,A.abbr,A.syn,A.source,A.pass,A.type,A.reactionAsAbbreviation,A.idRxn
		order by A.abbr";
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=center></h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
	}
}
else if($_GET['val'] == 9) 
{
		$query = "SELECT distinct A.abbr `Acronyms`,A.syn,
group_concat(distinct A.reactionAsAbbreviation separator ', ') ,A.type,A.source,
		group_concat(distinct B.Synonym separator ', ') `Similar Synonyms`,
        group_concat(distinct D.reactionAsAbbreviation order by D.idSource separator ', '),
        group_concat(distinct E.source order by E.idSourceName separator ', ')
		FROM `metrxn`.`abbrsynstrrxnsrcview` A,`metrxn`.`abbreviationsynonym_pin` B,
        `metrxn`.`abbrsynrxnsrc_pin` C,`metrxn`.`reaction_pin` D,`metrxn`.`source_pin` E  
		where soundex(A.syn) = B.syn_soundex
		and A.syn <> B.synonym
    and B.idAbbreviationsSynonym = C.idAbbrSyn
    and C.idRxn = D.idREaction
		and A.idSource = ".$_GET['idSrc']."
    and D.idsource = E.idSourceName 
    and A.rxn_Cd_id = D.rxn_Cd_id
	and A.idSource <> D.idSource
		group by A.type,A.source,A.syn,A.abbr";
		$result = mysql_query("$query");
		echo "<tr><td><h2 align=center> Phonetic matches </h2></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";
}

if(isset($_GET['ref']))
if($_GET['ref'] == 1)
{
	
	$query = "SELECT type `Type`,GROUP_CONCAT(distinct syn order by source separator ', ') `".str_replace('metabolites','Metatbolite',(str_replace('reactions','Reaction',$_GET['type'])))." names`,
		group_concat(distinct abbr order by source separator ', ') `".str_replace('metabolites','Metatbolite',(str_replace('reactions','Reaction',$_GET['type'])))." Id's`,group_concat(distinct source order by source separator ', ') `Source names`  
		from `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$_GET['AllSrc'].")
		and type = '".$_GET['type']."'
		group by cd_hash
		having count(distinct source) = ".$_GET['CntSrc']." and group_concat(distinct idSource order by idsource) = '".$_GET['SrcGrp']."';";
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp123'>canonical structures</a>:Showing results for ".$resultCount." canonical structures</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";
			
}
else if($_GET['ref'] == 2)
{
	$query = "select distinct B.source `Source name`,B.abbr `Acronyms`,
		group_concat(distinct B.syn) `Metabolite names`,A.type,
		group_concat(distinct A.source) `Overlap with` 
		from `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`abbrsynstrsrcview` B
		where A.idsource in (".$_GET['SrcGrp'].")
		and A.type = '".$_GET['type']."'
		and A.cd_hash = B.cd_hash
		and B.idSource = ".$_GET['qrySrc']."
		group by A.cd_hash,B.abbr
		having count(distinct A.source) = ".$_GET['CntSrc']." order by A.cd_hash;";
		
		
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.daylight.com/dayhtml/doc/theory/theory.smiles.html'>canonical </a>structures: Showing results for ".$resultCount." acronyms</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";	
}
else if($_GET['ref'] == 3)
{
	$query = "SELECT type,GROUP_CONCAT(distinct syn order by source) `".$_GET['type']."`,
		group_concat(distinct abbr order by source) `abbreviations`,group_concat(distinct source order by source) `source`  
		from `metrxn`.`abbrsynstrsrcview`
		where idsource in (".$_GET['AllSrc'].")
		and type = '".$_GET['type']."'
		group by idStr
		having count(distinct source) = ".$_GET['CntSrc']." and group_concat(distinct idSource order by idsource) = '".$_GET['SrcGrp']."';";
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp546'>isomeric </a>structures:Showing results for ".$resultCount." isomeric structures</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";
			
}
else if($_GET['ref'] == 4)
{
	$query = "select distinct B.source `Source name`,B.abbr `Acronyms`,
		group_concat(distinct B.syn) `Metabolite names`,A.type,
		group_concat(distinct A.source) `Overlap with` 
		from `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`abbrsynstrsrcview` B
		where A.idsource in (".$_GET['SrcGrp'].")
		and A.type = '".$_GET['type']."'
		and A.idStr = B.idStr
		and B.idSource = ".$_GET['qrySrc']."
		group by A.idStr,B.abbr
		having count(distinct A.source) = ".$_GET['CntSrc']." order by A.idStr;";
		
		
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp546'>isomeric </a>structures: Showing results for ".$resultCount." acronyms</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";	
}
else if($_GET['ref'] == 5)
{
	$query = "SELECT group_concat(distinct syn) `".$_GET['type']."`,group_concat(distinct abbr) `abbreviations`,
		group_concat(distinct reactionAsAbbreviation) `Reaction represented with metabolite abbreviations`,
		group_concat(distinct source) `source`
		FROM `metrxn`.`abbrsynstrrxnsrcview` A,`Jchem`.`importedstructures` B
		where idSource in (".$_GET['SrcGrp'].")
		and type = '".$_GET['type']."'
		and A.rxn_abs_cd_id = B.cd_id
		group by B.cd_hash
		having count(distinct idSource) = ".$_GET['CntSrc']." order by `source`";
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp123'>canonical structures</a>: Showing results for ".$resultCount." transformations</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";	
}

else if($_GET['ref'] == 6)
{
	$query = "SELECT group_concat(distinct syn) `Reaction names`,group_concat(distinct abbr) `Acronym names`,
		group_concat(distinct reactionAsAbbreviation) `Reaction represented with metabolite abbreviations`,
		group_concat(distinct source) `Source names`
		FROM `metrxn`.`abbrsynstrrxnsrcview`
		where idSource in (".$_GET['SrcGrp'].")
		and type = '".$_GET['type']."'
		group by rxn_abs_cd_id
		having count(distinct idSource) = ".$_GET['CntSrc']." order by `Source names`";
		
	$result = mysql_query($query);
	$resultCount = mysql_affected_rows();
		echo "<tr><td><h2 align=center>Data grouped by <a href='http://www.purpleslurple.net/ps.php?theurl=http%3A%2F%2Fwww.daylight.com%2Fdayhtml%2Fdoc%2Ftheory%2Ftheory.smiles.html#purp546'>isomeric </a>structures: Showing results for ".$resultCount." transformations</h2></td></tr>";
		
		echo "<tr><td><p>Your search results are available as SBML, click on the link below to download.</p></td></tr>";
		echo "<tr><td><a href=>SBML</a></td></tr>";
		
		echo "<tr><td>";
		showresults($result);
		echo "</tr></td>";	
	
	echo "</table></tr>";	
}
/*SELECT group_concat(distinct syn) `Reaction names`,group_concat(distinct abbr) `Acronym names`,
group_concat(distinct reactionAsAbbreviation) `Reaction represented with metabolite abbreviations`
FROM `metrxn`.`abbrsynstrrxnsrcview`
where source in ('GEOBACTER_METALLIREDUCENS','GEOBACTER_SULFURREDUCENS','HALOBACTERIUM_SALINARUM')
and type = 'reactions'
group by rxn_abs_cd_id
having count(distinct idSource) = 3;*/





?>
</div>
</td>
</tr>
</table>
</body>
</html>