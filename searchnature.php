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
if ((isset($_GET['ID'])) && ($_GET['ID'] != "")) {


  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
$colname_searchNature = "-1";
if (isset($_POST['findnature'])) {
  $colname_searchNature = $_POST['findnature'];
}
$_SESSION["SearchItem"]=$_POST['findnature'] ;
mysql_select_db($database_localhost, $localhost);
$query_searchNature = sprintf("SELECT * FROM information WHERE nature LIKE %s ORDER BY id DESC", GetSQLValueString("%" . $colname_searchNature . "%", "text"));
$searchNature = mysql_query($query_searchNature, $localhost) or die(mysql_error());
$row_searchNature = mysql_fetch_assoc($searchNature);
$totalRows_searchNature = mysql_num_rows($searchNature);
if($totalRows_searchNature==0){
	header("Location: NoRecordFound.php");
}
$_SESSION['FindNature']=$_POST['findnature'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Nature of Claim</title>

<link href="print.css" rel="stylesheet" type="text/css" media="print">

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:contain;
}
</style>

</head>
<link href="TableCSSCode.css" rel="stylesheet" type="text/css" >
<body>
<h2>
  <form id="form1" name="form1" method="post" action="PrintAllSearchNature.php">
  <p id="PrintTitle">Please enter report header / title(e.g. &quot;Report as at 31 December 2015&quot;)
    <label for="PrintTitle2"></label>
<label for="PrintTitle"></label>
  </p>
  <p>
  <input type="text" name="PrintTitle" size="50"/>
  </p>
  <p>
    <input type="submit"  name="button2" value="Print All " id="button" />
</p>
</form>
  <a href="page2.php">
  <input type="submit" name="button4" id="button4" value="Back" />
</a></h2>
<table border="1" cellpadding="2" cellspacing="0" class="
CSSTableGenerator">
  <tr style="background-color:#960;">
    <td>No.</td>
    <td>Parties</td>
    <td>Nature Of Claim</td>
    <td>Statement Of Defence</td>
    <td>Status</td>
    <td>Category</td>
    <td>Keyword</td>
    <td>Date Modified</td>
    <td>Modify</td>
  </tr>
  <?php $no=1;?>
  <?php do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_searchNature['debtors']; ?></td>
      <td><?php echo $row_searchNature['nature']; ?></td>
      <td><?php echo $row_searchNature['statement']; ?></td>
      <td><?php echo $row_searchNature['status']; ?></td>
      <td><?php echo $row_searchNature['Category']; ?></td>
      <td><?php echo $row_searchNature['Keyword']; ?></td>
      <td><?php echo $row_searchNature['DateModify']; ?></td>
      <td><a href="PrintPage.php?variable=<?php  echo  $no-1;?>,<?php  echo  $row_searchNature['ID'];?>">
        <input type="submit" name="button4" id="button4" value="Print" />
      </a><a href="edit.php?id=<?php echo $row_searchNature['ID']; ?>">
      <input type="submit" name="button" id="button2" value="Edit" />
      </a><a href="delete.php?id=<?php echo $row_searchNature['ID']; ?>">
      <input type="submit" name="button3" id="button3" value="Delete" onclick="return confirm('Are you sure you want to delete?');"/>
      </a><a href="PrintPage.php?variable=<?php  echo  $no-1;?>,<?php  echo  $row_searchNature['ID'];?>">      </a></td>
    </tr>
    <?php } while ($row_searchNature = mysql_fetch_assoc($searchNature)); ?>
</table>
<p>&nbsp;</p>

<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($searchNature);
?>
