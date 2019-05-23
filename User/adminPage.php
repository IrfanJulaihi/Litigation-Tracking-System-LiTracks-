<?php require_once('Connections/localhost.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "homepage.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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

$MM_restrictGoTo = "page3.php";
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

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM information";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$query_Recordset1 = "SELECT * FROM information, userinfo";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset1 = "SELECT information.id, information.debtors, information.nature, information.`statement`, information.status FROM information";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Recordset2 = "SELECT information.id FROM information";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT userinfo.password FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT id FROM information";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$query_Recordset2 = "SELECT * FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT * FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT * FROM information";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT * FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT * FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$query_Recordset2 = "SELECT * FROM userinfo";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Main Menu</title>


<link href="print.css" rel="stylesheet" type="text/css" media="print">
<style type="text/css">
.sidebar1 {	float: left;
	width: 180px;
	background-color: #EADCAE;
	padding-bottom: 10px;
}
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	overflow: auto;
	color: #000;
}
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="tableDesign.css" rel="stylesheet" type="text/css">
</head>

<body id="find">
<p><img src="01_sedc_logo (1).gif" width="175" height="67">

  <br>
<p align="center" style="font-size: 20px; position: absolute; top: 12px; left: 1064px; height: 44px; width: 247px;">You logged in as Admin</p>
    

<h1 align="center">Litigation Tracking Records</h1>
<p style="font-size:24px;">&nbsp;Welcome,<?php echo $_SESSION['MM_Username']; ?></p>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="#" class="MenuBarItemSubmenu">View List Of Members</a>
    <ul>
      <li><a href="listAdmin.php">Admin</a></li>
      <li><a href="listMaintenance.php">Maintenance</a></li>
      <li><a href="listGuest.php">Staff</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">Record Action</a>
    <ul>
      <li><a href="addNew.php">Add New</a></li>
      <li><a href="" onclick="window.print()">Print</a></li>
    </ul>
  </li>
  <li><a class="MenuBarItemSubmenu" href="#">Create New user</a>
    <ul>
      <li><a href="register.php">Admin User</a>      </li>
      <li><a href="registerMaintenance.php">Staff User</a></li>
      <li><a href="registerGuest.php">Guest User</a></li>
    </ul>
  </li>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>




<form action="search.php" method="post">
  <p>
    <input name="find" type="text" id="buttonfind">
    <input type="submit" value="Search for Debtors" id="buttonfind1">
 </p>
</form>

<form action="searchnature.php" method="post">
  <p>
    <input name="findnature" type="text" id="buttonfind1">
    <input type="submit" value="Search for Nature of Claim" id="buttonfind1">
</p>
</form>

<form action="searchstatement.php" method="post">
  <p>
    <input name="findstatement" type="text" id="buttonfind2">
    <input type="submit" value="Search for Statement" id="buttonfind1">
  </p>
</form>

<form action="searchstatus.php" method="post">
  <p>
    <input name="findstatus" type="text" id="buttonfind3">
    <input type="submit" value="Search for Status" id="buttonfind1">
  </p>
  
    <table  border="1" align="center" cellpadding="2" cellspacing="0" class="tableDesign">
      <tr >
        <td  ><div align="center"><strong>ID</strong></div></td>
        <td ><div align="center"><strong>Debtors</strong></div></td>
        <td ><div align="center"><strong>Nature of Claim</strong></div></td>
        <td  nowrap="nowrap"><div align="center"><strong>Statement</strong></div></td>
        <td ><div align="center"><strong>Status</strong></div></td>
        <td colspan="2"><div align="center"><strong>Modify</strong></div></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Recordset1['id']; ?></td>
          <td><?php echo $row_Recordset1['debtors']; ?></td>
          <td><?php echo $row_Recordset1['nature']; ?></td>
          <td><?php echo $row_Recordset1['statement']; ?></td>
          <td><?php echo $row_Recordset1['status']; ?></td>
          <td ><a href="edit.php?id=<?php echo $row_Recordset2['id']; ?>">
            <input type="submit" name="button3" id="button2" value="Edit">
          </a></td>
          <td ><a href="delete.php?id=<?php echo $row_Recordset2['id']; ?>">
            <input type="submit" name="button3" id="button3" value="Delete" onClick="return confirm('Are you sure you want to delete?');">
          </a></td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </table>
  
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<p></p>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
