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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "AccessLevel";
  $MM_redirectLoginSuccess = "page2.php";
  $MM_redirectLoginFailed = "homepage.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  	
  $LoginRS__query=sprintf("SELECT ID,username, password,FirstName,LastName,AccessLevel FROM userinfo WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
     $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $row_Recordset1 = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'AccessLevel');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
$_SESSION['FirstName']=$row_Recordset1['FirstName'];
$_SESSION['LastName']=$row_Recordset1['LastName'];
$_SESSION['ID']=$row_Recordset1['ID'];
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
    header("Location: " . $MM_redirectLoginSuccess );
 
  }
  else {
	  $_SESSION['errMsg'] = "Invalid username or password.";
    header("Location: ". $MM_redirectLoginFailed );
	exit (0);
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Homepage</title>
<link href="loginTable.css" rel="stylesheet" type="text/css" >
<style type="text/css">
body {
	text-decoration: none;
	color: #F00;
}
.loginTable {
}
</style>
</head>

<body>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="login_form" id="login_form">
  <p align="center" class="loginTable"><img src="SEDC Logo - Copy.png" alt="SEDC LOGO" width="363" height="363" /></p>
  <div align="center">
    <p align="center" style="font-size: 16px; color: #000;">User Login</p>
    <p align="right" style="font-size: 16px; color: #000;"><span style="color:red">
      <?php if(!empty($_SESSION['errMsg'])) { echo $_SESSION['errMsg'];unset($_SESSION['errMsg']);} 
						
		
			
						
							 ?>
    </span></p>
    <table border="0">
      <tr>
        <td width="70" style="color: #000; font-size: 18px;">Username</td>
        <td width="185" ><input name="username" type="text" autofocus="autofocus" 
	required="required" /></td>
      </tr>
      <tr>
        <td style="color: #000; font-size: 18px;">Password</td>
        <td><input name="password" type="password" 
	required="required" /></td>
      </tr>
      <tr>
        <td></td>
        <td ><input type="submit" name="submit" value="Login" /></td>
      </tr>
    </table>
    <p align="right" style="font-size: 16px; color: #000;">&nbsp;</p>
    <p style="font-size:12px;color:black;"></p>
    <p style="font-size:12px;color:black;">&nbsp;</p>
   
    <p style="font-size:12px;color:grey;">© 2015 - 2016 Sarawak Economic Development Corporation.<br>All Rights Reserved</p>
  </div>
  <a href="register.php"></a>
</form>
<p align="center" style="font-size:12px;color:grey;">Best viewed in Chrome.</p>

<p align="center">&nbsp;</p>
</body>
</html>