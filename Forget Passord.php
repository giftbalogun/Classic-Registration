<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="CSS/Layout.css" rel="stylesheet" type="text/css"/>
<link href="CSS/Menu.css" rel="stylesheet" type="text/css"/>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Classic talk</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
         <h1>Email Password</h1>
       </div>
       <div id="Contentright">
         <form id="EmailPasswordForm" name="EmailPasswordForm" method="post" action="EMPW Script.php">
           <span id="sprytextfield1">
           <label for="Email">Email<br />
             <br />
           </label>
           <input name="Email" type="text" class="StyleTxtField" id="Email" />
           <br />
<input type="submit" name="EmailPasswordButton" id="EmailPasswordButton" value="Email Password" />
           <span class="textfieldRequiredMsg">A value is required.</span></span>
         </form>
       </div>
       <div id="Contentleft">
         <h2>EMPW Message</h2>
         <p>Your Message</p>
       </div>
</div>
<div id="Footer">
  <p>Copyright © DJ Classic</p>
</div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>