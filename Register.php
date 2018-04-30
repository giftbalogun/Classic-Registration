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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="Register.php";
  $loginUsername = $_POST['Username'];
  $LoginRS__query = sprintf("SELECT Username FROM `user` WHERE Username=%s", GetSQLValueString ($loginUsername, "text"));
  mysql_select_db($database_localhost, $localhost);
  $LoginRS=mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO ``user`` (Fname, Lname, Email, Username, Password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Firstname'], "text"),
                       GetSQLValueString($_POST['Lastname'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Password'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "Login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
       <div id="Contentright">
         <form action="<?php echo $editFormAction; ?>" id="RegisterForm" name="RegisterForm" method="POST">
           <table width="400" align="center">
             <tr>
               <td><table>
                 <tr>
                   <td><p>
                     <label for="Firstname2">Firstname</label>
                   </p>
                     <p>
                       <input name="Firstname" type="text" class="StyleTxtField" id="Firstname2" />
                     </p></td>
                   <td><p>
                     <label for="Lastname">Lastname</label>
                   </p>
                     <p>
                       <input name="Lastname" type="text" class="StyleTxtField" id="Lastname" />
                     </p></td>
                 </tr>
               </table></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><p>
                 <label for="Email">Email<br />
                   <br />
                 </label>
                 <input name="Email" type="text" class="StyleTxtField" id="Email" />
               </p></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><label for="Username">Username<br />
               </label>
               <input name="Username" type="text" class="StyleTxtField" id="Username" /></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><table width="391">
                 <tr>
                   <td width="144"><p>
                     <label for="Password">Password</label>
                   </p>
                     <p>
                       <input name="Password" type="text" class="StyleTxtField" id="Password" />
                     </p></td>
                   <td width="235"><p>
                     <label for="Password Confirm">Password Confirm</label>
                   </p>
                     <p>
                       <input name="Password Confirm" type="text" class="StyleTxtField" id="Password Confirm" />
                     </p></td>
                 </tr>
               </table></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><input type="submit" name="Register Botton" id="Register Botton" value="Register" />
                 <input type="hidden" name="MM_insert" value="RegisterForm" />
         </form></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td height="21">&nbsp;</td>
             </tr>
           
         </form>
       </div>
       <div id="Contentleft">
         <h2>Your Message</h2>
         <p>Your Message</p>
       </div>
</div>
<div id="Footer"></div>
</div>
</body>
</html>