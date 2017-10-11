<?php
include('../includes/connect.php');
function valid($firstname , $lastname ,$username,$password,$email ,$role ,$school , $error)
{
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<div class='modal-header'>
          <h4 class='modal-title'>Add User</h4>
        </div>
<div class='modal-body'>
          
			<div class="panel panel-default">				
				<div class="panel-body">
					<form action="insertuser.php" method="post">
  
    <div class="form-group">
    <div class="row">
      <label for="firstname" class="col-xs-4 col-md-3 control-label required-field">First Name:</label>
        <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required >
        </div>
    </div>
   	</div>
    <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Last Name:</label>
        <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required>
        </div>
    </div>
   	</div>
    <div class="form-group">
    <div class="row">
      <label for="username" class="col-xs-4 col-md-3 control-label required-field">UserName:</label>
        <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required onBlur="checkAvailability()"><span id="user-availability-status"></span> 
        </div>
    </div>
   	</div>
   <div class="form-group">
    <div class="row">
      <label for="password" class="col-xs-4 col-md-3 control-label required-field">Password:</label>
        <div class="col-xs-8 col-md-8">
     <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" required >
        </div>
    </div>
   	</div>
     <div class="form-group">
    <div class="row">
      <label for="email" class="col-xs-4 col-md-3 control-label required-field">Email:</label>
        <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>
    </div>
   	</div>
<div class="form-group">
<div class="row">
      <label for="role" class="col-xs-4 col-md-3 control-label required-field">Role:</label>
     <div class="col-xs-8 col-md-8">
	  <?PHP
    session_start();
     $rolename=$_SESSION['RoleName'];
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT roleid,rolename FROM roles");
    
if(mysqli_num_rows($sql)){
$select= '<select name="role" class="form-control">';    
while($rs=mysqli_fetch_array($sql)){
    if($rolename=="School Admin"){
        if($rs['rolename'] != "App Admin"){
          $select.='<option value="'.$rs['roleid'].'">'.$rs['rolename'].'</option>';  
        }
    }else{
       $select.='<option value="'.$rs['roleid'].'">'.$rs['rolename'].'</option>'; 
    }
  }
}
$select.='</select>';
echo $select;
	  ?>
	  </div>
    </div>
	</div>
<?php
if($rolename == "App Admin"){
  echo '<div class="form-group">';
}else{
   echo '<div class="form-group" style="display:none;">';   
}
?>
	<div class="row">
      <label for="school" class="col-xs-4 col-md-3 control-label required-field">School:</label>
	  <div class="col-xs-8 col-md-8">
       <?PHP
    $schoolId=$_SESSION['SchoolId'];
     $rolename=$_SESSION['RoleName'];
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT schoolid,schoolname FROM school");
if(mysqli_num_rows($sql)){
    if($rolename=="App Admin"){
        $select= '<select name="school" class="form-control">';
    }else if($rolename=="School Admin"){
    $select= '<select name="school" class="form-control" readonly>';
    }

while($rs=mysqli_fetch_array($sql)){
    if($rolename=="App Admin"){
        $select.='<option value="'.$rs['schoolid'].'">'.$rs['schoolname'].'</option>';
    }else if($rolename=="School Admin"){
        $selected = "";
    if ($rs['schoolid'] == $schoolId)
	{ 
$selected= "selected=selected";
        
	}
      $select.='<option value="'.$rs['schoolid'].'" '.$selected.'>'.$rs['schoolname'].'</option>';
    }
      
  }
}
$select.='</select>';
echo $select;
	  ?>
    </div>
	</div>
	</div>
				
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
								<button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Save</button>
								<a href="#" class="btn btn-primary btn-sm" id= "cancel" data-dismiss='modal'>Cancel</a>
							</div>
						</div>
					</div>	
	</form>
                </div>


        </div>
<?php
}
if (isset($_POST['submit']))
{
$firstname = mysqli_real_escape_string($connection,$_POST['firstname']);
$lastname = mysqli_real_escape_string($connection,$_POST['lastname']);
$username = mysqli_real_escape_string($connection,$_POST['username']);
$password = mysqli_real_escape_string($connection,$_POST['password']);
$email = mysqli_real_escape_string($connection,$_POST['email']);
$role = mysqli_real_escape_string($connection,$_POST['role']);
$school = mysqli_real_escape_string($connection,$_POST['school']);

	$hashpassword=md5($password);
mysqli_query($connection,"INSERT users SET FirstName='$firstname',LastName='$lastname',Username='$username',Password='$hashpassword',Email='$email',RoleId='$role',SchoolId='$school'")
or die(mysqli_error($connection));

 header("Location: userview.php?Message=insert");

}
else
{
valid('','','','','','','','');
}
?>
