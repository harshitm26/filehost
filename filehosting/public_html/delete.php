<?php
	require 'guard.php';
	require 'dblink.php';
	
	if(empty($_GET)){
		header("Location: inode.php");
		exit();
	}else if( $_GET['u'] != $_SESSION['userid'] || empty($_GET['i']) || !is_numeric($_GET['i']) || $_GET['i']==1){
		//print $_GET['u'].' <- u i->'.$_GET['i'];
		$_SESSION['message'] .= "Could not delete the file/directory\n";
		header("Location: inode.php");
		exit();
	}else{
		function delete($inode){
			$childrenquery = 'SELECT inode FROM '.$_SESSION['username'].' WHERE parent='.$inode.';';
			$deletequery = 'DELETE FROM '.$_SESSION['username'].' WHERE inode='.$inode.' LIMIT 1;';
			print $childrenquery."\n".$deletequery."\n";
			if(!($childrenres = mysql_query($childrenquery)) OR !($deleteres=mysql_query($deletequery))){
				$_SESSION['message'].="Could not delete the file/directory\n";
				return false;
			}else{
				while($details = mysql_fetch_array($childrenres)){
					delete($details['inode']);
				}
				return true;
			}
		}
		
		$parentquery = 'SELECT parent, downloadable FROM '.$_SESSION['username'].' WHERE inode='.$_GET['i'].' LIMIT 1;';
		print $parentquery."\n";
		if(!($parentres=mysql_query($parentquery))){
			$_SESSION['message'].="Could not delete the file/directory\n";
			header("Location: inode.php");
		}
		else{
			if(delete($_GET['i'])==true){
				$_SESSION['message'].="Successfully deleted the File/directory\n";
				$detail = mysql_fetch_array($parentres);
				$parent = $detail['parent'];
				$downloadable = $detail['downloadable'];
				$_SESSION['curinode']=$parent;
				$_SESSION['downloadable']=$downloadable;
				$_SESSION['refresh']=true;
				header("Location: inode.php");
				exit();
			}else{
				$_SESSION['message'].="Could not delete the file/directory\n";
				header("Location: inode.php");
			}
		}
	}
	require 'footer.php';
?>
