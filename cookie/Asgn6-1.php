<?php
function redisplayForm($id) {
if (isset($_COOKIE['id'])) {
	$id=$_COOKIE['id'];
	} else {
	$ids=''; 
}
?>
<form name="cookieform" action="Asgn6-1.php"
	method="post">
<p>ID: <input type="text" name="id"
value="<?php echo $id; ?>" /></p>

<p>Password: <input type="password" name="pw"
/></p>

<p>Remember my login ID: <input type="checkbox" name="save" value="cookie">
<br>
<input type="submit" name="Submit" value="Send"/>
</form>
<?php
}
function validateInput($data, $fieldName) {
	global $errorCount;
    	if (empty($data)) {
		echo "Data entry error at \"$fieldName\".<br />";
        	echo "an error message of $data";
         	++$errorCount;
    	} 
   	 return $data;
}

if (isset($_POST['Submit'])) {
		$errorCount=0;
		$id = validateInput($_POST['id'], "ID");
		$password = validateInput($_POST['pw'],"Password");

	if ($errorCount>0) {
			setcookie("id",$id, time()+3600);		
			redisplayForm($id);
	}
	else {
		if(isset($_POST['save'])) {
			setcookie("id",$id, time()+3600);			
			echo "cookie saved";?><a href='Asgn6-1.php'> Back to login</a>;
<?php		} 
		else {
			echo "no cookies";?><a href='Asgn6-1.php'> Back to login</a>;
<?php
		}
    	}
}
else {
	redisplayForm('');
}
?>
