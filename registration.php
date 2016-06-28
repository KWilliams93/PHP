<h1>Make an Account</h1>
<?php 
function infoRequired($fieldName) {
	echo "Data entry error at \"$fieldName\".<br />";
}

function validateInput($data, $fieldName) {
	global $errorCount;
	if (empty($data)) {
		infoRequired($fieldName);
		++$errorCount;
		$retval = "";
	} else {
		$retval = trim($data);
		$retval = stripslashes($retval);
	}
	return($retval);
}

function validateEmail($data, $fieldName) {
	global $errorCount;
		$pattern = "/.+@.+\..+/";
		if (empty($data)||!preg_match($pattern, $data)) {
			echo "Please enter a valid email address</br>";
			++$errorCount;
		}
	return($data);
}
if (isset($_POST['submit'])) {
	$errorCount=0;
	$userID = validateInput($_POST['user'],
	"User");
	$userPass = validateInput($_POST['password'],
	"Password");
	$emailvalidate = validateEmail($_POST['email'],
	"Email");

    $user   = $_POST['user'];
	$password = $_POST['password'];	
	$email  = $_POST['email'];

	$sha1Code= sha1($user.time());

	$subject = "Please verify your account";
	$message = "
	<html>
	<head>
		<title>You need to verify your account before using it</title>	
	</head>
		<body>
			<p><a href='http://localhost/activation.php?user=$user&code=$sha1Code'>click here to activate</a></p>
		</body>
	</html>
	";
	$headers = "From: abc@xyz.com" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

	if ($errorCount>0) {
		echo "Please fill out all of the form in order to create an account.<br />\n";
		displayForm($user, $password, $email);
	}
	else {
		$db = new PDO('mysql:host=localhost;dbname=test_users','root','student');
		$sql = "INSERT INTO users (user, password, email, status, sha1Code) VALUES('$user', '$password', '$email', 'notActivated', '$sha1Code')";
		$result = $db->exec($sql);	
		echo "Please check your email in order to verify your account";
		mail($email, $subject, $message, $headers);
		displayForm($user, $password, $email);
	}
}
	else{
    	displayForm('','','');
	}

function displayForm($user, $password, $email){?>
<form action='registration.php?action' method="POST">

User:<input type="text" name="user" value="<?php echo $user; ?>" /><br><br>
Password: <input type="password" name="password" value="<?php echo $password; ?>" /><br><br>
Email Address:<input type="text" name="email" value="<?php echo $email; ?>" /><br><br>
<input type="submit" name="submit" value="Submit"/>  

</form>
<?php
}
?>
