<?php 
if(!isset($_SESSION))
{
include_once($path);
session_start();


include("pathToGlobalVariables.php");
include($pathToGlobalVariables);
include($conn_php);
connect();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Left Menu</title>
   	<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="../metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="../anchors.css" rel="stylesheet" type="text/css" />
	<link href="../headings.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	color: #3032A1;
}
</style>
</head>

<body>
<td class="leftmenucell" id="leftmenucell">
<div class="leftmenu" id="leftmenu" style="width: 160px; visibility: visible; display: block;" align="left">
<!--div style="padding: 2px"></div-->
<ul id="sidemenuid" class="sidemenu">
	<li class="clickmeopen" style="color:#000000;">
		<a href="<?php echo relativePath(getcwd(),$MetRxn_php); ?>" target="_parent" title="MetRxn Home" onmouseover="(window.status='MetRxn Home'); return true;" onmouseout="(window.status='');">MetRxn Home</a></li>
	<!--<li style="color:#000000;">
		<a href="/MetRxn/AdvancedSearch/advancedSearch.php" target="_parent" title="Advanced search of chemical compounds" onmouseover="(window.status='Advanced search of chemical compounds'); return true;" onmouseout="(window.status='');">
         Advanced Search</a></li>-->
	<li><a href="#"></a>Browse
   		<ul class="menusub">
		   	<li><a href="<?php echo relativePath(getcwd(),$BrowseByOrganism_php); ?>" target="_parent" title="Browse the reaction equations within the MetRxn database" onmouseover="(window.status='Browse the reaction equations within the MetRxn database'); return true;" onmouseout="(window.status='');">
       		  Organism </a></li>
              <li><a href="<?php echo relativePath(getcwd(),$comparisions_php); ?>" target="_parent" title="Model comparisions in MetRxn database" onmouseover="(window.status='Model comparisions in MetRxn database'); return true;" onmouseout="(window.status='');">
       		  Comparisons </a></li>
			<!--<li><a href="/MetRxn/browse/AE.php" title="Shows the metabolite listing within this database" onmouseover="(window.status='Shows the metabolite listing within this database'); return true;" onmouseout="(window.status='');">
             Metabolites </a></li>-->
		</ul>
     </li>   
		<!--<li><a href="../PageUnderConstruction.html" title="Submit new entries to MetRxn via our submission tool." onmouseover="(window.status='Submit new entries to MetRxn via our submission tool.'); return true;" onmouseout="(window.status='');" target="_blank">
       Submissions </a></li>-->
		<!--<li><a href="../PageUnderConstruction.html" title="Download MetRxn in its entirety via FTP" onmouseover="(window.status='Download MetRxn in its entirety via FTP'); return true;" onmouseout="(window.status='');">
       Downloads </a></li>-->
      	<!--<li><a href="../PageUnderConstruction.html"></a>Tools</li>-->
      	<!--<li><a href="../PageUnderConstruction.html" title="MetRxn statistics" onmouseover="(window.status='MetRxn statistics'); return true;" onmouseout="(window.status='');">
             Statistics</a></li>-->
             <!--<li><a href="/MetRxn/upload/upload.php" title="MetRxn statistics" onmouseover="(window.status='MetRxn statistics'); return true;" onmouseout="(window.status='');">
             Upload</a></li>-->
		<li><a href="#"></a>Documentation
            <ul class="menusub">
                    <li><a href="<?php echo relativePath(getcwd(),$Documentation_php); ?>" target="_parent" title="Know more about the MetRxn" onmouseover="(window.status='Know more about the MetRxn'); return true;" onmouseout="(window.status='');">
                            About MetRxn</a></li>
                    <!--<li><a href="../PageUnderConstruction.html" title="Tutorial" onmouseover="(window.status='Tutorial'); return true;" onmouseout="(window.status='');">
                           Tutorial </a></li>
                    <li><a href="../PageUnderConstruction.html" title="Frequently Asked Questions" onmouseover="(window.status='Frequently Asked Questions'); return true;" onmouseout="(window.status='');">
                           FAQ's </a></li>-->
                    <!--li><a href="../PageUnderConstruction.html" title="User manual" onmouseover="(window.status='User manual'); return true;" onmouseout="(window.status='');">
                           User Manual </a></li-->
                    <!--<li><a href="../PageUnderConstruction.html" title="Recently resolved entity" onmouseover="(window.status='Recently resolved entity'); return true;" onmouseout="(window.status='');">
                           Recently resolved entity </a></li>
                    <li><a href="http://metrxn.engr.psu.edu/forum" title="Join the discussion groups at the SourceForge site" onmouseover="(window.status='Join the discussion groups at the SourceForge site'); return true;" onmouseout="(window.status='');">Forum</a></li>-->
          </ul>
		</li>
        <!--<li><a href="#"></a>Developer Resources
           <ul class="menusub">
           <li><a href="developerManualForward.do" title="Developer Manual" onmouseover="(window.status='Developer Manual'); return true;" onmouseout="(window.status='');">
                 Developer Manual
              </a></li>
              <li><a href="webServices.do" title="Web Services" onmouseover="(window.status='Web Services'); return true;" onmouseout="(window.status='');">
                 Web Services
              </a>
              </li>
          </ul>
        </li>-->
        
		<!--<li>
        <a href="userSettingsForward.do" class="flag_en" title="Alter your language settings" onmouseover="(window.status='Alter your language settings'); return true;" onmouseout="(window.status='');">
        Preferences</a></li>-->

		<li><a href="<?php echo relativePath(getcwd(),$contact_php); ?>" target="_parent" title="Contact the MetRxn team" onmouseover="(window.status='Contact the MetRxn team'); return true;" onmouseout="(window.status='');">
         Contact MetRxn</a></li>       
       <?php 
	   if ($_SESSION) 
	   {
		
		echo "<li><a href = '".relativePath(getcwd(),$download_php)."?download_file=metrxn.zip' style=text-align:right><b> Download database </b></a></li>" ;
		
		
		
		echo "<li><a href = '".relativePath(getcwd(),$logout_php)."' style=text-align:right><b> logout ".$_SESSION['username']."</b></a></li>" ;
		
		$username = $_SESSION['username'];
		$query = mysql_query("SELECT accessLevel FROM metrxnweb.login where username = '".$username."' and accessLevel is not null");
		$numrows = mysql_num_rows($query);		
		if ($numrows) 
		{
		while ($row = mysql_fetch_assoc($query)) 
		{
		$accessLevel = $row['accessLevel'];
			if($accessLevel == 'admin')
			{
			echo "<li><a href = '".relativePath(getcwd(),$adminPage_php)."' style=text-align:right target='_parent'><b> Admin </b></a></li>" ;
			echo "<li><a href = '".relativePath(getcwd(),$InsertSourceDetails_php)."' style=text-align:right target='_parent'><b> Enter new sources </b></a></li>" ;
			echo "<li><a href = '".relativePath(getcwd(),$MetaboliteStructureAssignment_php)."' style=text-align:right target='_parent'><b> Assign Structures to metabolites </b></a></li>" ;
			echo "<li><a href = '".relativePath(getcwd(),$learning_php)."' style=text-align:right target='_parent'><b> Learning </b></a></li>" ;
			
			echo "<li><a href='#'></a>IMOB";
   			echo "<ul class='menusub'>";
			echo "<li><a href='localhost:7474/webadmin/#' title='IMOB Admin console' onmouseover='(window.status='Admin page of IMOB'); return true;' onmouseout='(window.status='');'>Admin page for IMOB </a></li>";              
			echo "</ul></li>";
			}
		}
		}
		}
		else {
			echo "<li><a href=".relativePath(getcwd(),$index_php)." target='_parent'> Login </a></li> ";
			}					
		?>
		<li><a href="http://maranas.che.psu.edu/" title="Back to Maranas group page" onmouseover="(window.status='Know more about the MetRxn'); return true;" onmouseout="(window.status='');" target="_blank">
                            Maranas group page</a></li>
   </ul>
</div>
</td>
</body>
</html>
