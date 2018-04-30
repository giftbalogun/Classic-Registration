<?php require_once('Connections/localhost.php'); ?>
<?php
// *** Logout the current user.
$logoutGoTo = "Login.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
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

$colname_Logout = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Logout = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Logout = sprintf("SELECT * FROM `user` WHERE Username = %s", GetSQLValueString($colname_Logout, "text"));
$Logout = mysql_query($query_Logout, $localhost) or die(mysql_error());
$row_Logout = mysql_fetch_assoc($Logout);
$totalRows_Logout = mysql_num_rows($Logout);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="CSS/Layout.css" rel="stylesheet" type="text/css"/>
<link href="CSS/Menu.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Classic talk</title>
</head>

<body>
<div id="Holder">
<div id="Header"></div>
<div id="Navbar">
     <nav>
         <ul>
             <li><a href="#">Login</a></li>
             <li><a href="#">Register</a></li>
             <li><a href="#">Forget Password</a></li>
         </ul>
     </nav>
</div>
<div id="Content">
       <div id="Pageheading">
         <h1>Page Header</h1>
       </div>
       <div id="Contentright"></div>
       <div id="Contentleft">
         <h2>Your Message</h2>
         <p>Your Message</p>
       </div>
</div>
<div id="Footer"></div>
</div>
</body>
</html>
<?php
mysql_free_result($Logout);
?>
