<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
error_reporting(E_ERROR|E_WARNING);
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
if($_SESSION['DIVISION']=='LAD'){
$query_Recordset1 = sprintf("SELECT * FROM information WHERE nature LIKE %s ORDER BY ID DESC", 
GetSQLValueString("%" .$_SESSION['FindNatureGuest'] . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
}else{
$query_Recordset1 = sprintf("SELECT * FROM information WHERE nature LIKE %s and Category Like %s ORDER BY ID DESC", GetSQLValueString("%" .$_SESSION['FindNatureGuest'] . "%", "text"),
GetSQLValueString("%" . $_SESSION['DIVISION'] . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All</title>
</head>
<link href="PrintPageAll.css" rel="stylesheet" type="text/css" media="print">

<body onload="window.print()">
<div align="center">
  <h2><?php echo $_POST['PrintTitle']?></h2>
  <p align="left"><a href="page2.php">
    <input type="submit" name="button" id="button" value="Back" />
  </a></p>
  <table id="table" border="1" cellpadding="2" cellspacing="0"
class="CSSTableGenerator">
      <?php $no=1;?>
  
   
    <tr div align="center">
      <td style="background-color:grey;">No.</td>
      <td style="background-color:grey;">Parties</td>
      <td style="background-color:grey;">Nature Of Claim</td>
      <td style="background-color:grey;">Statement Of Defence</td>
      <td style="background-color:grey;">Status</td>
  
      
    </tr>
  <?php do { //dont change this?>
    <tr>
      <td><?php echo $no++ ?></td>
      <td><?php echo $row_Recordset1['debtors']; ?></td>
      <td><?php echo $row_Recordset1['nature']; ?></td>
      <td><?php echo $row_Recordset1['statement']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
  <p>&nbsp;</p>

</div>
 
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
