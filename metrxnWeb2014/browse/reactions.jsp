<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<%@ page language="java" import="java.sql.*"%>
<%
String connectionURL = "jdbc:mysql://localhost:3306/intermediate?user=root;password=";
Connection connection = null;
Statement statement = null;
ResultSet rs = null;
%>
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
</head>

<body>
<div class="header">
    <iframe src="/MetRxn/top_data/top.htm" width="100%" height="160" scrolling="no">
    </iframe>
</div>
<div class="leftbar"">
	<?php include('../left_data/leftMenu.htm'); ?>
   	<!--iframe src="/MetRxn/left_data/leftMenu.htm" height="450" scrolling="no">
    </iframe-->
</div>
<%
Class.forName("com.mysql.jdbc.Driver").newInstance();
connection = DriverManager.getConnection(connectionURL, "", "");
statement = connection.createStatement();
rs = statement.executeQuery("select distinct synonym from `intermediate`.`synonymidstructuressource`");
while (rs.next()) {
out.println(rs.getString("synonym")+"<br>");
}
rs.close();
%>
<div class="footer">
    <iframe src="/MetRxn/footer_data/footer.html" height="60" width="100%" scrolling="no">
    </iframe>
</div>
</body>
</html>