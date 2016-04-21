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

if(isset($_SESSION['username']))
{
session_start();
$username = $_SESSION['username'];
}
else 
{
$username = "guest";
}
	{
	$accessLevel = "guest";
	$result = mysql_query("select accessLevel from `metrxnweb`.`login` where username = '".$username."'");
	while ($row = mysql_fetch_array($result))
		{
			$accessLevel = $row['accessLevel'];
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_POST["Organism"]; ?></title>

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
    <script type="text/javascript"
    SRC="http://www.chemaxon.com/marvin/marvin.js"></script>
    <script language="JavaScript" type="application/javascript">
        function showStructure(id,fileType)
        {
	mview_begin('../marvin', 400, 200);
	mview_param('mol', '../StructureFile/'+id+'.'+fileType+'');
	mview_param('mol', '../StructureFile/'+id+'.'+fileType+'');
	mview_end();
        }
    </script>
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
function showresults($result)
	{
		
		$i = 0;
		
                    
		echo "<table border='1' align=center>";
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
				
				echo "<td align=center style=max-width:100>".$row[$i]."</td>";
				$i++;
			}           
			echo "</tr>"; 
        }	
			
		echo "</table>";
	}
?>
<div>
<?php
if (isset($_POST['submit'])) {
						
						$result_head = mysql_query("select linkout from metrxn.source_pin where source = '" . $_POST["Organism"] . "'");
						while ($row = mysql_fetch_array($result_head)) {
							echo nl2br("\n\nShowing results for <a href=".$row['linkout']." target=_blank>".$_POST["Organism"]."</a>\n\n");
						}
                        
						
                    }
?>
  <form action="" method="post">
    <select name="Organism">
      <?php
                    if (isset($_POST['submit'])) {
						
						$result_head = mysql_query("select linkout from metrxn.source_pin where source = '" . $_POST["Organism"] . "'");
						while ($row = mysql_fetch_array($result_head)) {
							echo "Showing results for <a href=".$row['linkout'].">".$_POST["Organism"]."</a>";
						}
                        
						echo "<option value='" . $_POST["Organism"] . "'>" . $_POST["Organism"] . "</option>";
						$rowSource = $_POST["Organism"];
                    } else {
                        echo "<option value=''>---------------</option>";
						$rowSource = '';
                    }
					
                    $result = mysql_query("SELECT DISTINCT source,idSourceName FROM `metrxn`.`source_pin` where idSourceName in 
					(select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
					where A.idUser = B.idlogin and B.username = '".$username."') and source <> '".$rowSource."' and sourceType <> 'database' order by source;");
					
                    while ($row = mysql_fetch_array($result)) {
                        echo "<option value='" . $row['source'] . "'>" . $row['source'] . "</option>";
                    }
                    ?>
      <input type="radio" name="RXN_MET" value="metabolites" <?php if(isset($_POST['RXN_MET'])){if($_POST['RXN_MET'] == 'metabolites'){echo "checked";}} ?> />
       Metabolites
                    
      <input type="radio" name="RXN_MET" value="reactions" <?php if(isset($_POST['RXN_MET'])){if($_POST['RXN_MET'] == 'reactions'){echo "checked";}} ?>/>
       Reactions
	   
	   <input type="radio" name="RXN_MET" value="SBML" <?php if(isset($_POST['RXN_MET'])){if($_POST['RXN_MET'] == 'SBML'){echo "checked";}} ?>/>
       SBML
	   
	   
       <?php
	   if($accessLevel == 'admin')
	   {
       echo "<input type=radio name=RXN_MET value=sij />
       S[i,j]
       ";
	   }
		?>
      <input type="submit" name = "submit" value="Submit" />
    </select>
  </form>
</div>
<?php
	if(isset($_POST['curationBool']))
	{
		echo $_SESSION['username'];
		echo $_POST['curationComments'];
		mysql_query("call metRxn.updateAsChecked('".$_POST['cd_hash']."',
		'".$_POST['RXN_MET']."',
		'".$_POST['abbr']."',
		'".$_POST['Organism']."',
		'".$_POST['curationBool']."',
		'".$_SESSION['username']."',
		'".$_POST['curationComments']."')");
	}
		?>
<?php

if (isset($_POST['submit'])) {

	if(!isset($_POST['RXN_MET']))
	{
		echo nl2br("\n\n<font size =3>Please choose between metabolites or reactions to display any data</font>");
		die();
	}
	
	if($_POST['RXN_MET'] == 'reactions')
		$RXN_MET_val = 'Reactions';
	else if($_POST['RXN_MET'] == 'metabolites')	
		$RXN_MET_val = 'Metabolites';
		
	/*Check if there is any reaction data*/	
	if($RXN_MET_val == 'Reactions')
	{
		$queryCheckForReactions = "select count(distinct idRxn) `cnt` from `metrxn`.`abbrsynrxnsrc_pin` A,`metrxn`.source_pin B 
		 where A.idSrc = B.idSourceName and B.source = '".$_POST["Organism"]."'";
		 
		//echo $queryCheckForReactions;
		$result = mysql_query($queryCheckForReactions);
		while ($rowCheckForReactions = mysql_fetch_array($result)) 
		{
			if($rowCheckForReactions['cnt'] == 0)
			{
			echo nl2br("\n\n<font size=3>We are currently processing reactions from <b>".$_POST["Organism"]." </b>,please check back with MetRxn for updates</font>");
			die();
			}
		}
	}
	
	if($_POST['RXN_MET'] == 'sij')
	{	
		echo "<h3> Possible biomass equations </h3>";
		
		
		$query = "SELECT reactionAsAbbreviation,count(distinct abbr) cnt 
			FROM `metrxn`.`abbrsynstrrxnsrcview`
			where Source = '".$_POST["Organism"]."'
			and type = 'metabolites'
			group by reactionAsAbbreviation
			order by cnt desc limit 5;";
			
		$result = mysql_query("$query");
		showresults($result);	
		
		$query = "drop table if exists metrxn.oldStoichiometryAbbr";
		mysql_query("$query");
		
		$query = "create table metrxn.oldStoichiometryAbbr engine = memory as 
				SELECT distinct B.abbreviation,A.idRxn,oldStoichiometry,location `RP`,D.direction `Direction` 
				FROM `metrxn`.`abbrsynrxnsrc_pin` A,`metrxn`.`abbreviationsynonym_pin` B,
				`metrxn`.`source_pin` C,`metrxn`.`reaction_pin` D
				where A.idAbbrsyn = B.idAbbreviationsSynonym
				and B.idSource = C.idSourceName
				and A.idRxn = D.idReaction
				and C.source = '".$_POST["Organism"]."'
				and B.type = 'metabolites'";		
		
		mysql_query("$query");			
	
		echo "<h3> S[i,j] matrix for the original file </h3>";
		$query = "select * from (
			select distinct abbreviation,concat('RXN',idRxn) `reaction`,-1*oldStoichiometry,RP,Direction
			from metrxn.oldStoichiometryAbbr
			where RP = 'Reactant'
			union
			select distinct abbreviation,concat('RXN',idRxn) `reaction`,oldStoichiometry,RP,Direction
			from metrxn.oldStoichiometryAbbr
			where RP = 'Product') A order by reaction";			
		
		
		$result = mysql_query("$query");		
		showresults($result);
		
		
		
		echo "<h3> S[i,j] matrix for the re-balanced file </h3>";
		
		$query = "Drop Table If Exists metrxn.newStoichiometryAbbr";				
		mysql_query("$query");
		
		$query = "create table metrxn.newStoichiometryAbbr engine = memory as
			select distinct * from (select A.abbr,B.stoichiometryAsDecimal,B.idReaction,RPflag,A.idstr,A.direction 
			from `metrxn`.`abbrsynstrrxnsrcview` A,`metrxn`.`atominfotable_pin` B
			where A.idStr = B.idStr
			and A.idRxn = B.idReaction
			and A.source = B.source
			and A.type = 'metabolites'
			and A.Source = '".$_POST["Organism"]."'
			and B.stoichiometryAsDecimal <> 0) a";		
		mysql_query("$query");
		
		$query = "alter table metrxn.newStoichiometryAbbr add index idx_rxn(idReaction), add index idx_str(idStr);";
		mysql_query("$query");
		
		
		$query = "insert into metrxn.newStoichiometryAbbr
			select A.abbr,stoichiometryAsDecimal,B.idReaction,RPflag,A.idStr,C.direction
			from `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`atominfotable_pin` B,`metrxn`.`reaction_pin` C
			where A.idStr = B.idStr
			and A.type = 'metabolites'
			and A.source = B.source
			and B.Source = '".$_POST["Organism"]."'
			and A.idStr in (1,75)
			and B.idReaction = C.idReaction
			and round(B.stoichiometryAsDecimal) <> 0;";
		mysql_query("$query");
		
		$query = "insert into metrxn.newStoichiometryAbbr select distinct abbreviation,idRxn,oldStoichiometry,RP,Direction
			from metrxn.oldStoichiometryAbbr where idRxn not in (select distinct idReaction from metrxn.newStoichiometryAbbr);";
		mysql_query("$query");
		
		$query = "select * from (select distinct abbr,concat('RXN',idReaction) `reaction`,-1*stoichiometryAsDecimal `stoichiometry`,RPflag `RP`,Direction 
			from metrxn.newStoichiometryAbbr
			where RPflag = 'R'
			union
			select distinct abbr,concat('RXN',idReaction) `reaction`,stoichiometryAsDecimal `stoichiometry`,RPflag `RP`,Direction
			from metrxn.newStoichiometryAbbr
			where RPflag = 'P') A order by reaction";
		
		
		$result = mysql_query("$query");
		showresults($result);
		
		die();
	}
	
	if($_POST['RXN_MET'] == 'SBML')
	{
	
	echo "<br />";
	echo "<font color=red><h4>Please note that we are currently in the process of updating our SBML's. There may exist certain errors that would prevent your programm from using the SBML directly. Thank you for your patience.</h4></font>";
	echo "<a href='../dumps/download.php?download_file=".$_POST["Organism"].".xml'>Download SBML here</a>";
	echo "<br />";
	die();
	}
	
						/*$result = mysql_query("SELECT Abbreviation,group_concat(distinct concat('<a href=../searchResults/results.php?searchString=',
									   replace(replace(Synonym, ' ', '&#32;'),'\'','&#39;'),
									   '&submit=Submit+Query&RXN_MET=',type,'&CURATION=true&abbr=',Abbreviation,'&src=','".$_POST["Organism"]."','>',
									   replace(replace(Synonym, ' ', '&#32;'),'\'','&#39;'),
									   '</a>')) grp_syn,count(distinct C.idRxn) cnt 
	FROM `metrxn`.`abbreviationsynonym_pin` A, `metrxn`.`source_pin` B, `metrxn`.`abbrsynrxnsrc_pin` C where 
	A.type = '" . $_POST["RXN_MET"] . "'
	and B.source = '" . $_POST["Organism"] . "'
	and A.idSource = B.idSourceName
	and A.idAbbreviationsSynonym = C.idAbbrSyn
	and A.idAbbreviationsSynonym not in (select idAbbrSyn from `metrxn`.`abbrsynstrsrcview` where source = '" . $_POST["Organism"] . "'
	and (checked is null or checked = 'true'))
	group by Abbreviation order by cnt desc");*/
	
	
	echo "<table>";
	
	
					 /*alignment table*/
                    if (isset($_POST['submit'])) {
					
						
						echo "<tr><td>"; /*alignment table*/
						
						echo "<h2> ".$RXN_MET_val." with known atomistic detail and one canonical association</h2> <br />";
						
						$queryBrowse1 ="SELECT DISTINCT abbr,curationComments,checkedByUser,
						group_concat(distinct `metrxn`.`synonymLink`(syn,null,null,type,'true',abbr,source)) grp_syn,checked, count(distinct cd_hash) cnt
						FROM `metrxn`.`abbrsynstrsrcview` where type = '" . $_POST["RXN_MET"] . "'
						and source = '" . $_POST["Organism"] . "'" 
						/*and abbr not in (SELECT distinct abbreviation from `metrxn`.`abbreviationsynonym_pin`
						where idsource = 16
						and type = 'metabolites')	
						*/
						." group by abbr,checked,checkedByUser,curationComments having cnt = 1 order by cnt desc";
						
						$result = mysql_query("SELECT DISTINCT abbr,curationComments,checkedByUser,
						group_concat(distinct `metrxn`.`synonymLink`(syn,'$synonymLinkPath',null,type,'true',abbr,source)) grp_syn,checked, count(distinct cd_hash) cnt
						FROM `metrxn`.`abbrsynstrsrcview` where type = '" . $_POST["RXN_MET"] . "'
						and source = '" . $_POST["Organism"] . "'" 
						/*and abbr not in (SELECT distinct abbreviation from `metrxn`.`abbreviationsynonym_pin`
						where idsource = 16
						and type = 'metabolites')	
						*/
						." group by abbr,checked,checkedByUser,curationComments having cnt = 1 order by cnt desc");

                        echo "Number of results: " . mysql_affected_rows();
						if(mysql_affected_rows() >0)
                        {
							echo "<table border=1>";
							echo "<th>Abbreviation</th>";
							echo "<th>Synonyms</th>";
							if($accessLevel == 'admin')
							{
								echo "<th>Validated as true</th>";
								echo "<th>Validated as false</th>";
								echo "<th>Validated by user</th>";
								echo "<th>User comments</th>";
							}
							//echo "<th>Canonical Associations</th>";
							
							if($accessLevel == 'admin')
							{                        
							while ($row = mysql_fetch_array($result)) 
								{
									echo "<tr><td>" . $row['abbr'] . "</td><td>" . $row['grp_syn'] . "</td><td><input type='radio' ";
									if($row['checked'] == 'true')
									echo "checked>";
									else echo ">";
									echo "<td><input type='radio' ";
									if($row['checked'] == 'false')
									echo "checked>";
									else echo ">";
									echo "</td><td>".$row['checkedByUser']."</td>";
									echo "<td>".$row['curationComments']."</td>";
									echo "<td>".$row['cnt']."</td>";
									echo "</tr>";
								}
							}
							else
							{
								while ($row = mysql_fetch_array($result))
								{		
								echo "<tr><td>" . $row['abbr'] . "</td><td>" . $row['grp_syn'] . "</td>";								
								//echo "<td>".$row['cnt']."</td>";
								echo "</tr>";
								}
							}
					
							echo "</table>";
						}	
						echo "</td></tr>"; /*alignment table*/
						
						echo "<tr><td>";
						echo "<h2> ".$RXN_MET_val." with known atomistic detail but multiple canonical associations</h2> <br />";                      
	 
	 					$result = mysql_query("SELECT DISTINCT abbr,curationComments,checkedByUser,
						group_concat(distinct `metrxn`.`synonymLink`(syn,'$synonymLinkPath',null,type,null,null,null)) grp_syn,checked, count(distinct cd_hash) cnt
						FROM `metrxn`.`abbrsynstrsrcview` where type = '" . $_POST["RXN_MET"] . "'
						and source = '" . $_POST["Organism"] . "'" 
						/*and abbr not in (SELECT distinct abbreviation from `metrxn`.`abbreviationsynonym_pin`
						where idsource = 16
						and type = 'metabolites')*/	
						." group by abbr,checked,checkedByUser,curationComments having cnt > 1 order by cnt desc");

                        echo "Number of results: " . mysql_affected_rows();
						
						if(mysql_affected_rows() >0)
                        {
							echo "<table border=1>";
							echo "<th>Abbreviation</th>";
							echo "<th>Synonyms</th>";
							if($accessLevel == 'admin')
							{
							echo "<th>Validated as true</th>";
							echo "<th>Validated as false</th>";
							echo "<th>Validated by user</th>";
							echo "<th>User comments</th>";
							}
							echo "<th>Canonical Associations</th>";
							
							if($accessLevel == 'admin')
							{
								while ($row = mysql_fetch_array($result)) 
								{
									echo "<tr><td>" . $row['abbr'] . "</td><td>" . $row['grp_syn'] . "</td><td><input type='radio' ";
									if($row['checked'] == 'true')
									echo "checked>";
									else echo ">";
									echo "<td><input type='radio' ";
									if($row['checked'] == 'false')
									echo "checked>";
									else echo ">";
									echo "</td><td>".$row['checkedByUser']."</td>";
									echo "<td>".$row['curationComments']."</td>";
									echo "<td>".$row['cnt']."</td>";
									echo "</tr>";
								}
							}
							else 
							{
								while ($row = mysql_fetch_array($result)) 
								{
									echo "<tr><td>" . $row['abbr'] . "</td><td>" . $row['grp_syn'] . "</td>";								
									echo "<td>".$row['cnt']."</td>";
									echo "</tr>";
								}
							}
							
							echo "</table>";
						}
						echo "</td></tr>"; /*alignment table*/
						
						
						echo "<tr><td>"; /*alignment table*/
						echo "<h2> ".$RXN_MET_val." with currently unresolved atomistic detail</h2> <br />";
							$result = mysql_query("SELECT Abbreviation,group_concat(distinct Synonym) grp_syn,count(distinct C.idRxn) cnt 
							FROM `metrxn`.`abbreviationsynonym_pin` A, `metrxn`.`source_pin` B, `metrxn`.`abbrsynrxnsrc_pin` C where 
							A.type = '" . $_POST["RXN_MET"] . "'
							and B.source = '" . $_POST["Organism"] . "'
							and A.idSource = B.idSourceName
							and A.idAbbreviationsSynonym = C.idAbbrSyn
							and A.idAbbreviationsSynonym not in (select idAbbrSyn from `metrxn`.`abbrsynstrsrcview` where source = '" . $_POST["Organism"] . "'
							and (checked is null or checked = 'true'))
							group by Abbreviation order by cnt desc");

                echo "Number of results: " . mysql_affected_rows();
						if(mysql_affected_rows() >0)
                        {
							echo "<table border=1>";
							echo "<th>Abbreviation</th>";
							echo "<th>Synonyms</th>";
							echo "<th>Reaction participation</th>";
							while ($row = mysql_fetch_array($result)) {
								echo "<tr><td>" . $row['Abbreviation'] . "</td><td>" . $row['grp_syn'] . "</td><td>".$row['cnt']."</td></tr>";
							}
							echo "</table>";
						}
                    }
					echo "</td></tr>"; /*alignment table*/
						
						
						echo "</table>"; /*alignment table*/
                    }

                    
                    
?>
</td>
</tr>
</table>
</body>
</html>