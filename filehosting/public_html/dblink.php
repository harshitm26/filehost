<?php
$dbc = @mysql_connect("localhost", "cs425", "jeeteshm");
if(!@mysql_select_db("filehost", $dbc)){ 
	print '<style="text-align:center"></style>Problem in connecting to database.<br/>Please try again after sometime.<br/></style>';
	exit();
}
//die(mysql_errno() . ": " . mysql_error() . "<br>");
?>
