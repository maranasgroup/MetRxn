<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/metrxnTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Page title missing</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet"  href="http://metRxn.engr.psu.edu/inc/css/sidebars.css"   type="text/css" />
   	<link rel="search" href="/MetRxn/plugins/openSearch/openSearch.xml" type="application/opensearchdescription+xml" title="MetRxn" />
	<link href="../metRxnContents.css" rel="stylesheet" type="text/css" />
	<link href="../anchors.css" rel="stylesheet" type="text/css" />
	<link href="../headings.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
	.header {

		width:100%;
		top:0;
		border:none;
	}
	.footer {
		position:absolute;
		bottom:0;
		width:100%;
	}
	.content {
		float:left;
		width:80%;
		position:relative;
	}
	.leftbar{
		float:left;
		width:20%;
		position:relative;



		}
	iframe{
		border:0;
	}
	table
	{
	border-collapse:collapse;
	margin:20px;
	}
	td
	{
	padding:2px;
	}
	.imageframe {

	}
	img {
		margin:20px;
		float:left;

	}
	#structure {

		float:left;
	}
	#synonym {
		bottom:1;
		float:none;
	}

	</style>

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
<form action="resendactivationLink.php" method="post">
	Please enter your username <input type="text" name="username"> 
	Please enter your email <input type="text" name="email">
	<input type="submit" name="submit">
	</form>
<?php
$username = $_POST['username'];
$email = $_POST['email'];
$submit = $_POST['submit'];
$connect = mysql_connect("localhost","root","");
mysql_select_db("metrxnweb");
require_once "C:\\xampp\php\PEAR\mail.php";
if ($submit) {
if ($username||$email)
{
	if ($username)
	{
		{
			$query = mysql_query("

		SELECT * FROM login WHERE username = '".$username."'  
		");
			$numrows = mysql_num_rows($query);
			if ($numrows ==0 ) {
				die("username not found, click here to register a new user <a href=register.php> Register </a>");
			}
		}

		{
			$query = mysql_query("
		SELECT * FROM login WHERE username = '".$username."' and active = 1
		");

			$numrows = mysql_num_rows($query);
			if ($numrows > 0) {
				die("This user is active, please follow this link to <a href=index.php> Login </a>");
			}
		}

		{
			$query = mysql_query("
		SELECT * FROM login WHERE username = '".$username."' and active = 0
		");

			$numrows = mysql_num_rows($query);


			if ($numrows = 1) {
					
				while ($row = mysql_fetch_assoc($query)) {
					$email = $row['email'];
					$fullname = $row['fullname'];
					$id = $row['idlogin'];
					$random = $row['random'];

					$from = "Admin <azk172@psu.edu>";
					$to = $email;
					$subject = "Activate your MetRxn Account";
					$host = "ssl://smtp.googlemail.com";
					$port = "465";
					$username = "kmr.akhil";
					$password = "login@123";
					$message = "Hello $FullName,\n\nPlease follow the link below and activate your account\n http://130.203.234.86/MetRxn/login/activate.php?id=".$id."&random=$random' \n Thanks\n MetRxn team\n";
					$headers = array ('From' => $from,
   						'To' => $to,
   						'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					array ('host' => $host,
     					'port' => $port,
     					'auth' => true,
     					'username' => $username,
     					'password' => $password));

					$mail = $smtp->send($to, $headers, $message);

					if (PEAR::isError($mail)) {
						die("<p>" . $mail->getMessage() . "</p>");
							
					} else {

						die("Please check your email for the activation link. Click here to <a href='index.php'> Login</a>");
					}

				}
					
					
					
			}
		}
	}
	elseif ($email)
	{

		{
			$query = mysql_query("

		SELECT * FROM login WHERE email = '".$email."'  
		");
			$numrows = mysql_num_rows($query);
			if ($numrows ==0 ) {
				die("Email not found, click here to register a new user <a href=register.php> Register </a>");
			}
		}

		{
			$query = mysql_query("
		SELECT * FROM login WHERE email = '".$email."' and active = 1
		");

			$numrows = mysql_num_rows($query);
			if ($numrows > 0) {
				die("This user is active, please follow this link to login -> <a href=index.php> Login </a>");
			}
		}

		{
			$query = mysql_query("
		SELECT * FROM login WHERE email = '".$email."' and active = 0
		");

			$numrows = mysql_num_rows($query);
			if ($numrows = 1) {
					
				while ($row = mysql_fetch_assoc($query)) {
					$email = $row['email'];
					$fullname = $row['fullname'];
					$id = $row['idlogin'];
					$random = $row['random'];

					$from = "Admin <azk172@psu.edu>";
					$to = $email;
					$subject = "Activate your MetRxn Account";
					$host = "ssl://smtp.googlemail.com";
					$port = "465";
					$username = "kmr.akhil";
					$password = "login@123";
					$message = "Hello $FullName,\n\nPlease follow the link below and activate your account\n http://130.203.234.86/MetRxn/login/activate.php?id=".$id."&random=$random' \n Thanks\n MetRxn team\n";
					$headers = array ('From' => $from,
   						'To' => $to,
   						'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					array ('host' => $host,
     					'port' => $port,
     					'auth' => true,
     					'username' => $username,
     					'password' => $password));

					$mail = $smtp->send($to, $headers, $message);

					if (PEAR::isError($mail)) {
						die("<p>" . $mail->getMessage() . "</p>");
							
					} else {

						die("Please check your email for the activation link. Click here to login <a href='index.php'> Login</a>");
					}

				}
					
					
			}



		}
	}
}
else
die("Please enter Username or email to resend your activation link, return <a href=resenActivationLink.php>return</a>");
	
}
?>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>

