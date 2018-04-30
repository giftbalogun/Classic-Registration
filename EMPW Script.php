<?php 
@session_start();
$_session['EMPW'] = $_POST['Email'];
?>
<?php require_once('Connections/localhost.php'); ?>
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

$colname_EMPW = "-1";
if (isset($_SESSION['EMPW'])) {
  $colname_EMPW = $_SESSION['EMPW'];
}
mysql_select_db($database_localhost, $localhost);
$query_EMPW = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_EMPW, "text"));
$EMPW = mysql_query($query_EMPW, $localhost) or die(mysql_error());
$row_EMPW = mysql_fetch_assoc($EMPW);
$totalRows_EMPW = mysql_num_rows($EMPW);

mysql_free_result($EMPW);
?>
<?php 

if($totalrow_EmailPassword > 0) {
	
$from="noreply@yourdomain.com";
$email=$_Post['Email'];
$sublect="Your Domail - Email Password";
$message="Here is your Password:".$row_EmailPassowrd['Password']

mail ($email, $subject, $message, "From",$form);

}
      if($totalrow_EmailPassword > 0) (
	     
		 echo "Please check your Email you have been sent your Password";
		 
	  
	  ) else (
	    echo "Fail - Try Again!";
	  )
?>


