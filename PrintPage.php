<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
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
// Output to get from the a href array
$editFormAction = $_SERVER['PHP_SELF'];
  $variable = explode(",", $_GET["variable"]);
$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM information WHERE ID = %s", GetSQLValueString($variable[1], "int"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$_SESSION['NoInTable']=$variable[0];
$_SESSION['NoOfRecords']=$variable[1];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LiTrackS</title>
<link href="TableCSSCode.css" rel="stylesheet" type="text/css" >
<script>
function myFunction() {
    var Title = prompt("Please enter Title of Subject", "Eg.Summons on ABC");
    var Dates = prompt("Please enter the Date", "Eg.12 January 2011 ");
    
	document.getElementById("Title").innerHTML = Title;
	document.getElementById("Dates").innerHTML = Dates;
	
		
		

    
}
</script>


</head>
<link href="printPerPage.css" rel="stylesheet" type="text/css" media="print">
<body background="white-abstract-75-wallpaper-background-hd.jpg"
style="background-size:cover;">
<p id="Title" align="center"></p>
<table  border="1" align="center" cellpadding="2" cellspacing="0" class="
">
  <tr style="" id="row1">
    <td width="124" ><div align="center"><strong>NO.</strong></div></td>
    <td width="124" ><div align="center"><strong>Parties</strong></div></td>
    <td width="117" ><div align="center"><strong>Nature of Claim</strong></div></td>
    <td width="136"  nowrap="nowrap"><div align="center"><strong>Statement of Defence</strong></div></td>
    <td width="115" ><div align="center"><strong>Status</strong></div></td>
  </tr>

  <tr>
    <td><div align="center"><?php echo $variable[0]; ?></div></td>
    <td><div align="center"><?php echo $row_Recordset1['debtors']; ?></div></td>
    <td><div align="center"><?php echo $row_Recordset1['nature']; ?></div></td>
    <td><div align="center"><?php echo $row_Recordset1['statement']; ?></div></td>
    <td><div align="center"><?php echo $row_Recordset1['status']; ?></div></td>
  </tr>
</table>


<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="PrintPageWithTitle.php">
<p id="PrintTitle">Please enter report header / title(e.g. &quot;Report as at 31 December 2015&quot;)
<label for="PrintTitle"></label>

  <input type="text" name="PrintTitle" size="50" value=""/>
</p>
<p>
  
    <input type="submit"  name="button2" value="Print " id="button" />

</form>
<p><a href="page2.php"></a> <a href="page2.php">
  <input type="submit" id="back" value="Back" />
</a></p>
</body></html>