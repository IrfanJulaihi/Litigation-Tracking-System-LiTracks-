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
$query_listMaintenance = "SELECT * FROM maintenanceinfo";
$listMaintenance = mysql_query($query_listMaintenance, $localhost) or die(mysql_error());
$row_listMaintenance = mysql_fetch_assoc($listMaintenance);
$totalRows_listMaintenance = mysql_num_rows($listMaintenance);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maintenance Team Details</title>

<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
}
</style>

</head>

<body>

<h2>&nbsp;</h2>
<h2 align="center">
  <p align="center">List of Maintenance Teams' Username & Password</p>
</h2>

<div align="center">
  <table border="1" cellpadding="2" cellspacing="0">
    <tr>
      <td>Username</td>
      <td>Password</td>
      <td>Modify</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_listMaintenance['username']; ?></td>
        <td><?php echo $row_listMaintenance['password']; ?></td>
        
        <td><a href="deleteListMaintenance.php?username=<?php echo $row_listMaintenance['username']; ?>">
          <input type="submit" name="button2" id="button2" value="Delete" onclick="return confirm('Are you sure you want to delete?');" />
        </a></td>
      </tr>
      <?php } while ($row_listMaintenance = mysql_fetch_assoc($listMaintenance)); ?>
  </table>
</div>
<p align="center"><a href="page2.php">
  <input type="submit" name="button" id="button" value="Back" />
</a></p>
</body>
</html>
<?php
mysql_free_result($listMaintenance);
?>
