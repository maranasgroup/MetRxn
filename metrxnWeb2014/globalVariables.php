<?php
function relPath($rp){ 
   return str_replace($_SERVER['DOCUMENT_ROOT'],'',$rp); 
}
function absPath($rp){ 
   return str_replace($_SERVER['DOCUMENT_ROOT'],'',$rp); 
}

if ('WINNT' == PHP_OS) {
$top_data_htm = 'C:\inetpub\wwwroot\metrxn\top_data\top.htm';    
$left_Menu_php = 'C:\inetpub\wwwroot\metRxn\left_data\leftMenu.php';
$dataSourceDatabase_php = 'C:\inetpub\wwwroot\metRxn\statistics\dataSourceDatabase.php';
$dataSourceMetabolicModels_php = 'C:\inetpub\wwwroot\metRxn\statistics\dataSourceMetabolicModels.php';
$search_php = 'C:\inetpub\wwwroot\metRxn\search_box\search.php';
$main_php = 'C:\inetpub\wwwroot\metRxn\main_data\main.php';
$footer_php = 'C:\inetpub\wwwroot\metRxn\footer_data\footer.html';
$MetRxn_php= 'C:\inetpub\wwwroot\metRxn\MetRxn.php';
$BrowseByOrganism_php = 'C:\inetpub\wwwroot\metRxn\browse\BrowseByOrganism.php';
$comparisions_php = 'C:\inetpub\wwwroot\metRxn\browse\comparisions.php';
$Documentation_php = 'C:\inetpub\wwwroot\metRxn\Documentation\Documentation.php';
$contact_php = 'C:\inetpub\wwwroot\metRxn\contact\contact.php';
$conn_php = 'C:\inetpub\wwwroot\metRxn\conn.php';
$download_php = 'C:\inetpub\wwwroot\metRxn\dumps\download.php';
$logout_php = 'C:\inetpub\wwwroot\metRxn\login\logout.php';
$adminPage_php = 'C:\inetpub\wwwroot\metRxn\Admin\adminPage.php';
$InsertSourceDetails_php = 'C:\inetpub\wwwroot\metRxn\Admin\InsertSourceDetails.php';
$MetaboliteStructureAssignment_php = 'C:\inetpub\wwwroot\metRxn\Admin\MetaboliteStructureAssignment.php';
$index_php = 'C:\inetpub\wwwroot\metRxn\login\index.php';
$metRxnContents_css = 'C:\inetpub\wwwroot\metRxn\metRxnContents.css';
$anchors_css = 'C:\inetpub\wwwroot\metRxn\anchors.css';
$headings_css = 'C:\inetpub\wwwroot\metRxn\headings.css';
$results_php = 'C:\inetpub\wwwroot\metRxn\searchResults\results.php';
$marvin_folder = 'C:\inetpub\wwwroot\metRxn\marvin';
$metrxn_webpage_graphic_png = 'C:\inetpub\wwwroot\metRxn\images\metrxn_webpage_graphic.png';
$metrxn_webpage_graphic_gif = 'C:\inetpub\wwwroot\metRxn\images\metrxn_webpage_graphic.gif';
} else {
$top_data_htm = '/home/www/MetRxn/top_data/top.htm';
$left_Menu_php = '/home/www/MetRxn/left_data/leftMenu.php';
$dataSourceDatabase_php = '/home/www/MetRxn/statistics/dataSourceDatabase.php';
$dataSourceMetabolicModels_php = '/home/www/MetRxn/statistics/dataSourceMetabolicModels.php';
$search_php = '/home/www/MetRxn/search_box/search.php';
$main_php = '/home/www/MetRxn/main_data/main.php';
$footer_php = '/home/www/MetRxn/footer_data/footer.html';
$MetRxn_php= '/home/www/MetRxn/MetRxn.php';
$BrowseByOrganism_php = '/home/www/MetRxn/browse/BrowseByOrganism.php';
$comparisions_php = '/home/www/MetRxn/browse/comparisions.php';
$Documentation_php = '/home/www/MetRxn/Documentation/Documentation.php';
$contact_php = '';
$conn_php = '/home/www/MetRxn/conn.php';
$download_php = '/home/www/MetRxn/dumps/download.php';
$logout_php = '/home/www/MetRxn/login/logout.php';
$adminPage_php = '/home/www/MetRxn/Admin/adminPage.php';
$InsertSourceDetails_php = '/home/www/MetRxn/Admin/InsertSourceDetails.php';
$MetaboliteStructureAssignment_php = '/home/www/MetRxn/Admin/MetaboliteStructureAssignment.php';
$index_php = '/home/www/MetRxn/login/index.php';
$metRxnContents_css = '/home/www/MetRxn/metRxnContents.css';
$anchors_css = '/home/www/MetRxn/anchors.css';
$headings_css = '/home/www/MetRxn/headings.css';
$results_php = '/home/www/MetRxn/searchResults/results.php';
$marvin_folder = '/home/www/MetRxn/marvin/';
$metrxn_webpage_graphic_png = '/home/www/MetRxn/images/metrxn_webpage_graphic.png';
$metrxn_webpage_graphic_gif = '/home/www/MetRxn/images/metrxn_webpage_graphic.gif';
}
function relativePath($from, $to, $ps = DIRECTORY_SEPARATOR)
{
  $arFrom = explode($ps, rtrim($from, $ps));
  $arTo = explode($ps, rtrim($to, $ps));
  while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0]))
  {
    array_shift($arFrom);
    array_shift($arTo);
  }
  return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
}
?>