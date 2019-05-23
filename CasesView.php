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

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM information";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$General=0;$CFD=0;$PTY=0;$ENG=0;$TNL=0;$AGRO=0;$ICT=0;
$EDD=0;$LAD=0;$RMU=0;$IAD=0;$HRA=0;$IQD=0;$PMD=0;
$CRC=0;
do{
if($row_Recordset1['Category']=="General"){
$General++;
}else if($row_Recordset1['Category']=="PTY"){
$PTY++;
}else if($row_Recordset1['Category']=="AGRO"){
$AGRO++;
}else if($row_Recordset1['Category']=="EDD"){
$EDD++;
}else if($row_Recordset1['Category']=="LAD"){
$LAD++;
}else if($row_Recordset1['Category']=="HRA"){
$HRA++;
}}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Summary Report</title>
<link href="TableCSSCode2.css" rel="stylesheet" type="text/css" >
</head>

<body background="white-abstract-75-wallpaper-background-hd.jpg"
style="background-size:cover;">
<div align="center">
  <table width="55%" height="635" border="1"  class="CSSTableGenerator">
    <tr>
      <th width="157" scope="col">Category</th>
      <th width="129" scope="col">No.Of Cases</th>
    </tr>
    <tr>
      <td><div align="center">General(LAD)</div></td>
      <td><div align="center"><?php echo $General?></div></td>
    </tr>
    <tr>
      <td><div align="center">Property Division(PTY)</div></td>
      <td><div align="center"><?php echo $PTY?></div></td>
    </tr>
    <tr>
      <td><div align="center">Agro-Food Based Division(AGRO)</div></td>
      <td><div align="center"><?php echo $AGRO?></div></td>
    </tr>
    <tr>
      <td><div align="center">Entrepreneur Development Division(EDD)</div></td>
      <td><div align="center"><?php echo $EDD?></div></td>
    </tr>
    <tr>
      <td><div align="center">Human Resource &amp; General Administration Division(HRA)</div></td>
      <td><div align="center"><?php echo $HRA?></div></td>
    </tr>
    <tr>
      <td><div align="center">Total Records</div></td>
      <td><div align="center"><?php echo $totalRows_Recordset1 ?></div></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<p align="center"><a href="page2.php">
  <input type="submit"  name="button2" id="button" value="Back" />
</a></p>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
