<?php
session_start();
$editFormAction = $_SERVER['PHP_SELF'];

$conn = mysql_connect("localhost","root","sedc@1234");
mysql_select_db("database",$conn);
if(count($_POST)>0) {
$result = mysql_query( "SELECT * FROM userinfo WHERE ID = '".$_SESSION['ID']."'");
$row=mysql_fetch_array($result);
if($_POST["OldPass"] == $row["password"]) {
mysql_query("UPDATE userinfo set password='" . $_POST["Pass2"] . "' WHERE ID='" . $_SESSION["ID"] . "'");
 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Your password has changed.')
    window.location.href='page4.php';
    </SCRIPT>");

} else{
	
	$message = "Current Password is not correct";
echo "<script type='text/javascript'>alert('$message');</script>";
}}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="TableCSSCodeEditAccount.css" rel="stylesheet" type="text/css" >
</head>

<body background="white-abstract-75-wallpaper-background-hd.jpg" style="background-size:cover;">

<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <div align="center">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="358" border="1" style="text-align:center;" class="CSSTableGenerator">
      <tr>
        <td width="154" >Old Password
        <td width="63" ><span id="sprytextfield1">
          <input type="password" name="OldPass" id="OldPass" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></tr>
      <tr>
        <td>New Password</td>
        <td><span id="sprytextfield2">
        <label for="Pass1"></label>
        <input type="password" name="Pass1" id="Pass1" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span></td>
      </tr>
      <tr>
        <td>Confirm New Password</td>
        <td><span id="spryconfirm1">
          <label for="Pass2"></label>
          <input type="password" name="Pass2" id="Pass2" />
        <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="Change" id="Change" value="Submit" /></td>
      </tr>
    </table>
  </div>
</form>
<p align="center">&nbsp;</p>
<p align="center"><a href="page4.php">
  <input type="submit"  name="button" id="button" value="Back" />
  </a> 
</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:6});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "Pass1");
  </script>
</body>
</html>