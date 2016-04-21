<?php require_once('Connections/connTest.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_connTest, $connTest);
$query_getComments = "SELECT first_name, last_name, `comment` FROM comments ORDER BY comment_id DESC";
$getComments = mysql_query($query_getComments, $connTest) or die(mysql_error());
$row_getComments = mysql_fetch_assoc($getComments);
$totalRows_getComments = mysql_num_rows($getComments);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cafe Townsend - Customer Comments</title>
<link href="assets/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
  <div id="header"><img src="assets/header.jpg" width="700" height="92" alt="Cafe Townsend" /></div>
  <h1 id="main_header">Cafe Townsend Intranet</h1>
  <div id="main">
    <h2>Customer comments</h2>
    <div id="comments">
      <?php do { ?>
        <p><?php echo $row_getComments['comment']; ?> &#8212; <?php echo $row_getComments['first_name']; ?> <?php echo $row_getComments['last_name']; ?></p>
        <?php } while ($row_getComments = mysql_fetch_assoc($getComments)); ?>
    </div>
  </div>
  <div id="footer"></div>
</div>
</body>
</html>
<?php
mysql_free_result($getComments);
?>
