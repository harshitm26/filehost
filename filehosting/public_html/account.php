<?php
	require 'guard.php';
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Web-based file hosting system</title>
  <link rel="stylesheet" type="text/css" href="account.css">
</head>
<body style="margin:0; background-color:rgb(250, 250, 250);font-family:Verdana,Arial,serif; font-size:60%">
  <h1 style="margin:0; padding-top:1%; padding-bottom:1%; background-color:rgb(59, 89, 152); text-align:center; color:white">
	  <table style="margin-left:2%; margin-right:2%; width:96%">
		  <tr><td colspan="2" style="text-align:center">Web-based file hosting system</td></tr>
		  <tr style="font-size:40%"><td style="text-align:center">A CS425 project by Jeetesh, Harshit, Kaustubh and Jitendra</td></tr>
<?php
  if(!($dbc = @mysql_connect('localhost', 'cs425', 'jeeteshm'))){
      unset($_SESSION);
      session_destroy();
      exit('</table></h1><br/><div style="text-align:center">Problem in connecting to database. Please try again after sometime.</div><br/>');
      ob_end_flush();
  }
  print '<tr><td class="righttext"><form action="account.php" method="post"><input tabindex="6" type="submit" name="logout" class="sixty" value="Log out"/></form></td></tr></table></h1>';
?>

<table id="widetable">
<tr><td class="leftpane" style="width: 30%"><iframe class="leftpane" name="leftpane" id="leftpane" src="./directory.php" ></iframe></td>
<td class="rightpane"><iframe class="rightpane" src="./inode.php" name="rightpane" id="rightpane"></iframe></td></tr>
</table>

</body></html>
<?php
	ob_end_flush();
?>
	
