<?php
  ob_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Web-based File-hosting System</title>
</head>
<body style="margin:0; background-color:rgb(250, 250, 250);font-family:Verdana,Arial,serif; font-size:60%">
  <h1 style="margin:0; padding-top:1%; padding-bottom:1%; background-color:rgb(59, 89, 152); text-align:center; color:white">
  	  <table style="margin-left:2%; margin-right:2%; width:96%">
		  <tr><td colspan="2" style="text-align:center">Web-based file hosting system</td></tr>
		  <tr style="font-size:40%"><td style="text-align:center">A CS425 project by Jeetesh, Harshit, Kaustubh and Jitendra</td></tr>
		</table>
  </h1>
  <br/>
<?php
  ini_set('display_errors',1);
  error_reporting(E_ALL | E_STRICT);
  session_start();
  $message='';
  if(!empty($_SESSION['loggedin'])){
    ob_end_clean();
    header('Location: account.php');
    exit();
  }
  $username='';
  $password='';
  $res='';
  if(isset($_POST['username'])) $username = trim(substr($_POST['username'], 0, 255));
  if(isset($_POST['password'])) $password = trim(substr($_POST['password'], 0, 255));
  if(!isset($_POST['captcha'])) $message='';
  else if(empty($_POST['captcha'])) $message='You did not answer the captcha test!';
  else if(!isset($_SESSION['jetmango'])) $message='Please try again';
  else if($_POST['captcha']!=$_SESSION['jetmango']) $message='You did not pass the captcha test!';
  else if(!isset($_POST['username'])) $message='';
  else if(empty($username)) $message='Only usernames containing 1-255 alphanumeric characters allowed';
  else if(!isset($_POST['password'])) $message='';
  else if(empty($password)) $message='Only usernames containing 1-255 alphanumeric characters allowed';
  else if(isset($_POST['login'])){
	require 'dblink.php';
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	$query = 'SELECT userid FROM users WHERE username = "'.$username.'" AND password = "'.$password.'";';
	//print $query;
	if(!($res=@mysql_query($query))){
		$message = 'Problem with database. Please try again';
	}else{
		$details = @mysql_fetch_array($res);
			//print $details['userid'];
			if(empty($details['userid'])){
				$message='No such user-password pair';
			}else{
					$_SESSION['loggedin']=time();
					$_SESSION['userid']=$details['userid'];
					$_SESSION['curinode']=1;
					$_SESSION['downloadable']='NA';
					$_SESSION['username']=$username;
					header('Location: account.php');
					exit();
			}
	}
  }
  else if(isset($_POST['register'])){
	  require 'dblink.php';
	  $username = mysql_real_escape_string(trim($_POST['username']));
	  $password = mysql_real_escape_string(trim($_POST['password']));
	  $query = 'SELECT COUNT(*) AS num FROM users WHERE username="'.$username.'";';
	  if(!($res=@mysql_query($query))){
		  $message='Problem with database. Please try again after sometime.';
	  }else{
		  $details = @mysql_fetch_array($res);
		  if($details['num']>0){
			  $message='Please try a different username.';
		  }else{
				$query = 'CREATE TABLE '.$username.' (
				inode INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name varchar(255) NOT NULL DEFAULT \'Untitled\',
				filedir char(1),
				size BIGINT UNSIGNED DEFAULT 0,
				mime varchar(32) DEFAULT "text/plain",
				parent INT UNSIGNED NOT NULL,
				data MEDIUMBLOB,
				uploaded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				downloaded TIMESTAMP,
				downloads INT UNSIGNED NOT NULL,
				downloadable char(4));';
			  if(!($res=@mysql_query($query))){
				$message='Problem with database. Please try again.';
			  }else{
				$query = 'INSERT INTO users VALUES(0, "'.$username.'", "'.$password.'");';
				$home = 'INSERT INTO '.$username.' VALUES(
							0, "home", \'d\', 0, NULL, 0, NULL, NOW(), NULL, 0, "NA");';
							
				if(!($res=@mysql_query($query)) || !($res=mysql_query($home))){
					$message='Fatal problem with database. Please try again.';
				}else{
					$message='Registered successfully';
				}
			  }
		  }
	  }
  }
?>
  <form action="index.php" method="post">
  <table style="margin-left:30%; margin-right:30%; width:40%; background-color:rgb(237, 239, 244); text-align:center; color:rgb(51,51,51); font-size:130%">
  <tr><td colspan="2" >Username</td></tr>
  <tr><td colspan="2" ><input type="text" maxlength="255" name="username" size="20" /></td>
  <tr><td colspan="2" >Password</td></tr>
  <tr><td colspan="2" ><input type="password" maxlength="255" name="password" size="20"/></td></tr>
  </tr></table>
  <br/><br/><br/><br/>
  <table style="margin-left:30%; margin-right:30%; width:40%; background-color:rgb(237, 239, 244); text-align:center; color:rgb(51,51,51); font-size:130%">
  <tr><td colspan="2" >Please type the letters shown.</td></tr>
  <tr><td colspan="2" ><br/></td></tr>
  <tr><td colspan="2" ><img src="./captcha.php"/></td></tr>
  <tr><td colspan="2" ><br/></td></tr>
  <tr><td colspan="2" ><input type="text" maxlength="6" name="captcha" size="12" /></td></tr>
  <tr><td><input type="submit" name="login" value="Log in"/></td><td><input type="submit" name="register" value="Register"/></td></tr>
<?php
  if(!empty($message)) print '<tr><td colspan="2" style="font-weight:bold; color:red">'.$message.'</td></tr>';
?>
  </form></table></body></html>
<?php
	  ob_end_flush();
	  exit();
?>
