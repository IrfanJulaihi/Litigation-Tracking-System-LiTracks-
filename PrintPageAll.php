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
$query_Recordset1 = "SELECT * FROM information ORDER BY ID DESC";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="printPerPage.css" rel="stylesheet" type="text/css" media="print">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LiTrackS</title>
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:cover;
}
</style>
</head>

<body onload="window.print()">
<table  border="1" align="center" cellpadding="2" cellspacing="0" class="
">
  <?php $no=1;?>
<?php do {?>
  <tr style="" id="row1">
    <td width="124" ><div align="center"><strong>No</strong></div></td>
    <td width="124" ><div align="center"><strong>Parties</strong></div></td>
    <td width="117" ><div align="center"><strong>Nature of Claim</strong></div></td>
    <td width="136"  nowrap="nowrap"><div align="center"><strong>Statement of Defence</strong></div></td>
    <td width="115" ><div align="center"><strong>Status</strong></div></td>
  </tr>

     
  <tr>
    <td><div align="center"><?php echo $no++ ?></div></td>

      <td><div align="center"><?php echo $row_Recordset1['debtors']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['nature']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['statement']; ?></div></td>
      <td><div align="center"><?php echo $row_Recordset1['status']; ?></div></td>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
      
  </tr>
</table>
<p></p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
