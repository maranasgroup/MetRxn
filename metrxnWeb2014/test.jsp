<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
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
<title>Untitled Document</title>
</head>

<body>
<%
Class.forName("com.mysql.jdbc.Driver").newInstance();
connection = DriverManager.getConnection(connectionURL, "", "");
statement = connection.createStatement();
rs = statement.executeQuery("select distinct synonym from `intermediate`.`synonymidstructuressource` limit 10");
while (rs.next()) {
out.println(rs.getString("synonym")+"<br>");
}
rs.close();
%>
</body>
</html>