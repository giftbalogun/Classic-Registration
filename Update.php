<?php @session_start(); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE ``user`` SET Email=%s, Password=%s WHERE UserID=%s",
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="CSS/Layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Classic talk</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
</head>

<body>
<div id="Holder">
<div id="Header"></div>
<div id="Navbar">
     <nav>
         <ul>
             <li><a href="Login.php">Login</a></li>
             <li><a href="Register.php">Register</a></li>
             <li><a href="#">Forget Password</a></li>
         </ul>
     </nav>
</div>
<div id="Content">
       <div id="Pageheading">
         <h1>Update account</h1>
       </div>
       <div id="Contentright">
         <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
           <table width="600" align="center">
             <tr>
               <td><p>Account <?php echo $row_User['Fname']; ?>  <?php echo $row_User['Lname']; ?> Username:<?php echo $row_User['Username']; ?></p></td>
             </tr>
           </table>
           <table width="400" align="center">
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr class="StyleTxtField">
               <td><span id="sprytextfield1">
                 <label for="Email">Email</label>
                 <br />
                 <br />
<input name="Email" type="text" class="StyleTxtField" id="Email" value="<?php echo $row_User['Email']; ?>" />
               <span class="textfieldRequiredMsg">A value is required.</span></span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr class="StyleTxtField">
               <td><span id="sprypassword1">
                 <label for="Password">Password</label>
                 <br />
                 <br />
<input name="Password" type="password" class="StyleTxtField" id="Password" value="<?php echo $row_User['Password']; ?>" />
               <span class="passwordRequiredMsg">A value is required.</span></span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><input type="submit" name="Updatebutton" id="Updatebutton" value="Update Account" />
               <input type="hidden" name="UserIDhiddenField" id="UserIDhiddenField" /></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
           </table>
           <input type="hidden" name="MM_update" value="form1" />
         </form>
       </div>
       <div id="Contentleft">
         <h2>Account</h2>
         <p>Link</p>
       </div>
</div>
<div id="Footer"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
</body>
</html>
<?php
mysql_free_result($User);
?>
