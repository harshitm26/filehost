<?php
	require 'guard.php';
	require 'dblink.php';
	function print_dir($inode){
		//echo '$inode='.$inode;
		$query = "SELECT * FROM ".$_SESSION['username']." WHERE parent=".$inode." ORDER BY name ASC;";
		//echo '$query='.$query;
		if($dirents = @mysql_query($query)){
			while($dirent = mysql_fetch_array($dirents)){
				if($dirent['filedir']=='f'){
					print '<dl>';
					print '<dt><a target="rightpane" href="./inode.php?inode='.$dirent['inode'].'">'.stripslashes($dirent['name']).'</a></dt>';
					print '</dl>';
				}
				else if($dirent['filedir']=='d'){
					print '<dl>';
					print '<dt><a target="rightpane" href="./inode.php?inode='.$dirent['inode'].'">'.$dirent['name'].'</a></dt>';
					print '<dd>';
					print_dir($dirent['inode']);
					print '</dd>';
					print '</dl>';
				}
				else {
					print 'Oops! An error!';
				}
			}
		}
		else{
			print 'No such directory<br/>';
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Web-based file hosting system</title>
  <link rel="stylesheet" type="text/css" href="directory.css"/>
</head>
<body style="margin:0; background-color:rgb(250, 250, 250);font-family:Verdana,Arial,serif; font-size:60%">
	
<?php
	if(!empty($_SESSION['curdir'])) print_dir($_SESSION['curdir']);
	else print_dir(0);
?>
</body>
</html>
<?php
	require 'footer.php';
	?>

	


