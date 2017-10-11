<?php
		include('../includes/connect.php');
//Connect to database
session_start();
        $userid = $_SESSION["UserId"];
        
		$old_pass=$_POST['password'];
		$new_pass=$_POST['newpassword'];
		$re_pass=$_POST['confirmnewpassword'];

		$chg_pwd=mysqli_query($connection,"select * from users where UserId='$userid'");
		$chg_pwd1=mysqli_fetch_array($chg_pwd);
		$data_pwd=$chg_pwd1['Password'];
		if($data_pwd==md5($old_pass)){
		if($new_pass==$re_pass){
            $newpass=md5($new_pass);
            if($newpass==$data_pwd){
                header("Location: resetpassword.php?Message=newold"); 
            }else{
			$update_pwd=mysqli_query($connection,"update users set password='$newpass' where UserId='$userid'");
			//echo "<script>alert('Password has been update sucessfully.'); window.location='resetpassword.php'</script>";
             header("Location: resetpassword.php?Message=succ");
            }
		}
		else{
			//echo "<script>alert('Your new and Retype Password is not match');window.location='resetpassword.php'</script>";
             header("Location: resetpassword.php?Message=errnot");
		}
		}
		else
		{
		//echo "<script>alert('Your old password is wrong');window.location='resetpassword.php'</script>";
             header("Location: resetpassword.php?Message=errold");
		}
	?>