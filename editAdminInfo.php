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
  $MM_dupKeyRedirect="EmailAvailable.php";
  $loginFirstname=$_POST['FirstName'];
  $loginLastname=$_POST['LastName'];
 
  
  $LoginRS__queryFN = sprintf("SELECT FirstName FROM userinfo WHERE FirstName=%s", GetSQLValueString($loginFirstname, "text"));
  $LoginRS__queryLN = sprintf("SELECT LastName FROM userinfo WHERE LastName=%s", GetSQLValueString($loginLastname, "text"));


   mysql_select_db($database_localhost, $localhost);
  //First Name  
	$LoginRSFN=mysql_query($LoginRS__queryFN, $localhost) or die(mysql_error());
  $loginFoundUserFN = mysql_num_rows($LoginRSFN);
  //Last Name
  $LoginRSLN=mysql_query($LoginRS__queryLN, $localhost) or die(mysql_error());
  $loginFoundUserLN = mysql_num_rows($LoginRSLN);


 //Division

 

  //if there is a row in the database, the username was found - can not add the requested username
  
  //TRUE TRUE

	/*$MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;*/
	//TRUE FALSE
  	  
  }
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE userinfo SET FirstName=%s, LastName=%s ,password=%s,Division=%s WHERE ID=%s",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
					    GetSQLValueString($_POST['PassChange'], "text"),
					    GetSQLValueString($_POST['Division'], "text"),
                               GetSQLValueString($_POST['ID'], "int"));
//Most important thing to update the database..
  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  
  $updateGoTo = "listAdmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Account Edit Success.')
    window.location.href='listAdmin.php';
    </SCRIPT>");
 // header(sprintf("Location: %s", $updateGoTo));
}




mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM userinfo WHERE ID =%s",
GetSQLValueString($_GET['id'], "int"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="TableCSSCodeEditAccount.css" rel="stylesheet" type="text/css" >
<link href="UserEmailButton.css" rel="stylesheet" type="text/css" >
<meta charset="utf-8">
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);  background-size: cover;
}
</style>
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
</head>

<body><h1 align="center">Edit Account Information
</h1>
<p align="center">&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <div align="center">
    <table width="283" border="1" style="text-align:center;" class="CSSTableGenerator">
      <tr>
        <td>First Name</td>
        <td><div align="center"><span id="sprytextfield1">
        </span></div>          <span id="sprytextfield1">
          <label for="FirstName"></label>
          <div align="center">
            <input name="FirstName" type="text" id="FirstName" value="<?php echo $row_Recordset1['FirstName']; ?>" />
            <span class="textfieldRequiredMsg">A value is required.</span></div>
          </span></td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><div align="center"><span id="sprytextfield2">
        </span></div>          <span id="sprytextfield2">
          <label for="LastName"></label>
          <div align="center">
            <input name="LastName" type="text" id="LastName" value="<?php echo $row_Recordset1['LastName']; ?>" />
            <span class="textfieldRequiredMsg">A value is required.</span></div>
        </span></td>
      </tr>
      <tr>
        <td><p>Change Division:</p></td>
        <td><div align="center">
         <div align="center">
          <label for="Division"></label>
         
            <select name="Division" size="1" id="Division" >
            <option value="<?php echo $row_Recordset1['Division'] ?>"><?php echo $row_Recordset1['Division'] ?></option>
              <option value="PTY">Property Division(PTY)</option>
              <option value="AGRO">Agro-Food Based Division(AGRO)</option>
              <option value="EDD">Entrepreneur Development Division(EDD)</option>
              <option value="LAD">Legal Affairs Division(LAD)</option>
              <option value="HRA">Human Resource &amp; General Administration Division(HRA)</option>
            </select>
          </div>
</div></td>
      </tr>
      <tr>
        <td>Change Password:</td>
        <td><div align="center"><span id="sprytextfield3">
          <label for="PassChange"></label>
          <input type="password" name="PassChange" id="PassChange" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></div></td>
      </tr>
      <tr>
        <td>Confirm Change Password:</td>
        <td><div align="center"><span id="spryconfirm1">
          <label for="ChngePass2"></label>
          <input type="password" name="ChngePass2" id="ChngePass2" />
        <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" id="Submit" value="Submit" /></td>
      </tr>
    </table>
    <p>
      <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['id']?>" />

      <a href="UserChangeEmail.php?id=<?php echo $row_Recordset1['ID']; ?>" class="btn">Change User Email</a>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="MM_insert" value="form1" />
    <a href="UserUsernameChange.php?id=<?php echo $row_Recordset1['ID']; ?>" class="btn">Change User Username</a></p>
  </div>
</form>
<p align="center">&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "PassChange");
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
