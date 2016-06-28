<h1>Congratulations!</h1>
<?php
$user = ($_GET['user']);
$code = ($_GET['code']);

if(isset($_GET['user']) AND isset($_GET['code'])){
	$db = new PDO('mysql:host=localhost;dbname=test_users','root','student');
	$sql = "UPDATE users SET status = 'Activated' WHERE user =:user AND sha1Code=:code";	
	$stmt = $db->prepare($sql);	
	$stmt->bindParam(':user', $user, PDO::PARAM_STR);
	$stmt->bindParam(':code', $code, PDO::PARAM_STR);
	$stmt->execute();

	echo "$user, your account has been verified.";
} else {
	echo "Error, your account has not been verified or does not exist yet.";
}
?>
