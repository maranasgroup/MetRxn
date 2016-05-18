<?php session_start();
session_start();
include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
$connPath = relativePath(getcwd(),$conn_php);
include($connPath);

$synonymLinkPath = str_replace('\\','\\\\',relativePath(getcwd(),$results_php)."?searchString=");
 
connect();
set_time_limit(60);
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
?>
<?php
	function showresults($result)
	{
		$i = 0;
		
                    
		echo "<table border='1' align=center cellpadding=0>";
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
<!DOCTYPE html>
<html lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>MetRxn Database of Costas D. Maranas. Penn State Department of Chemical Engineering</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--Custom CSS-->
  <link href="../css/labwebsite.css" rel="stylesheet"></link>
  <style>
    .container { padding: 0px !important;}

  </style>
	<script src="../Jmol-12.0.25-binary/jmol-12.0.25/Jmol.js"
		type="application/javascript">
	</script>
	<script type="text/javascript"
		SRC="http://www.chemaxon.com/marvin/marvin.js"></script>
	<script language="JavaScript" type="application/javascript">
	function makeactive(tab)
	{

		/*This function is called whenever we need to make something active, hile making others hidden*/
	<?php
	$var = str_ireplace("'","\'",$_GET["searchString"]);
	$type = $_GET["RXN_MET"];
	$fileType = "mol";
	if($type == "reactions")
	{
	$fileType = "rxn";
	}
	if($type == "metabolites")
	{
	$fileType = "mol";}

	/* in the while loop, each iteration will disable the tab and div */
	/*$result = mysql_query("SELECT SYNONYM syn,idStructures id,count(distinct sourceName) cnt FROM `biodb4`.`metabolitesynonyms` where synonym = '$var' and idStructures is not null group by SYNONYM,idStructures order by cnt desc;");*/

	if(isset($_GET['src']))
		$srcQueryAppend = " and A.source = '".$_GET['src']."' ";		


	$result = mysql_query("SELECT syn,abs(cd_hash) id,cd_hash, count(distinct source) cnt 
	FROM `metrxn`.`abbrsynstrsrcview` 
	where syn = '$var' 
	and cd_hash is not null 
	and cd_hash <> -1202985075 
	and type = '$type' $srcQueryAppend
	and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
			where A.idUser = B.idlogin and B.username = '".$username."') 
	group by syn,id order by cnt desc;");






	while($row = mysql_fetch_array($result))
	{
	if($type == "metabolites")
		{
			echo "document.getElementById(\"tab".$row['id']."\").className = \"hideM\";\n";
			echo "document.getElementById(\"image".$row['id']."\").className = \"\";\n";
		}
	if($type == "reactions")
		{
			echo "document.getElementById(\"tab".$row['id']."\").className = \"\";\n";
			echo "document.getElementById(\"image".$row['id']."\").className = \"hideR\";\n";
		}
	}
	?>
	document.getElementById("tab"+tab).className = "active";
	document.getElementById("image"+tab).className = "show";
	/*end of function makeactive(tab)*/}
	</script>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top navbar-custom" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand hidden-xs" href="index.htm">Penn State | Chemical and Biological Systems Optimization Lab | MetRxn</a>
      <a class="navbar-brand visible-xs" href="index.htm">Penn State | MetRxn</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../MetRxntest.php"><i class="fa fa-home"></i></a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="BrowseByOrganism_new.php">Organism</a></li>
          <li class="active"><a href="comparisons_new.php">Comparisons</a></li>
        </ul>
        </li>
                <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Documentation
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../Documentation.html">About MetRxn</a></li>
        </ul>
        </li>
        <li><a href="mailto:costas@psu.edu">Contact</a></li>
        <li><a href="../MetRxntest.php">Login</a></li>
        <li><a href="http://www.maranasgroup.com">Maranas Group</a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="padding: 50px">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 result">

		<ul id="tabmenu">
		  <!--We create the list dynamically according to the number of results, where each list element is later transformed into a tab element by the result and tabmenu div-->
		<?php
		if($type == "metabolites" || $type == "reactions")
		{  
		/* $result = mysql_query("SELECT distinct syn,abs(cd_hash) id,count(distinct source) cnt 
				FROM `metrxn`.`abbrsynstrsrcview` 
				where syn = '$var' 
				and cd_hash is not null 
				and cd_hash <> -1202985075 
				and type = '$type'
				and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')		
				group by syn,id order by cnt desc;"); */

		$srcQueryAppend = "";		
		if($type == 'metabolites')
		{

		$appendLimitText = " limit 1";
		}
		else if($type == 'reactions')
		{
		$appendLimitText = "";		
		$queryMultipleReactions = "select count(distinct cd_hash) cnt from `metrxn`.`abbrsynstrsrcview` where syn = '$var' and type = '$type' and 
				idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '$username');";
		$resultMultipleReactions = mysql_query($queryMultipleReactions);
		if(isset($_GET['src']))
			$srcQueryAppend = " and A.source = '".$_GET['src']."' ";		
		}
		$tabQuery = "select * from(SELECT distinct syn,abs(A.cd_hash) id,count(distinct source) cnt,count(distinct idSrc) cnt2  
				FROM `metrxn`.`abbrsynstrsrcview` A,`metrxn`.`abbrsynstrsrc` `B`
				where syn = '$var' 
				and A.cd_hash is not null
				and A.cd_hash = B.cd_hash	
				and A.cd_hash <> -1202985075 
				and type = '$type' $srcQueryAppend
				and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')		
				group by syn,id order by cnt desc,cnt2 desc) A$appendLimitText;";
		$result = mysql_query($tabQuery);

		//echo $tabQuery;


				
		$resultCount = mysql_affected_rows();
		if($resultCount == 0)		
		{
		echo "<h3><b>'".$var."'</b> not found, Please change you search criteria</h3>";
		}
		/*changes
		 instead of idstr, we will use abs(cd_hash) to pass as tab number*/
		 /**look at this carefully**/
		$count = 1;
		if($resultCount >= 1)		
		{
			while($row = mysql_fetch_array($result))
			{
				$id = $row['id'];
				
				/*This line makes all the tabs inactive, by setting the class as null*/
				echo "<li onclick=\"makeactive(".$row['id'].")\"><a class=\"\" id=\"tab".$row['id']."\">".$row['syn']."</a></li>\n";	
				if($count ==1)
				{
					/*make the first tab active */
					echo "<body onload=\"makeactive(".$row['id'].")\">";
					
					
				}
				$count = $count + 1;		
				
					
			}
		}
		}
		else if ($type == "ec")
		{
			echo "<li ><a>".$var."</a></li>\n";
		}
		?>
		</ul>
		<?php
		mysql_query("set group_concat_max_len = 2147483647;");

		if($type == 'metabolites')
			$appendText = "limit 1;";
		else if($type == 'reactions')
			$appendText = ";";
		else if($type == 'ec')
		{
		$result = mysql_query("Select distinct source `Source`, group_concat(distinct metrxn.SynonymLink(G.Synonym,'$synonymLinkPath',null,'reactions',null,null,null) separator ', ') `Reaction names`,
		group_concat(distinct metrxn.SynonymLink(E.Synonym,'$synonymLinkPath',null,'metabolites',null,null,null) separator ', ') `Metabolite names`
		from metrxn.abbrsynrxnsrc A,
		metrxn.source B,metrxn.abbreviationsynonym C,metrxn.abbrsynrxnsrc D,
		metrxn.abbreviationsynonym E, metrxn.abbrsynrxnsrc F,metrxn.abbreviationsynonym G,
		metrxn.abbrsynstrsrc H,metrxn.abbrsynstrsrc I
		where A.idSrc = B.idSourceName
		and C.Synonym = '$var'
		and C.type = 'ec'
		and C.idAbbreviationsSynonym = A.idAbbrSyn
		and A.idRxn = D.idRxn
		and E.idAbbreviationsSynonym = D.idAbbrSyn
		and D.idAbbrsyn = H.idAbbrSyn
		and E.type = 'metabolites'
		and A.idRxn = F.idRxn
		and G.idAbbreviationsSynonym = F.idAbbrSyn
		and F.idAbbrsyn = I.idAbbrSyn
		and G.type = 'reactions'
		group by source;");
		echo "<table>";
		echo "<table border=1>"; /*for the text before the table*/
					
					
		echo "<tr><th>This page shows the result for the various reactions that are classfied under ec:$var, along with the corresponding metabolites. Please click on the link below to download the searchresults as an SBML file</th></tr>";
				echo "</table>";
				
				echo "<tr><td><a href=>SBML</a></td></tr>";
				
				echo "<tr><td align=left>";
				showresults($result);
				echo "</tr></td>";
				
		echo "</table>";		
		exit();
		}
		$result = mysql_query("select * from (SELECT distinct syn,abs(cd_hash) id,cd_hash,count(distinct source) cnt 
		FROM `metrxn`.`abbrsynstrsrcview` A where syn = '$var' $srcQueryAppend
		and cd_hash is not null and cd_hash <> -1202985075
		and errorInChargeCalculation is null 
		and type = '$type' 
		and idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
		group by syn,id order by cnt desc) A ".$appendText);
		while($row = mysql_fetch_array($result))
		{
			
			echo "<div class=\"hide\" id=\"image".$row['id']."\">\n";
			echo "<table>";	
			
			if(isset($_GET['src']))
			{
				/*Why do we have this over here ????*/
				$src = $_GET['src'];
				if($src)
				{
					echo "<tr height=40px><td>";
					$result2 = mysql_query("select distinct coalesce(B.reactionAsAbbreviation,B.reactionAsSynonym) rxnRep,
					A.syn from `metrxn`.abbrsynstrsrcview A, `metrxn`.reaction_pin B
					where A.type = '$type'
					and A.idStr = B.rxn_cd_id
					and cd_hash = ".$row['cd_hash']."
					and A.syn = '$var'
					and A.source = '$src'
					and A.idSource = B.idSource
					and A.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
					where A.idUser = B.idlogin and B.username = '".$username."')
					and B.rxn_cd_id is not null");

					$resultCount = mysql_affected_rows();

					if($resultCount != 0)
					{	
						
						echo "<u>As it appears in <b>".$src."</b>:".nl2br("\n").nl2br("\n")."</u>";
						
					}
					
					$type_text = "";
					if($type == 'reactions')
					$type_text = "reaction";
					else if($type == 'metabolites')
					$type_text = "metabolite";
					
					while($row2 = mysql_fetch_array($result2))
					{
						
						echo $row2['rxnRep'].nl2br("\n");
						echo nl2br("\n");
						
						$generalLink = "";
						$resultGL = mysql_query("SELECT distinct metrxn.SynonymLink('$var','$synonymLinkPath',null,'$type',null,null,null) 'link'");
						while($rowGL = mysql_fetch_array($resultGL))
						{
							$generalLink = $rowGL['link'];
						}
						
					}
					
					//echo "<tr height=40px><td>";
					
					$RxnDispQuery = "select group_concat(`syn` separator ' <=> ') AS `rxnRep` from (select group_concat(`syn` separator ' + ') `syn` 
								from (
								SELECT metrxn.split_str(group_concat(
															concat(
																coalesce(
																	oldStoichiometry,newStoichiometry,1),' ',syn
																	)  
																order by length(syn)),',',1) `syn`,
								Abbr,metrxn.get_product_reactant_flag(reactionAsAbbreviation,Abbr) `loc`
								FROM `metrxn`.`abbrsynstrrxnsrcview` A,
								(select idRxn from `metrxn`.`abbrsynstrrxnsrcview` where cd_hash = ".$row['cd_hash'].") B 
								where source = '$src'
								and A.idRxn = B.idRxn 
								and type = 'metabolites'
								group by Abbr,`loc`) A group by `loc` order by `loc` desc) A;";
					//echo $RxnDispQuery;
					
											
					$resultRxnDisp = mysql_query($RxnDispQuery);
					
					$resultCount = mysql_affected_rows();
					
					while($rowRxnDisp = mysql_fetch_array($resultRxnDisp))
					{
						//echo "WHAT";
						echo $rowRxnDisp['rxnRep'].nl2br("\n");
						echo nl2br("\n");			
						
					}
					
					echo "<p> This page shows $type_text information that is specific to <b>".$src."</b>, you may also search for this $type_text across other metabolic models and databases by clicking on -> $generalLink </p>";
					
					echo "</td></tr>";
					

					$result2 = mysql_query("SELECT A.abbr,
						   A.syn,
						   A.type,
						   A.source,
						   A.idStr,
						   C.abbr abbrmet,
						   group_concat(distinct metrxn.synonymLink(C.syn,'$synonymLinkPath',null,C.type,null,null,null) separator ', ') syngrp,
						   C.idStr,
						   D.cd_smiles,
						   group_concat(distinct metrxn.synonymLink(F.synonym,'$synonymLinkPath',null,'ec',null,null,null) separator ', ' ) `ecLink`
					  FROM ((((metrxn.abbrsynstrsrcview A join
						   metrxn.reaction_pin B ) join
						   metrxn.abbrsynstrrxnsrcview C) join
						   Jchem.importedstructures D) LEFT join (metrxn.abbrsynrxnsrc E join metrxn.abbreviationsynonym F) 
						   on B.idReaction = E.idRxn and E.idAbbrSyn = F.idAbbreviationsSynonym and F.type = 'ec')
					 WHERE     A.type = 'reactions'
						   AND A.idStr = B.rxn_cd_id				   
						   AND A.syn = '$var'
						   AND A.source = '$src'
						   AND B.idreaction = C.idRxn
						   AND A.idSource = C.idSource
						   and A.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
						where A.idUser = B.idlogin and B.username = '".$username."')
						   AND C.idStr = D.cd_id				   
					GROUP BY abbrmet order by A.type desc;");

					$resultCount = mysql_affected_rows();

					if($resultCount != 0)
					{
						echo "<tr height=40px><td>";
						echo "<table border=1>
					<tr bgcolor=#C4D8F1>
					<th>Abbreviations</th>
					<th>Names</th>
					<th><a href='http://www.daylight.com/dayhtml/doc/theory/theory.smiles.html'>SMILES</a></th>
					<th>EC number(s)</th>
					</tr>";
							
							
						while($row2 = mysql_fetch_array($result2))
						{
							echo "<tr>";
							echo "<td>" . $row2['abbrmet'] . "</td>";
							echo "<td>" . $row2['syngrp'] . "</td>";
							echo "<td>" . $row2['cd_smiles'] . "</td>";
							echo "<td>" . $row2['ecLink'] . "</td>";
							echo "</tr>";
						}
						echo "</table>";
					echo "</td></tr>";
					}
				}

			}

			echo "<tr><td>";
			/*$result9 = mysql_query("SELECT DISTINCT cd_id,@cnt := @cnt + 1 `cnt` FROM Jchem.importedstructures,(Select @cnt := -1) B 
			WHERE cd_hash = '".$row['cd_hash']."' limit 1;");
			This Query has to be put back, And a lot of the structure files have to be reloaded
			Absolutely important,The query below is just a temporary fix
			*/
			$result9 = mysql_query("SELECT DISTINCT idStr `cd_id`,@cnt := @cnt + 1 `cnt` FROM `metrxn`.`abbrsynstrsrc_pin`,(Select @cnt := -1) B 
			WHERE cd_hash = '".$row['cd_hash']."' order by idStr limit 1;");
			$resultCount = mysql_affected_rows();
				
			if($resultCount >= 3)
			{
				$colval = 3;		
			}
			else if($resultCount < 3)
			{
				$colval = $resultCount;
			}
			else
			{
				$colval = 2;
			}
			if($resultCount % $colval == 0)
				{
					
					$rowval = $resultCount/$colval;
				}
			else 
				{
					$rowval = floor($resultCount/$colval + 1);
				}
				
			echo "<script type=text/javascript>\n";
				
			/*if($resultCount % $col == 0)
				$row = $resultCount/$col;
			else 
				$row = $resultCount/$col + 1;	
				echo $row;*/
			$marvinPath = relativePath(getcwd(),$marvin_folder);
			

			
			if($type == "reactions")
			{
				echo "mview_begin('../marvin', 800, 400);\n";
			}
			else
			{
				echo "mview_begin('../marvin', 400, 200);\n";
			}

			echo "mview_param('rows', '".$rowval."');\n";
			echo "mview_param('cols', '".$colval."');\n";

			while($row9 = mysql_fetch_array($result9))
			{
				echo "mview_param('cell".$row9['cnt']."', '|../StructureFile/".$row9['cd_id'].".".$fileType."');\n";
		/*			echo "mview_param('mol', '../StructureFile/".$row9['cd_id'].".".$fileType."');\n";*/
			}
			echo "mview_end();\n";
			echo "</script>";
			echo "</td></tr>";	
			
			echo "<tr><td>";
			echo "<a href='ShowAllStructures.php?cd_hash=".$row['cd_hash']."&fileType=".$fileType."&type=".$type."' target=_blank>ShowAll</a>";	
			echo "</td></tr>";
			echo "<tr><td>";
			
				echo "<table>";
				echo "<table border=1>"; /*for the text before the table*/
				echo "<tr><th>The reactions displayed on this page along with the corresponding metabolites and balanced stoichiometry is available in SBML below</th></tr>";
				echo "</table>";
					
				echo "<tr><td><a href=>SBML</a></td></tr>";
					
				echo "</table>";
			
			
			if($accessLevel == 'admin')
			if(isset($_GET['CURATION']))
			{
				if($_GET['CURATION'] == 'true')
				{
					echo "Is this structure valid for the abbreviation " .$_GET['abbr'] ." in the model/database " .$_GET['src'];
					echo "<form action='../browse/BrowseByOrganism.php' method=post>";
					echo "<input type='radio' name='curationBool' value='true' /> yes ";// 
		            echo "<input type='radio' name='curationBool' value='false' /> no ";//
					echo "<input type='text' name='curationComments' value='' /> Comments "; 
		            echo "<input type='hidden' name='RXN_MET' value='".$_GET['RXN_MET']."'/>";
					echo "<input type='hidden' name='Organism' value='".$_GET['src']."'/>";
					echo "<input type='hidden' name='abbr' value='".$_GET['abbr']."'/>";
					echo "<input type='hidden' name='cd_hash' value='".$row['cd_hash']."'/>";
					echo "<input type='submit' name = 'submit' value='submit' />";			
		            /*"<?=$name?>"*/
					echo "</form>";
				}
			}
			
			
			if($type=='metabolites')
			{
			
			$result2 = mysql_query("select A.cd_smiles smiles,
			trim(Group_concat(distinct concat('<a href=',B.linkout,' target=_blank>',B.source,'</a>') order by sourceType separator ', ')) src
			from `Jchem`.`importedstructures` A,
			`metrxn`.`abbrsynstrsrcview` B 
			WHERE A.cd_id = B.idStr 
			and B.cd_hash = ".$row['cd_hash']."
			and B.syn = '$var' 
			and type = '$type'
			and B.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
			group by A.cd_smiles;");
			
			echo "<table border=1>"; /*for the text before the table*/
			echo "<tr><th><a href='http://www.daylight.com/dayhtml/doc/theory/theory.smiles.html'>SMILES Representations</a></th></tr>";
			echo "</table>";/*for the text before the table*/
			
			
			
				echo "<table border=1>
				<tr bgcolor=#C4D8F1>
				<th>Source</th>
				<th><a 'http://www.daylight.com/dayhtml/doc/theory/theory.smiles.html'>SMILES</a></th>
				</tr>";
				while($row2 = mysql_fetch_array($result2))
				{
					echo "<tr>";
					echo "<td>" . $row2['src'] . "</td>";
					echo "<td width=100% white-space: -moz-pre-wrap;>" . $row2['smiles'] . "</td>";
					echo "</tr>";
				}	
				
				echo "</table>";	
			

			
			}
			echo "</td></tr>";
			echo "<tr><td>";
			
			echo "<table border=1>"; /*for the text before the table*/
			if($type == "metabolites")	
				{
					$text = "Metabolite names in databases and models";
					$rxnQueryAppend1 = "";
					$rxnQueryAppend2 = "";
					$rxnQueryAppend3 = "";
				}
			else 
				{
					$text = "Reaction names in other databases and models";
					$rxnQueryAppend1 = "F.reactionAsAbbreviation rxnAbbr,";
					$rxnQueryAppend2 = " join `metrxn`.`reaction_pin` F ";
					$rxnQueryAppend3 = " and C.idStr = F.rxn_cd_id
		 			and F.idSource = E.idSourceName 
					and E.idSourceName in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')";
					$rxnQueryAppend4 = " left join 
			(metrxn.abbrsynrxnsrc H join metrxn.abbreviationsynonym I) on H.idRxn = F.idreaction and H.idAbbrSyn = I.idAbbreviationsSynonym and I.type = 'ec' ";
				$rxnQueryAppend5 = " ,group_concat(distinct metrxn.synonymLink(I.synonym,'$synonymLinkPath',null,'ec',null,null,null) separator ', ') `ecLink` ";
				}
			echo "<tr><th>".$text."</th></tr>";
			echo "</table>";
			
			/*Link to syn has been removed, we need to put this back*/
			if(isset($_GET['src']))
			{$result2 = mysql_query("SELECT E.source src,".$rxnQueryAppend1." group_concat(distinct D.Abbreviation separator ', ') `Abbreviations`, group_concat(distinct concat('<a href=results.php?searchString=',replace(D.synonym,' ','&#32;'),'&submit=Submit+Query&RXN_MET=".$type."&src=',E.source,'>',replace(D.synonym, ' ', '&#32;'),'</a>') separator ', ') synLink,group_concat(distinct D.synonym separator ', ') syn, count(distinct D.synonym) cnt
			FROM `metrxn`.`abbreviationsynonym` A,`metrxn`.`abbrsynstrsrc` B,`metrxn`.`abbrsynstrsrc` C,`metrxn`.`abbreviationsynonym` D,`metrxn`.`source` E".$rxnQueryAppend2."
			where A.synonym = '$var'
			and A.type = '$type'
			and A.idAbbreviationsSynonym = B.idAbbrsyn
			and B.idStr = C.idStr
			and B.cd_hash = '".$row['cd_hash']."'
			and C.idStr <> 48201
			and C.idAbbrsyn = D.idAbbreviationsSynonym
			and C.idSrc = E.idSourceName ".$rxnQueryAppend3."
			and E.source <> '$src'
			and E.idSourceName in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')	
			group by src
			order by E.sourceType;");
			/*put a link here, that would allow the user to navigate to a general page. */
			}
			/*Link to syn has been removed, we need to put this back*/
			$query = "SELECT E.source src,".$rxnQueryAppend1." group_concat(distinct D.Abbreviation separator ', ') `Abbreviations`,B.formula, 
			group_concat(distinct metrxn.synonymLink(D.synonym,'$synonymLinkPath',NULL,'reactions',NULL,NULL,E.source) separator ', ') synLinkR,
			group_concat(distinct metrxn.synonymLink(D.synonym,'$synonymLinkPath',NULL,'metabolites',NULL,NULL,E.source) separator ', ') synLinkM, 
			count(distinct D.synonym) cnt
			".$rxnQueryAppend5."
			FROM ((((((`metrxn`.`abbreviationsynonym` A JOIN `metrxn`.`abbrsynstrsrc` B ) join `metrxn`.`abbrsynstrsrc` C ) join 
			`metrxn`.`abbreviationsynonym` D ) join `metrxn`.`source` E) ".$rxnQueryAppend2.")".$rxnQueryAppend4." )
			where A.synonym = '$var'
			and A.type = '$type'
			and A.idAbbreviationsSynonym = B.idAbbrsyn
			and B.cd_hash = C.cd_hash
			and B.cd_hash = '".$row['cd_hash']."'
			and C.idStr <> 48201
			and C.idAbbrsyn = D.idAbbreviationsSynonym
			and C.idSrc = E.idSourceName ".$rxnQueryAppend3."
			and E.idSourceName in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
			group by src
			order by E.sourceType;";
			
			if($type == "metabolites")
			{
						
				$query = "select distinct A.source src ,group_concat(distinct A.abbr separator ', ') `Abbreviations`,count(distinct A.syn) cnt,
				group_concat(distinct metrxn.synonymLink(A.syn,'$synonymLinkPath',null,A.type,null,null,null) separator ', ') `synLinkM`,
		    group_concat(distinct metrxn.synonymLink(D.synonym,'$synonymLinkPath',null,'ec',null,null,null) separator ', ') `ecLink`
				from (
		            (`metrxn`.`abbrsynstrsrcview` A) 
		            left join 
		            (
		            (metrxn.abbrsynrxnsrc B join metrxn.abbrsynrxnsrc C) 
		                join `metrxn`.`abbreviationsynonym` D)
		          on A.idAbbrSyn = B.idAbbrSyn and B.idRxn = C.idRxn
		        and C.idAbbrSyn = D.idAbbreviationsSynonym
		        and D.type = 'ec')      
		        where cd_hash = '".$row['cd_hash']."'                
				group by source order by `ecLink` desc;";
				
			}
			$result2 = mysql_query($query);
			
			
			
			//echo $query;
			//echo $query;
			
			/*for the text before the table*/
				
			echo "<table border=1>
			<tr bgcolor=#C4D8F1>
			<th>Source</th>
			<th>Names</th>
			<th>Abbreviations</th>";
			
			
			if($type == 'reactions')
			{
			echo "<th>EC number(s)</th>";
			echo "<th>Formula</th>";
			echo "<th>Reactions</th>";
			}echo "</tr>";
			
			while($row2 = mysql_fetch_array($result2))
			{
				echo "<tr>";
				echo "<td>" . $row2['src'] ."<font color:blue>"."(".$row2['cnt'].")"."</font>"."</td>";
				
				if($type == 'reactions')
					echo "<td>" . $row2['synLinkR'] . "</td>";
				else if($type == 'metabolites')
					echo "<td>" . $row2['synLinkM'] . "</td>";
				
				echo "<td>" . $row2['Abbreviations'] . "</td>";
				
				if($type == 'reactions')
				{
				echo "<td>" . $row2['ecLink'] . "</td>";
				echo "<td>" . $row2['formula'] . "</td>";
				echo "<td>" . $row2['rxnAbbr'] . "</td>";		
				}
				
				echo "</tr>";
			}	
			
			echo "</td></tr>";
			
			echo "</table>";
			
			if($type == "metabolites")
			{
				/*$result2 = mysql_query("select group_concat(distinct C.reactionAsSynonym) rxn, concat(B.source,'(',count(distinct reactionAsSynonym),')') src
				 from `metrxn`.`abbrsynrxnsrc` A,`metrxn`.`source` B,`metrxn`.`reaction`C,`metrxn`.`abbreviationsynonym` D
				 where A.idSrc = B.idSourceName
				 and A.idAbbrSyn = D.idAbbreviationsSynonym
				 and D.synonym = '$var'
				 and D.type = '$type'
				 and A.idRxn = C.idReaction
				 group by B.source;");*/
				echo "<tr><td>";
				/*$result2 = mysql_query("SELECT group_concat( distinct 
		          concat(
		             ' ',
		             coalesce(concat('<a href=results.php?searchString=',
		                             replace(A.syn, ' ', '&#32;'),
		                             '&submit=Submit+Query&RXN_MET=reactions&src=',A.source,'>',
		                             replace(A.syn, ' ', '&#32;'),
		                             '</a>'),
		                      concat('<a href=results.php?searchString=',
		                             replace(B.reactionAsAbbreviation, ' ', '&#32;'),
		                             '&submit=Submit+Query&RXN_MET=reactions&src=',A.source,'>',
		                             replace(B.reactionAsAbbreviation, ' ', '&#32;'),
		                             '</a>'),
		                      concat('<a href=results.php?searchString=',
		                             replace(B.reactionAsSynonym, ' ', '&#32;'),
		                             '&submit=Submit+Query&RXN_MET=reactions&src=',A.source,'>',
		                             replace(B.reactionAsSynonym, ' ', '&#32;'),
		                             '</a>'),
		                      concat('<a href=results.php?searchString=',
		                             replace(A.abbr, ' ', '&#32;'),
		                             '&submit=Submit+Query&RXN_MET=reactions&src=',A.source,'>',
		                             replace(A.abbr, ' ', '&#32;'),
		                             '</a>'))))
		          			rxnName,
						   B.idReaction,
						   A.source src,
						   C.abbr,
						   C.syn
					  FROM `metrxn`.`abbrsynstrsrcview` A,
						   `metrxn`.`reaction_pin` B,
						   `metrxn`.`abbrsynstrrxnsrcview` C
					 WHERE     A.type = 'reactions'
						   AND A.idStr = B.rxn_cd_id
						   AND B.rxn_cd_id IS NOT NULL
						   AND B.idReaction = C.idRxn
						   AND C.type = '$type'
						   AND C.syn = '$var'
						   AND C.cd_hash = ".$row['cd_hash']."
						   and A.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
						   and C.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
					GROUP BY syn, A.source
					order by A.sourceType;"); */
				$queryReactionParticipation = "SELECT group_concat(
			distinct concat(' ',`metrxn`.`synonymLink`(coalesce(A.syn,B.reactionAsAbbreviation,B.reactionAsSynonym,A.abbr),
			'$synonymLinkPath',null,'reactions',null,null,A.source)) separator ', ') rxnName,
						   group_concat(B.idReaction separator ', ') idReaction,
						   A.source src,
						   group_concat(C.abbr separator ', ') abbr,
						   group_concat(C.syn separator ', ') syn,group_concat(distinct metrxn.synonymLink(E.synonym,'$synonymLinkPath',null,'ec',null,null,null) separator ', ') `ecLink`
					  FROM (((`metrxn`.`abbrsynstrsrcview` A join
						   `metrxn`.`reaction_pin` B) join
						   `metrxn`.`abbrsynstrrxnsrcview` C) left join (metrxn.abbrsynrxnsrc D join metrxn.abbreviationsynonym E) 
						   on B.idReaction =  D.idRxn and D.idAbbrSyn = E.idAbbreviationsSynonym and E.type = 'ec')
					 WHERE     A.type = 'reactions'
						   AND A.idStr = B.rxn_cd_id
						   AND B.rxn_cd_id IS NOT NULL
						   AND B.idReaction = C.idRxn
						   AND C.type = '$type'				   
						   AND C.cd_hash = ".$row['cd_hash']."
						   and A.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
						   and C.idSource in (select distinct A.idSource from `metrxn`.`source_user_pin` A,`metrxnweb`.`login` B
				where A.idUser = B.idlogin and B.username = '".$username."')
					GROUP BY A.source
					order by `ecLink` desc,A.source;";		
				$result2 = mysql_query($queryReactionParticipation); 		
		//echo $queryReactionParticipation;

				$resultCount = mysql_affected_rows();

				if($resultCount != 0)
				{	
					echo "<table border=1>"; /*for the text before the table*/
					echo "<tr><th>Reaction participation in other databases and metabolic models</th></tr>";
					echo "<table border=1>
				<tr bgcolor=#C4D8F1>
				<th>Source</th>
				<th>Reaction names</th>
				<th width=100%>EC number(s)</th>
				</tr>";
				}	

				while($row2 = mysql_fetch_array($result2))
				{
					echo "<tr>";
					echo "<td>" . $row2['src']. "</td>";
					echo "<td>".$row2['rxnName'] ."". "</td>";
					echo "<td>".$row2['ecLink'] ."". "</td>";
					/* <a href=../browse/reactions.php target=_blank style=\"text-decoration:underline; color:#3032A1\">more . . . </a> */
					echo "</tr>";
				}
				echo "</table>";
				echo "</table>";/*for the text before the table*/
				
				$queryCompartmentParticipation = "SELECT distinct A.Synonym `Compartments` FROM `metrxn`.`Compartment` A,`metrxn`.`abbrsynstrsrcview` B, `metrxn`.`abbrsynrxnsrc_pin` C
						where B.idAbbrSyn = C.idAbbrSyn
						and C.compartment = A.Abbr
						and cd_hash = ".$row['cd_hash'] ." and A.Synonym is not null;";
				$result = mysql_query("$queryCompartmentParticipation");
				$resultCount = mysql_affected_rows();		
				
				echo "<div align=center>";
				if($resultCount != 0)
				{	
					echo "<table align=center border=1>"; /*for the text before the table*/
					echo "<tr align=center><th>This metabolite occurs in the following compartment(s) across various metabolic models and databases</th></tr>";
					echo "<table border=1>
				<tr bgcolor=#C4D8F1>
				<th>Compartment</th>
				</tr>";
				}	

				while($row2 = mysql_fetch_array($result))
				{
					echo "<tr>";
					echo "<td>" . $row2['Compartments']. "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</table>";
				echo "</div>";
			}
			
			 /*?>if($type == "reactions")
			{
				/*$result2 = mysql_query("select group_concat(distinct C.reactionAsSynonym) rxn, concat(B.source,'(',count(distinct reactionAsSynonym),')') src
				 from `metrxn`.`abbrsynrxnsrc` A,`metrxn`.`source` B,`metrxn`.`reaction`C,`metrxn`.`abbreviationsynonym` D
				 where A.idSrc = B.idSourceName
				 and A.idAbbrSyn = D.idAbbreviationsSynonym
				 and D.synonym = '$var'
				 and D.type = '$type'
				 and A.idRxn = C.idReaction
				 group by B.source;");
				echo "<tr><td>";
				$result2 = mysql_query("SELECT group_concat(distinct concat('<a href=results.php?searchString=',replace(B.syn, ' ', '&#32;'),'&submit=Submit+Query&RXN_MET=metabolites>',replace(B.syn, ' ', '&#32;'),'</a>')) synGrp,
							C.cd_smiles smiles 
							FROM `metrxn`.`abbrsynstrrxnsrcview` A, 
							`metrxn`.`abbrsynstrrxnsrcview` B,`Jchem`.`importedstructures` C 
							where A.syn = '$var'
							and A.type = 'reactions'
							and A.cd_hash = ".$row['cd_hash']."
							and B.type = 'metabolites'
							and A.idRxn = B.idRxn					
							and B.cd_hash = C.cd_hash
							group by B.cd_hash;");

				$resultCount = mysql_affected_rows();

				if($resultCount != 0)
				{	
					echo "<table border=1>"; /*for the text before the table
					echo "<tr><th>Metabolites and its SMILES representation for this reaction</th></tr>";
					echo "<table border=1>
				<tr bgcolor=#C4D8F1>
				<th>Synonyms</th>
				<th>SMILES</th>
				</tr>";}	

				while($row2 = mysql_fetch_array($result2))
				{
					echo "<tr>";
					echo "<td>" . $row2['synGrp']. "</td>";
					echo "<td>".$row2['smiles'] ."". "</td>";
					/* <a href=../browse/reactions.php target=_blank style=\"text-decoration:underline; color:#3032A1\">more . . . </a> 
					echo "</tr>";
				}
				echo "</table>";
				echo "</table>";/*for the text before the table

			}<?php */
			echo "</td></tr>";
			
			echo "</div>\n";
			echo "</table>";
			
			echo "</div>";
			
			
			
		}

		?>
	</div></div></div></div>
<div class="footer">
<?php
echo "<table width=100%>";
	
	echo "<tr><td align=center>";
	while($rowresultMultipleReactions = mysql_fetch_array($resultMultipleReactions))
	{
		if($rowresultMultipleReactions['cnt'] > 1)
		{
		
		echo "<p> This page shows different reactions with the same name as <b>'$var'</b>. Each reaction shows up in a different tab and varies according to metabolite participation </p>";
		//echo nl2br("\n");
		}
		
	}
	echo "</td></tr>";
	echo "</table>";	
mysql_close();
?>
</div>

</body>
</html>
