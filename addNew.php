<?php require_once('Connections/localhost.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3,1";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
date_default_timezone_set("Asia/Kuala_Lumpur");
	 $date=date('Y-m-d H:i:s');
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO information (debtors, nature, `statement`, status, Category, Keyword,DateModify) VALUES (%s, %s, %s, %s, %s, %s,'$date')",
                       GetSQLValueString($_POST['debtors'], "text"),
                       GetSQLValueString($_POST['nature'], "text"),
                       GetSQLValueString($_POST['statement'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['Category'], "text"),
                       GetSQLValueString($_POST['keyword'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "page2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }

 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Record Add Successfull.')
    window.location.href='page2.php';
    </SCRIPT>");
 //header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM information";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>



<!doctype html>
<html>

<head>
	<title> Add new Debtors Information  </title>
    
    <style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:cover;
}
</style>
    <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>


</head>


<body>
<h2 align="center">ADD NEW CASE</h2>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" >
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Category:</td>
      <td><div align="center">
          <label for="Division"></label>
          <select name="Category" size="1" id="Category" value="Select Category">
             <option value="PTY">Property Division(PTY)</option>
            <option value="AGRO">Agro-Food Based Division(AGRO)</option>
            <option value="EDD">Entrepreneur Development Division(EDD)</option>
            <option value="General">General Case(LAD)</option>                    
            <option value="HRA">Human Resource &amp; General Administration Division(HRA)</option>                   
            
          </select>
        </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Keyword:</td>
      <td><div align="center"><span id="sprytextfield2">
        <label for="keyword"></label>
        <input type="text" name="keyword" id="keyword">
      <span class="textfieldRequiredMsg">A value is required.</span></span></div>        <span id="sprytextfield1">      </span></td>
    </tr>
    <tr valign="baseline">
      <td height="89" align="right" valign="top" nowrap>Parties:</td>
      <td><span id="sprytextarea1">
        <label for="debtors"></label>
        <textarea name="debtors" id="debtors" cols="60" rows="6"></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Nature Of Claim:</td>
      <td><span id="sprytextarea2">
        <label for="nature"></label>
        <textarea name="nature" id="nature" cols="60" rows="6"></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Statement Of Defence:</td>
      <td><span id="sprytextarea3">
        <label for="statement"></label>
        <textarea name="statement" id="statement" cols="60" rows="15"></textarea>
        <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Status:</td>
      <td><span id="sprytextarea4">
        <label for="status"></label>
        <textarea name="status" id="status" cols="60" rows="15"></textarea>
        <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Add"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  
 
</form>

<p align="center"><a href="page2.php">
   <input type="submit" name="button" id="button" value="Cancel">
 </a></p>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>


</html>
<?php
mysql_free_result($Recordset1);
?>
