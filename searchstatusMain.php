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

$colname_searchStatus = "-1";
if (isset($_POST['findstatus'])) {
  $colname_searchStatus = $_POST['findstatus'];
}
mysql_select_db($database_localhost, $localhost);
$query_searchStatus = sprintf("SELECT * FROM information WHERE status LIKE %s", GetSQLValueString("%" . $colname_searchStatus . "%", "text"));
$searchStatus = mysql_query($query_searchStatus, $localhost) or die(mysql_error());
$row_searchStatus = mysql_fetch_assoc($searchStatus);
$totalRows_searchStatus = mysql_num_rows($searchStatus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Status</title>

<link href="print.css" rel="stylesheet" type="text/css" media="print">

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
}
</style>

</head>

<body>
<p>&nbsp;</p>
<h2>
  <p>&nbsp;</p></h2>

<table border="1" cellpadding="2" cellspacing="0">
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
      <td><?php echo $row_searchStatus['id']; ?></td>
      <td><?php echo $row_searchStatus['debtors']; ?></td>
      <td><?php echo $row_searchStatus['nature']; ?></td>
      <td><?php echo $row_searchStatus['statement']; ?></td>
      <td><?php echo $row_searchStatus['status']; ?></td>
      <td><a href="editMaintenance.php?id=<?php echo $row_searchStatus['id']; ?>">
        <input type="submit" name="button2" id="button2" value="Edit" />
      </a></td>
      <td><a href="deletepage4.php?id=<?php echo $row_searchStatus['id']; ?>">
        <input type="submit" name="button3" id="button3" value="Delete" onclick="return confirm('Are you sure you want to delete?');" />
      </a></td>
    </tr>
    <?php } while ($row_searchStatus = mysql_fetch_assoc($searchStatus)); ?>
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
mysql_free_result($searchStatus);
?>
