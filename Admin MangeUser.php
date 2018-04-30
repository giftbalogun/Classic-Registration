<?php @session_start();?>
<?php require_once('Connections/localhost.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST['DeleteuserhiddenField'])) && ($_POST['DeleteuserhiddenField'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ``user`` WHERE UserID=%s",
                       GetSQLValueString($_POST['DeleteuserhiddenField'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Admin MangeUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_User = sprintf("SELECT * FROM `user` WHERE Username = %s", GetSQLValueString($colname_User, "text"));
$User = mysql_query($query_User, $localhost) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);

$maxRows_ManageUser = 10;
$pageNum_ManageUser = 0;
if (isset($_GET['pageNum_ManageUser'])) {
  $pageNum_ManageUser = $_GET['pageNum_ManageUser'];
}
$startRow_ManageUser = $pageNum_ManageUser * $maxRows_ManageUser;

mysql_select_db($database_localhost, $localhost);
$query_ManageUser = "SELECT * FROM `user` ORDER BY `Timestamp` DESC";
$query_limit_ManageUser = sprintf("%s LIMIT %d, %d", $query_ManageUser, $startRow_ManageUser, $maxRows_ManageUser);
$ManageUser = mysql_query($query_limit_ManageUser, $localhost) or die(mysql_error());
$row_ManageUser = mysql_fetch_assoc($ManageUser);

if (isset($_GET['totalRows_ManageUser'])) {
  $totalRows_ManageUser = $_GET['totalRows_ManageUser'];
} else {
  $all_ManageUser = mysql_query($query_ManageUser);
  $totalRows_ManageUser = mysql_num_rows($all_ManageUser);
}
$totalPages_ManageUser = ceil($totalRows_ManageUser/$maxRows_ManageUser)-1;

$queryString_ManageUser = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ManageUser") == false && 
        stristr($param, "totalRows_ManageUser") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ManageUser = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ManageUser = sprintf("&totalRows_ManageUser=%d%s", $totalRows_ManageUser, $queryString_ManageUser);
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
             <li><a href="Login.php">Login</a></li>
             <li><a href="Register.php">Register</a></li>
             <li><a href="Forget Passord.php">Forget Password</a></li>
         </ul>
     </nav>
</div>
<div id="Content">
       <div id="Pageheading">
         <h2>Admin CP</h2>
       </div>
       <div id="Contentright">
         <table width="670" align="center">
           <tr>
             <td align="right" valign="top">Showing&nbsp;<?php echo ($startRow_ManageUser + 1) ?> to <?php echo min($startRow_ManageUser + $maxRows_ManageUser, $totalRows_ManageUser) ?> of <?php echo $totalRows_ManageUser ?></td>
           </tr>
           <tr>
             <td align="center" valign="top"><?php do { ?>
               <?php if ($totalRows_ManageUser > 0) { // Show if recordset not empty ?>
  <table width="500">
    <tr>
      <td><?php echo $row_User['Fname']; ?><?php echo $row_User['Lname']; ?><?php echo $row_User['Email']; ?></td>
      </tr>
    <tr>
      <td><form id="DeleteUserForm" name="DeleteUserForm" method="post" action="">
        <input name="DeleteuserhiddenField" type="hidden" id="DeleteuserhiddenField" value="<?php echo $row_User['UserID']; ?>" />
        <input type="submit" name="DeleteUserButton" id="DeleteUserButton" value="Delete User" />
        </form></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
  </table>
  <?php } // Show if recordset not empty ?>
              <?php } while ($row_ManageUser = mysql_fetch_assoc($ManageUser)); ?></td>
           </tr>
           <tr>
             <td align="right" valign="top"><?php if ($pageNum_ManageUser > 0) { // Show if not first page ?>
                 <a href="<?php printf("%s?pageNum_ManageUser=%d%s", $currentPage, min($totalPages_ManageUser, $pageNum_ManageUser + 1), $queryString_ManageUser); ?>">Next </a>
                 <?php } // Show if not first page ?>
|
<?php if ($pageNum_ManageUser > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_ManageUser=%d%s", $currentPage, max(0, $pageNum_ManageUser - 1), $queryString_ManageUser); ?>">Previous</a>
  <?php } // Show if not first page ?>             </td>
           </tr>
         </table>
       </div>
       <div id="Contentleft">
         <h2>Account Link</h2>
         <p>Link Here</p>
       </div>
</div>
<div id="Footer"></div>
</div>
</body>
</html>
<?php
mysql_free_result($User);

mysql_free_result($ManageUser);
?>
