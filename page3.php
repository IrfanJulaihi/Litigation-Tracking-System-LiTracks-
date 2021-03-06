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
$MM_authorizedUsers = "2";
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

$MM_restrictGoTo = "page4.php";
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

$query_Recordset1 ="SELECT * FROM userinfo WHERE username='".$_SESSION['MM_Username']."'";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$_SESSION['DIVISION']=$row_Recordset1['Division'];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['page'])) {
  $pageNum_Recordset1 = $_GET['page'];
}
$_GET['page']=0;
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$maxRow=$pageNum_Recordset1 * $maxRows_Recordset1 + $maxRows_Recordset1;
$DisplayNumberRow=$startRow_Recordset1+1;
mysql_select_db($database_localhost, $localhost);
if($_SESSION['DIVISION']=='LAD'){
$query_Recordset1 = "SELECT * FROM information ORDER BY ID DESC ";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1,$startRow_Recordset1 , $maxRow);
$Recordset1 = mysql_query($query_limit_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
}else{
$query_Recordset1 = "SELECT * FROM information WHERE Category= '".$_SESSION['DIVISION']."' ORDER BY ID DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1,$startRow_Recordset1 , $maxRow);
$Recordset1 = mysql_query($query_limit_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
}
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  //total rows in database
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1);
?>

<!doctype html>
<html>
<head>
<link href="TableCSSCode.css" rel="stylesheet" type="text/css" >
<meta charset="utf-8">
<title>Main Menu</title>


<link href="print.css" rel="stylesheet" type="text/css" media="print">
<style>
/* unvisited link */
a:visited {
    color: green;
}

/* visited link */
a:visited {
    color: blue;
}

/* mouse over link */
a:hover {
    color: red;
}

/* selected link */

</style>
<style type="text/css">
body {
	background-image: url(white-abstract-75-wallpaper-background-hd.jpg);
	background-size:contain;
}
</style>
<link href="tableDesign.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body id="find">

<h1><img src="SEDC Logo - Copy.png" alt="sedclogo" width="249" height="210"></h1>

<p style="font-weight:normal;color:#000000;position: absolute; top: 12px; left: 1064px;letter-spacing:1pt;word-spacing:2pt;font-size:20px;text-align:left;font-family:arial black, sans-serif;line-height:1;">You logged in as, <span style="text-shadow:1px 1px 1px rgba(107,107,107,1);font-weight:normal;color:#0F2FFC;letter-spacing:1pt;word-spacing:2pt;font-size:25px;text-align:left;font-family:arial black, sans-serif;line-height:1;">Staff </span></p>
<p style="text-shadow:1px 1px 1px rgba(107,107,107,1);font-weight:normal;color:#0F2FFC;letter-spacing:1pt;word-spacing:2pt;font-size:25px;text-align:left;font-family:arial black, sans-serif;line-height:1;">&nbsp;</p>
<p style="text-shadow:1px 0px 5px rgba(97,94,82,1);font-weight:normal;color:#D9B541;letter-spacing:3pt;word-spacing:2pt;font-size:64px;text-align:center;font-family:impact, sans-serif;line-height:1;margin:0px;padding:0px;">                                     LiTrackS</p>
<h1 align="center" style="font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif"">Litigation Tracking System</h1>
<h1 align="left" style="font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size: 14px;""><span style="text-shadow:1px 1px 1px rgba(107,107,107,1);font-weight:normal;color:#000000;letter-spacing:1pt;word-spacing:2pt;font-size:18px;text-align:left;font-family:arial black, sans-serif;line-height:1;margin:0px;padding:0px;">WELCOME,<?PHP echo $_SESSION['MM_Username'];?> </span></h1>
<h1 align="left" style="font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size: 14px;"">Division:<?php echo $_SESSION['DIVISION']?></h1>

<ul id="MenuBar1" class="MenuBarHorizontal">
<li><a href="#" class="MenuBarItemSubmenu">Edit Account</a>
    <ul>
      <li><a href="editStaffInfo.php">Edit User Info</a></li>
      <li><a href="newStffPass.php">Change Password</a></li>
    </ul>
  </li>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
</ul>
<p align="left">&nbsp;</p>
  
<form action="searchdebtorsGuest.php" method="post">
  <p>
    <input name="find" type="text" id="buttonfind">
    <input type="submit" value="Search for Parties" id="buttonfind1">
  </p>
</form>

<form action="searchnatureGuest.php" method="post">
  <p>
    <input name="findnature" type="text" id="buttonfind1">
    <input type="submit" value="Search for Nature of Claim" id="buttonfind1">
</p>
</form>

<form action="searchstatusGuest.php" method="post">
  <p>
    <input name="findstatus" type="text" id="buttonfind3">
    <input type="submit" value="Search for Status" id="buttonfind2">
  </p>
</form>

<form action="searchcategory.php" method="post">
  <p>
  <!--if staff access level equal to Lad it will show-->
  <?php if ($_SESSION['DIVISION']=='LAD'){ ?>
  <select name="category">
    <option value="General">General(LAD)</option>
    <option value="PTY">Property Division(PTY)</option>
    <option value="AGRO">Agro-Food Based Division(AGRO)</option>
    <option value="EDD">Entrepreneur Development Division(EDD)</option>
    <option value="HRA">Human Resource & General Administration Division(HRA)</option>
  </select>
  <input type="submit" value="Search for Category" id="buttonfind7">
    <?php } ?>
    
 
  </p>
</form> 
<form action="searchkeywordGuest.php" method="post">
  <p>
    <input name="findKeyword" type="text" id="buttonfind8">
    <input type="submit" value="Search for Keyword" id="buttonfind9">
  </p>
</form>
</form>
<p>&nbsp;</p>
<p style="position: absolute; left: 34px; top: 751px;"> There are <?php echo $totalRows_Recordset1  ?> records found.</p>
<p>&nbsp;</p>
<table width="156%"  border="1" align="center" cellpadding="2" cellspacing="0" class="CSSTableGenerator">
  <tr style="background-color:#960;">
    <td ><strong>No.</strong></td>
    <td ><div align="center"><strong>Parties</strong></div></td>
    <td ><div align="center"><strong>Nature of Claim</strong></div></td>
    <td ><div align="center"><strong>Statement of Defence</strong></div></td>
    <td ><div align="center"><strong>Status</strong></div></td>
    <td ><div align="center">Category</div></td>
    <td ><div align="center">Keyword</div></td>
    <td ><div align="center">Date Modified</div></td>
    <td ><div align="center">Print</div></td>
  </tr><?php $no=1;?>
  <?php do { ?>
  <tr>
    <td><?php echo  $DisplayNumberRow++?></td>
    <td><?php echo $row_Recordset1['debtors']; ?></td>
    <td><?php echo $row_Recordset1['nature']; ?></td>
    <td><?php echo $row_Recordset1['statement']; ?></td>
    <td><?php echo $row_Recordset1['status']; ?></td>
    <td><?php echo $row_Recordset1['Category']; ?></td>
    <td><?php echo $row_Recordset1['Keyword']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($row_Recordset1['DateModify']))?><br>
    <?php echo date("H:i:s",strtotime($row_Recordset1['DateModify']))?></td>
    <td><a href="PrintPage.php?variable=<?php  echo  $DisplayNumberRow-1;?>,<?php  echo  $row_Recordset1['ID'];?>">
      <input type="submit" name="button" id="button2" value="Print">
    </a></td>
    </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p>&nbsp;</p>
<p align="center">
  <script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
  </script>
Page:
<?php
for($b=1;$b<=$totalPages_Recordset1;$b++){?>
<a href="page3.php?page=<?php echo $b-1?>" style="font-size:22px;text-decoration:none"><?php echo $b." ";?></a>
<?php
 } ?>
</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
