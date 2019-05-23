<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>No Records Found</title>
<style>
body{
background-size:cover;

}
</style>

</head>

<body background="white-abstract-75-wallpaper-background-hd.jpg" >
<div align="center">
  <p>&nbsp;</p>
  
  <p align="left" style="font-size:28px;color:black;">Your search
-    
    <strong>
    <?php session_start(); echo $_SESSION["SearchItem"];?>
  </strong>  - did not match any records.</p>
  <p align="left"><a href="page2.php">
    <input type="submit" name="button4" id="button4" value="Back" />
  </a></p>
  <p align="left">&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p style="font-size:32px;color:red;"> </p>
</div>
</body>
</html>