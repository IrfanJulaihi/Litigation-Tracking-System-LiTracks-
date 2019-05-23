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
$query_Recordset1 = "SELECT * FROM userinfo";
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
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="post">
  <div align="center">
      <p>&nbsp;</p>
      <table width="474" height="286" border="0">
        <tr>
          <td scope="col"><div align="center">Firstname:</div></td>
          <th scope="col"><label for="ussername"></label>
            <span id="sprytextfield1">
              <label for="firstname"></label>
              <input name="firstname" type="text" id="firstname" value="<?php echo $row_Recordset1['FirstName']; ?>" />
              <span class="textfieldRequiredMsg">A value is required.</span></span></th>
</tr>
        <tr>
          <td><div align="center">Lastname:</div></td>
          <td><div align="center"><span id="sprytextfield2">
            <label for="lastname"></label>
            <input name="lastname" type="text" id="lastname" value="<?php echo $row_Recordset1['LastName']; ?>" />
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
            <input type="password" name="password" id="password" />
            <span class="passwordRequiredMsg">A value is required.</span></span></div>
            <span id="sprypassword1">
              <label for="password"></label>
            </span>
            <div align="center"></div></td>
</tr>
        <tr>
          <td><div align="center">Confirm Password<span id="sprytextfield4"> </span></div>
            <span id="sprytextfield4">
            <label for="ConfirmPassword"></label>
            </span>
          <div align="center"><span id="sprytextfield4">A value is required.</span></div></td>
          <td><div align="center"><span id="spryconfirm1">
            <input type="password" name="confirmpassword" id="confirmpassword" />
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
            <input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></div>
            <span id="sprytextfield5">
              <label for="email"></label>
            </span>
            <div align="center"></div></td>
</tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="center">
            <input type="submit" name="submit" id="submit" value="Register" />
          </div></td>
        </tr>
      </table>
</div>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" name="form1" method="post">
  </form>
  <p>&nbsp;</p>
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "email");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprypassword3 = new Spry.Widget.ValidationPassword("sprypassword3");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
