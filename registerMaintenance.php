<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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

$MM_restrictGoTo = "homepage.php";
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
  $MM_dupKeyRedirect="UsernameAvailable.php";
  $loginUsername = $_POST['username'];
  $loginEmail=$_POST['email'];
  $LoginRS__query = sprintf("SELECT username FROM userinfo WHERE username=%s or email=%s", GetSQLValueString($loginUsername, "text"),GetSQLValueString($loginEmail, "text"));
  mysql_select_db($database_localhost, $localhost);
  $LoginRS=mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
   echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Sorry!! Username or Email are not available for registration.')
    window.location.href='registerMaintenance.php';
    </SCRIPT>");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registration")) {
	date_default_timezone_set("Asia/Kuala_Lumpur");
	 $date=date('Y-m-d H:i:s');
  $insertSQL = sprintf("INSERT INTO userinfo (username, password, FirstName, LastName, email, AccessLevel,Division,DateRegister) VALUES (%s, %s, %s, %s, %s, %s,%s,'$date')",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['AccessLevel'], "int"),
					   GetSQLValueString($_POST['Division'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "page2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
   echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Register for new Maintenance success.')
    window.location.href='page2.php';
    </SCRIPT>");
  //header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register New Maintenance</title>

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
background-size:cover;
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
</head>

<body>
<h1 align="center">Register New Maintenance.</h1>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="registration">
  <div align="center">
    <table width="474" height="286" border="0">
      <tr>
        <td scope="col"><div align="center">Firstname:</div></td>
        <th scope="col"><label for="ussername4"></label>
          <span id="sprytextfield1">
            <label for="firstname"></label>
            <input type="text" name="firstname" id="firstname" />
            <span class="textfieldRequiredMsg">A value is required.</span></span></th>
  </tr>
      <tr>
        <td><div align="center">Lastname:</div></td>
        <td><div align="center"><span id="sprytextfield2">
          <label for="lastname"></label>
          <input type="text" name="lastname" id="lastname" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></div></td>
  </tr>
      <tr>
        <td><div align="center">Username:</div></td>
        <td><div align="center"><span id="sprytextfield6">
          <label for="username2"></label>
          <input type="text" name="username" id="username2" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></div>
          <span id="sprytextfield3">
            <label for="Username"></label>
          </span>
          <div align="center"></div></td>
  </tr>
      <tr>
        <td><div align="center">Password:</div></td>
        <td><div align="center"><span id="sprypassword3">
          <label for="password"></label>
          <input type="password" name="password" id="password" pattern=".{6,}" required title="6 characters minimum"/>
          <span class="passwordRequiredMsg">A value is required.</span></span></div>
          <span id="sprypassword1">
            <label for="password"></label>
          </span>
          <div align="center"></div></td>
  </tr>
      <tr>
        <td><div align="center">Confirm Password<span id="sprytextfield4"> </span></div>
        <div align="center"></div></td>
        <td><div align="center"><span id="spryconfirm1">
          <input type="password" name="confirmpassword" id="confirmpassword" pattern=".{6,}" required title="6 characters minimum"/>
          <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></div>
          <span id="sprypassword2">
            <label for="ComfirmPassword"></label>
          </span>
          <div align="center"></div></td>
  </tr>
      <tr>
        <td><div align="center">Email:</div></td>
        <td><div align="center"><span id="sprytextfield7">
          <label for="email"></label>
          <input type="text" name="email" id="email" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></div>
          <span id="sprytextfield5">
            <label for="email"></label>
          </span>
          <div align="center"></div></td>
  </tr>
      <tr>
        <td><div align="center"></div></td>
        <td><div align="center"><span id="sprytextfield8">
          <label for="AccessLevel"></label>
          <input name="AccessLevel" style="text-align:center;"  type="hidden" id="AccessLevel" value="3" readonly="readonly"/>
          <span class="textfieldRequiredMsg">A value is required.</span></span></div></td>
  </tr>
      <tr>
        <td><div align="center">User Division</div></td>
        <td><div align="center">
          <label for="Division"></label>
          <select name="Division" size="1" id="Division" value="Select Category">
              <option value="PTY">Property Division(PTY)</option>
            <option value="AGRO">Agro-Food Based Division(AGRO)</option>
            <option value="EDD">Entrepreneur Development Division(EDD)</option>
            <option value="LAD">Legal Affair Division(LAD)</option>                    
            <option value="HRA">Human Resource &amp; General Administration Division(HRA)</option>                   
          </select>
        </div></td>
      </tr>
      <tr>
 
        <td><div align="center"></div></td>
        <td><div align="center">
                    <a href="page2.php">
   <input type="button" value="Home Page" />
</a>
          <input type="submit" name="submit" id="submit" value="Register" />
        </div></td>
      </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
      <tr> </tr>
    </table>
  </div>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="registration" />
</form>
<script type="text/javascript">
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "email");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprypassword3 = new Spry.Widget.ValidationPassword("sprypassword3");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>