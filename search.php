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

if ((isset($_GET['ID'])) && ($_GET['ID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM information WHERE ID=%s",
                       GetSQLValueString($_GET['ID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "page2.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
$_SESSION["SearchItem"]=$_POST['find'] ;
mysql_select_db($database_localhost, $localhost);
$query_searching = "SELECT * FROM information ORDER BY id ASC";
$searching = mysql_query($query_searching, $localhost) or die(mysql_error());
$row_searching = mysql_fetch_assoc($searching);
$totalRows_searching = "-1";
if (isset($_POST['find'])) {
$totalRows_searching = $_POST['find'];
}
$colname_searching = "-1";
if (isset($_POST['find'])) {
$colname_searching =$_POST['find'] ;
}
mysql_select_db($database_localhost, $localhost);


$query_searching = sprintf("SELECT * FROM information WHERE debtors LIKE %s ORDER BY id DESC", GetSQLValueString("%" . $colname_searching . "%", "text"));
$searching = mysql_query($query_searching, $localhost) or die(mysql_error());
$row_searching = mysql_fetch_assoc($searching);
$totalRows_searching = mysql_num_rows($searching);
if($totalRows_searching==0){
	header("Location: NoRecordFound.php");
}


//Session to pass the following search result.

$_SESSION['FindParties']=$_POST['find'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="TableCSSCode.css" rel="stylesheet" type="text/css" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Parties</title>

<link href="print.css" rel="stylesheet" type="text/css" media="print">

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:contain;
}
</style>

</head>

<body>

<h2>
  <form id="form1" name="form1" method="post" action="PrintAllSearchParties.php">
  <p id="PrintTitle">Please enter report header / title(e.g. "Report as at 31 December 2015")
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
<table id="table" border="1" cellpadding="2" cellspacing="0"
class="CSSTableGenerator">


    <tr>
      <td>No.</td>
    <td>Parties</td>
    <td>Nature Of Claim</td>
    <td>Statement Of Defence</td>
    <td>Status</td>
    <td id="Category">Category</td>
    <td id="Category">Keyword</td>
    <td id="Category">Date Modified</td>
    <td id="Modify">Modify</td>
  

 <?php $no=1;?>
  <?php do { //dont change this?>

  <tr>
      <td><?php echo $no++ ?></td>
      <td><?php echo $row_searching['debtors']; ?></td>
      <td><?php echo $row_searching['nature']; ?></td>
      <td><?php echo $row_searching['statement']; ?></td>
      <td><?php echo $row_searching['status']; ?></td>
      <td id="Category"><?php echo $row_searching['Category']; ?></td>
      <td id="Category"><?php echo $row_searching['Keyword']; ?></td>
      <td id="Category"><?php echo $row_searching['DateModify']; ?></td>
      <td id="Category"><a href="PrintPage.php?variable=<?php  echo  $no-1;?>,<?php  echo  $row_searching['ID'];?>">
        <input type="submit" name="button3" id="button3" value="Print" />
      </a><a href="edit.php?id=<?php echo $row_searching['ID']; ?>">
      <input type="submit" name="button" id="button5" value="Edit" />
      </a><a href="delete.php?id=<?php echo $row_searching['ID']; ?>">
      <input type="submit" name="button5" id="button2" value="Delete" onclick="return confirm('Are you sure you want to delete?');" />
      </a><a href="edit.php?id=<?php echo $row_searching['ID']; ?>">
      </a></td>
  </tr>
    <?php } while ($row_searching = mysql_fetch_assoc($searching)); ?>
</table>

<p>&nbsp;</p>

<p><a href="page2.php"></a>
</p>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($searching);
?>
