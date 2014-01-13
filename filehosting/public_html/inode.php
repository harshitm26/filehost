<?php
	require 'guard.php';
	require 'dblink.php';
	
	if(!empty($_GET['inode'])){
		$inode = $_GET['inode'];
		
	}
	else{
		$inode = $_SESSION['curinode'];
	}

		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>CS425: Web-based file-hosting system</title>
		<link rel="stylesheet" type="text/css" href="inode.css"/>
	</head>
<body>
<?php
	if(empty($_SESSION['message'])) $_SESSION['message']='';
	if(!empty($_POST)){
		
		$downloadable = (isset($_POST['downloadable'])?'yes':'no');
		if(strcmp($_SESSION['downloadable'],'NA')
			&& strcmp($_SESSION['downloadable'], $downloadable)){
			$query = 'UPDATE '.$_SESSION['username'].' SET downloadable="'.$downloadable.'" WHERE inode='.$_SESSION['curinode'].';';
			$_SESSION['downloadable']=$downloadable;
			//print $_SESSION['downloadable'];
			if(!($res = mysql_query($query))){
				$_SESSION['message'].="Could not change the 'downloadable' status \n";
			}else{
				$_SESSION['message'].="'downloadable' status changed successfully \n";
			}
		}
		
		if(!empty($_POST['newname'])){
			$effname = mysql_real_escape_string(trim($_POST['newname']));
			
			$query = 'UPDATE '.$_SESSION['username'].' SET name="'.$effname.'" WHERE inode='.$_SESSION['curinode'].';';
			if(empty($effname) || !($res = mysql_query($query))){
				$_SESSION['message'].="Could not rename the file \n";
			}else{
				$_SESSION['message'].="File/Directory renamed successfully to $effname \n";
				$_SESSION['refresh']=true;
			}
		}
		
		if(!empty($_POST['subdirectory']) && !strcmp($_SESSION['downloadable'], 'NA')){
			$effname = mysql_real_escape_string(trim($_POST['subdirectory']));
			$query = 'INSERT INTO '.$_SESSION['username'].' VALUES( 0, "'.$effname.'", \'d\', 0, NULL, '.$_SESSION['curinode'].', NULL, NOW(), NULL, 0, "NA");';
			//print $query;
			if(empty($effname) || !($res = mysql_query($query))){
				$_SESSION['message'].="Could not create the subdirectory \n";
			}else{
				$_SESSION['message'].="Subdirectory $effname created successfully \n";
				$_SESSION['refresh']=true;
				$query='SELECT inode from '.$_SESSION['username'].' WHERE name="'.$effname.'";';
				if($res=mysql_query($query)){
					$detail = mysql_fetch_array($res);
					$_SESSION['curinode']=$detail['inode'];
					$_SESSION['downloadable']='NA';
					$inode = $detail['inode'];
				}
			}
		}
	}
	require 'upload.php';
	
	if(isset($_SESSION['refresh'])){
		//print 'Delete signal received';
		print '<script>parent.leftpane.location.reload(); </script>';
		unset($_SESSION['refresh']);
	}
			
			
	
	$query = "SELECT * FROM ".$_SESSION['username']." WHERE inode=".$inode." LIMIT 1;";
	if($details=@mysql_query($query)){
		$detail = @mysql_fetch_array($details);
		if($detail['filedir']=='f'){
			$_SESSION['curinode']=$inode;
			$_SESSION['downloadable']=$detail['downloadable'];
			print '<form action="inode.php" method="post">';
			print '<table>';
			print '<tr><td>NAME</td><td>'.$detail['name'].'</td></tr>';
			print '<tr><td>SIZE</td><td>'.$detail['size'].' bytes</td></tr>';
			print '<tr><td>TYPE</td><td>'.$detail['mime'].'</td></tr>';
			print '<tr><td>UPLOADED AT</td><td>'.$detail['uploaded'].'</td></tr>';
			print '<tr><td>LAST DOWNLOAD AT</td><td>'.$detail['downloaded'].'</td></tr>';
			print '<tr><td colspan="2"><a href="./download.php?u='.$_SESSION['userid'].'&i='.$detail['inode'].'" onClick="var c = setTimeout( \'parent.rightpane.location.reload();\' , 100 )" >DOWNLOAD LINK</a></td></tr>';
			print '<tr><td>#DOWNLOADS</td><td>'.$detail['downloads'].'</td></tr>';
			//print $detail['downloadable'];
			//print strcmp($detail['downloadable'], 'yes');
			
			print '<tr><td>DOWNLOADABLE?</td><td><input type="checkbox" name="downloadable" value="Yes" id="downloadable">';
			
			//print $detail['downloadable'];
			//print strcmp($detail['downloadable'], 'yes');
			$checked = strcmp($detail['downloadable'],'yes')?'':'true';
			//print $checked;
			print '<script> document.getElementById("downloadable").checked="'.$checked.'"</script></td></tr>';
			
			
			print '<tr><td>RENAME</td><td><input type="textbox" name="newname" id="newname" /></td></tr>';
			print '<tr><td colspan="2"><a href="./delete.php?u='.$_SESSION['userid'].'&i='.$detail['inode'].'">DELETE</a></td></tr>';
			print '<tr><td colspan="2"><input type="submit" name="submit" value="Send"/></td></td></tr>';
			print '</table></form>';
		}
		else if($detail['filedir']=='d'){
			$_SESSION['curinode']=$inode;
			$_SESSION['downloadable']='NA';
			print '<form action="inode.php" method="post" enctype="multipart/form-data">';
			print '<input type="hidden" name="MAX_FILE_SIZE" value="16000000">';
			print '<table>';
			print '<tr><td>NAME</td><td>'.$detail['name'].'</td></tr>';
			print '<tr><td>CREATED AT</td><td>'.$detail['uploaded'].'</td></tr>';
			print '<tr><td>LAST ACCESSED AT</td><td>'.$detail['downloaded'].'</td></tr>';
			print '<tr><td>RENAME</td><td><input type="textbox" name="newname" id="newname"/></td></tr>';
			print '<tr><td colspan="2"><a href="./delete.php?u='.$_SESSION['userid'].'&i='.$detail['inode'].'">DELETE</a></td></tr>';
			print '<tr><td>CREATE SUBDIRECTORY</td><td><input type="textbox" name="subdirectory" id="subdirectory"/></td></tr>';
			print '<tr><td>UPLOAD</td><td><input type="file" name="userfile" id="userfile" value="userfile"/></td></tr>';
			print '<tr><td colspan="2"><input type="submit" name="submit" value="Send"/></td></td></tr>';
			print '</table></form>';
		}
		else{
			print 'Oops! An error has occurred';
		}
		print "\n <br/><span id=\"feedback\">".nl2br($_SESSION['message'])."<br/></span> \n";
		
	}else{
		print 'No such file/directory';
	}
	$_SESSION['message']='';
?>
</body>
</html>
<?php
	require 'footer.php';
?>
