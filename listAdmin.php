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



mysql_select_db($database_localhost, $localhost);
$query_listAdmin = "SELECT * FROM userinfo";
$listAdmin = mysql_query($query_listAdmin, $localhost) or die(mysql_error());
$row_listAdmin = mysql_fetch_assoc($listAdmin);
$totalRows_listAdmin = mysql_num_rows($listAdmin);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of registered account</title>

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	word-wrap: break-word;
	background-size: cover;
}
</style>
<link href="TableCSSCodeListAdmin.css" rel="stylesheet" type="text/css" >
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-size: 16px;
}

</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

</head>

<body onload="show()" >
<h2>&nbsp;</h2>
<h2 align="center">
  <p align="center"><u>List of registered user</u></p>
  <p align="center">&nbsp;</p>
</h2>
<form id="form1" name="form1" method="post" action="SearchingUser.php">
  <div align="center"><span id="sprytextfield1">
    Search Username:
    <input type="text" name="find" id="name" />
    <span class="textfieldRequiredMsg">A value is required.</span></span>
    <input type="submit" src="searchlogo.png" id="find" value="Search" />
  </div>
  <p>&nbsp;</p>
</form>
<p style="position: absolute; left: 441px; top: 259px;"> There are <?php echo $totalRows_listAdmin; ?> registered user found.</p>
<p align="left">&nbsp;</p>
<p align="left">&nbsp;</p>


  <div align="center">
    <table width="1198" border="1" cellpadding="2" cellspacing="0" style="text-align:center" class="CSSTableGenerator">
      <tr style="background-color:#960;">
        <td>No</td>
        <td>Username</td>
        <td>Password</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>AccessLevel</td>
        <td>Email</td>
        <td>Division</td>
        <td>Date Register</td>
        <td>Modify</td>    
      </tr>  <?php $no=1;?>
      <?php do { ?>
        <tr>
      
          <td height="69"><div align="center"><?php echo $no++; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['username']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['password']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['FirstName']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['LastName']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['AccessLevel'];?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['email']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['Division']; ?></div></td>
          <td><div align="center"><?php echo $row_listAdmin['DateRegister']; ?></div></td>
          <td>
        
            <p><a href="editAdmininfo.php?id=<?php echo $row_listAdmin['ID']; ?>"></a><a href="editAdmininfo.php?id=<?php echo $row_listAdmin['ID']; ?>">
              <input type="submit" style="background-color:green;" name="button2" id="button2" value="Edit Account" onclick="" />
            </a><a href="DeleteUser.php?id=<?php echo $row_listAdmin['ID']; ?>">
            <input type="submit" style="background-color:red;" name="button3" id="button3" value="Delete Account" onclick="return confirm('Are you sure you want to delete?');" />
          </a></p>
        </td>
        </tr>
        <?php } while ($row_listAdmin = mysql_fetch_assoc($listAdmin)); ?>
      </table>
  </div> 
<p align="center">AccessLevel Directory:    </p>
<p align="center">1.Admin User</p>
<p align="center">2.Staff User</p>
<p align="center">3.Maintenance User</p>
<p align="center"><a href="page2.php"><br />

  <input type="submit"  name="button" id="button" value="Back" />
</a></p>

<p align="center">&nbsp;</p>


<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($listAdmin);
?>
