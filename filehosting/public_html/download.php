<?php
require 'guard.php';
$message='';
if(!isset($_GET['u']) || !isset($_GET['i'])){
	$message = 'Invalid download!';
}else{
	$uid=$_GET['u'];
	$inode=$_GET['i'];
}
  
if(empty($uid) || !is_numeric($uid) || empty($inode) || !is_numeric($inode)){
	$message = 'Invalid download!';
}else{
	require 'dblink.php';
	$query = 'SELECT username FROM users WHERE userid='.$uid.';';
	if(!($res=@mysql_query($query))){
		$message = 'Invalid download!';
	}else{
		$details = @mysql_fetch_array($res);
		$username = $details['username'];
		$query = 'SELECT downloadable FROM '.$username.' WHERE inode='.$inode.';';
		if(!($res=@mysql_query($query))){
			$message = 'Invalid download!';
		}else{
			$details = @mysql_fetch_array($res);
			$downloadable = $details['downloadable'];
			if(strcmp($downloadable, 'yes')){
				$message = 'Sorry! You don\'t have permissions to download this file';
			}else{
				$query='SELECT name, mime, size, data, downloads FROM '.$username.' WHERE inode='.$inode.';';
				$res = @mysql_query($query);
				$details = @mysql_fetch_array($res);
				$filename = $details['name'];
				$mime = $details['mime'];
				$size = $details['size'];
				$data = $details['data'];
				$downloads = $details['downloads'];
				header('Content-Description: File Transfer');
				header('Content-Disposition: attachment; filename='.$filename);
				header('Content-type: '.$mime);
				header('Content-Transfer-Encoding: binary');
				header('Content-length: '.$size);  
				echo $data;
				ob_end_flush();
				$query = 'UPDATE '.$username.' SET downloads='.($downloads + 1).' WHERE inode='.$inode.';';
				$res = @mysql_query($query);
				$query = 'UPDATE '.$username.' SET downloaded=NOW() WHERE inode='.$inode.';';
				$res = @mysql_query($query);
			}
		}
	}
}
if(empty($message)) exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web-based file hosting system</title>
	<link rel="stylesheet" type="text/css" href="download.css">
</head>
<body style="margin:0; background-color:rgb(250, 250, 250);font-family:Verdana,Arial,serif; font-size:60%">
	<h1 style="margin:0; padding-top:1%; padding-bottom:1%; background-color:rgb(59, 89, 152); text-align:center; color:white">
		<table style="margin-left:2%; margin-right:2%; width:96%">
			<tr><td colspan="2" style="text-align:center">Web-based file hosting system</td></tr>
			<tr style="font-size:40%"><td style="text-align:center">A CS425 project by Jeetesh, Harshit, Kaustubh and Jitendra</td></tr>
		</table>
	</h1><br/><br/>
	<div align="center"><span id="message"><?php print $message; ?></span></div>
</body>
</html>
