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
$query_searching = "SELECT * FROM information ORDER BY id ASC";
$searching = mysql_query($query_searching, $localhost) or die(mysql_error());
$row_searching = mysql_fetch_assoc($searching);
$totalRows_searching = mysql_num_rows($searching);$colname_searching = "-1";
if (isset($_POST['find'])) {
  $colname_searching = $_POST['find'];
}
mysql_select_db($database_localhost, $localhost);
$query_searching = sprintf("SELECT * FROM information WHERE debtors LIKE %s", GetSQLValueString("%" . $colname_searching . "%", "text"));
$searching = mysql_query($query_searching, $localhost) or die(mysql_error());
$row_searching = mysql_fetch_assoc($searching);
$totalRows_searching = mysql_num_rows($searching);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Debtors</title>

<link href="print.css" rel="stylesheet" type="text/css" media="print">

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
}
</style>
<link href="TableCSSCode.css" rel="stylesheet" type="text/css" >

</head>

<body>
<h2>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</h2>
<table border="1" cellpadding="2" cellspacing="0" class="CSSTableGenerator">
  <tr>
    <td>ID</td>
    <td>Debtors</td>
    <td>Nature Of Claim</td>
    <td>Statement</td>
    <td>Status</td>
    <td colspan="2">Modify</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_searching['id']; ?></td>
      <td><?php echo $row_searching['debtors']; ?></td>
      <td><?php echo $row_searching['nature']; ?></td>
      <td><?php echo $row_searching['statement']; ?></td>
      <td><?php echo $row_searching['status']; ?></td>
      <td><a href="editMaintenance.php?id=<?php echo $row_searching['id']; ?>"><input type="submit" name="button" id="button" value="Edit" />
        
      </a></td>
      <td><a href="deletepage4.php?id=<?php echo $row_searching['id']; ?>"><input type="submit" name="button2" id="button2" value="Delete" onclick="return confirm('Are you sure you want to delete?');" /></a>
      </td>
    </tr>
    <?php } while ($row_searching = mysql_fetch_assoc($searching)); ?>
</table>

<p>&nbsp;</p>

<p>
<a href="page4.php"><input type="submit" name="button" id="button" value="Back"></a>
</p>

<a titlt="print screen" alt="print screen" onclick="window.print();"target="_blank" style="cursor:pointer;"><input type="submit" name="button2" id="buttonprint" value="Print">
</a>

</body>
</html>
<?php
mysql_free_result($searching);
?>
