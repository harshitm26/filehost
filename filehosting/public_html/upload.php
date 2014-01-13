<?php
	
	//if(!empty($_FILES) AND isset($_FILES['userfile'])  AND !empty($_FILES['userfile']) ){
	if(isset($_FILES['userfile']['error']) AND $_FILES['userfile']['error'] != 4){
		//print 'upload section';
		if(($_FILES['userfile']['error']) > 0){
			$_SESSION['message'] .= "Could not receive the file; Error: ".$_FILES['userfile']['error']."\n";
		}else{
			$filename = mysql_real_escape_string(trim($_FILES['userfile']['name']));
			$type = mysql_real_escape_string(trim($_FILES['userfile']['type']));
			$size = mysql_real_escape_string(trim($_FILES['userfile']['size']));
			$tmp_name = $_FILES['userfile']['tmp_name'];
			$data = fread(fopen($tmp_name, "r"), filesize($tmp_name));
			//$data = mysql_real_escape_string($data);
			$data = mysql_real_escape_string($data);
			if(empty($filename) OR empty($type) || $size > 16000000 OR strcmp($_SESSION['downloadable'], 'NA') OR empty($data)){
				//print 'Could not upload the file';
				$_SESSION['message'] .= "Could not upload the file ".$filename."\n";
			}else{
				//print 'Uploading the file';
				$query = 'INSERT INTO '.$_SESSION['username'].' VALUES(0, "'.$filename.'", "f", '.$size.', "'.$type.'", '.$_SESSION['curinode'].', "'.$data.'", NOW(), NULL, 0, "yes");';
				//print $query;
				if(!($res = mysql_query($query))){
					$_SESSION['message'] .= "Could not upload the file ".$filename."; Database error: ".mysql_error()."\n";
				}else{
					$_SESSION['message'] .= "Successfully uploaded the file $filename\n";
					$_SESSION['refresh'] = true;
					$query = 'SELECT inode FROM '.$_SESSION['username'].' WHERE name="'.$filename.'";';
					if($res=@mysql_query($query)){
						$detail = @mysql_fetch_array($res);
						$_SESSION['curinode']=$detail['inode'];
						$_SESSION['downloadable']='yes';
					}
				}
			}
		}
	}
?>
