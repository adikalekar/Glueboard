<?php  
session_start();
 require('connect.php');
$error='';
if (isset($_POST['username']) and isset($_POST['password'])){
$username = $_POST['username'];
$password = $_POST['password'];
$hashpassword=md5($password);
$query = "SELECT * FROM users WHERE Username='$username' and Password='$hashpassword'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

$count = mysqli_num_rows($result);
if ($count>0){
	$_SESSION['username'] = $username;
    $_SESSION['authenticated'] = 'true';
header("location: welcome.php");	
}else{

$error =  "Invalid Login Credentials.";
header("Location:index.php?error=$error");
}
}
?>