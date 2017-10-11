<?php
include('includes/loginheader.html');
?>
<html lang = "en">
   
   <head>
      <title>GlueBoard</title>
      <script src="js/timezone.js"></script>
   </head>
	
   <body>
      
      <h2></h2> 
      <div class = "container form-signin">
         
        <?php  
session_start();
 require('includes/connect.php');
$error='';
if (isset($_POST['username']) and isset($_POST['password'])){
$username = $_POST['username'];
$password = $_POST['password'];
$hashpassword=md5($password);
$query = "SELECT u.*,r.RoleName FROM users u 
inner join roles r on r.RoleId=u.RoleId
WHERE u.Username='$username' and u.Password='$hashpassword'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);
$count = mysqli_num_rows($result);
if ($count>0){
    if($row)
    { 
        $_SESSION["UserId"]= $row['UserId'];
        $_SESSION["SchoolId"]= $row['SchoolId'];
        $_SESSION["RoleName"]= $row['RoleName'];
        $_SESSION["Name"]= $row['FirstName'] . ' ' . $row['LastName'];
    }
	$_SESSION["username"] = $username;
  
    $_SESSION['authenticated'] = 'true';
    $_SESSION['timezone'] = $_POST['timezone'];

    if($_SESSION["RoleName"]=="App Admin"){
header("location: School/schoolview.php");	
    }
    else{
    header("location: School/dashboard.php");
    }
}else{

$error =  "Invalid Login Credentials.";
}
}
?>
      </div> <!-- /container -->
      
      <div class="container-fluid" id="login-container">
	  <div class="row">
			<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4
					   col-xs-offset-2 col-sm-offset-4 col-md-offset-4 col-lg-offset-4">
	  <div class="row">
      <div class="panel panel-default" id="login-box">
						<div class="panel-heading">Login</div>
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
			<div class="panel-body" id="login-content">
            <h4 class = "form-signin-heading"><?php echo $error; ?></h4>
	    <input type="hidden" id="timezone" name="timezone"/>
			<div class="form-group">
            <input type = "text" class = "form-control"  placeholder="Username"
               name = "username"
               required autofocus>
			   </div>
			   <div class="form-group">
            <input type = "password" class = "form-control" placeholder="Password"
               name = "password" required>
			   </div>
			   <div class="form-group">
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
			   </div>
			   <div class="panel-body" id="login-content">
         </form>
		</div> 	</div> 	</div> </div> 	</div> 
        
         
      </div> 
      
   </body>
</html>