<?php require_once('Connections/localhost.php'); ?>
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

$colname_Recordset1 = "-1";
if (isset($_POST['find'])) {
  $colname_Recordset1 = $_POST['find'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM userinfo WHERE username LIKE %s", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="TableCSSCodeListAdmin.css" rel="stylesheet" type="text/css" >
<title>Untitled Document</title>
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:cover;
}
</style>
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<table width="649" border="1" class="CSSTableGenerator">
    <tr style="background-color:#960;">
      <td width="61"><div align="center">Username</div></td>
      <td width="60"><div align="center">Password</div></td>
      <td width="64"><div align="center">FirstName</div></td>
      <td width="37"><div align="center">Last Name</div></td>
      <td width="77"><div align="center">AccessLevel</div></td>
      <td width="33"><div align="center">Email</div></td>
      <td width="49">Division</td>
      <td width="49"><div align="center">Date Register</div></td>
      <td width="136"><div align="center">Modify</div></td>
    </tr>
    <tr>
      <td><div align="center"><?php echo $row_Recordset1['username']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['password']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['FirstName']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['LastName']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['AccessLevel']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['email']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['Division']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['DateRegister']; ?></div></td>
    <td>
      <div align="center"><a href="editAdmininfo.php?id=<?php echo $row_Recordset1['ID']; ?>">
        <input type="submit" style="background-color:green;" name="button2" id="button2" value="Edit Account" onclick="" />
        </a>
        <a href="DeleteUser.php?id=<?php echo $row_Recordset1['ID'];?>">
        
        <input type="submit" style="background-color:red;"  name="button3" id="button3" value="Delete Account" onclick="return confirm('Are you sure you want to delete?');" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
