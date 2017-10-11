<?php
function valid($id,$firstname , $lastname ,$username,$email ,$role ,$school , $error)
{
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Edit User</h4>
        </div>
      <div class='modal-body'>
          
			<div class="panel panel-default">				
				<div class="panel-body">
					<form action="edituser.php" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <div class="form-group">
    <div class="row">
      <label for="firstname" class="col-md-3 control-label required-field">First Name:</label>
        <div class="col-md-8">
      <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
        </div>
    </div>
   	</div>
    <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-md-3 control-label required-field">Last Name:</label>
        <div class="col-md-8">
      <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
        </div>
    </div>
   	</div>
    <div class="form-group">
    <div class="row">
      <label for="username" class="col-md-3 control-label required-field">UserName:</label>
        <div class="col-md-8">
      <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
        </div>
    </div>
   	</div>
     <div class="form-group">
    <div class="row">
      <label for="email" class="col-md-3 control-label required-field">Email:</label>
        <div class="col-md-8">
      <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
        </div>
    </div>
   	</div>
<div class="form-group">
<div class="row">
      <label for="role" class="col-md-3 control-label required-field">Role:</label>
     <div class="col-md-8">
	  <?PHP
     session_start();
     $rolename=$_SESSION['RoleName'];
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT roleid,rolename FROM roles");
if(mysqli_num_rows($sql)){
$select= '<select name="role" class="form-control">';
while($rs=mysqli_fetch_array($sql)){
     $selected = "";
    if ($rs['roleid'] == $role )
	{ 
$selected= "selected=selected";
	}
    if($rolename == "School Admin"){
    if($rs['rolename'] != "App Admin"){
              $select.='<option value="'.$rs['roleid'].'" '.$selected.'>'.$rs['rolename'].'</option>';
    }         
     }else{
              $select.='<option value="'.$rs['roleid'].'" '.$selected.'>'.$rs['rolename'].'</option>'; 
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
      <label for="school" class="col-md-3 control-label required-field">School:</label>
	  <div class="col-xs-8 col-md-8">
              <?PHP
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT schoolid,schoolname FROM school");
if(mysqli_num_rows($sql)){
$select= '<select name="school" class="form-control">';
while($rs=mysqli_fetch_array($sql)){
     $selected = "";
    if ($rs['schoolid'] == $school )
	{ 
$selected= "selected=selected";
	}
      $select.='<option value="'.$rs['schoolid'].'" '.$selected.'>'.$rs['schoolname'].'</option>';
  }
}
$select.='</select>';
echo $select;
	  ?>
    </div>
	</div>
	</div>
	<div class="row">
						<div class="col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
								 <button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Save</button>
								<a href="#" class="btn btn-primary btn-sm" id= "cancelUser" data-dismiss='modal'>Cancel</a>
							</div>
						</div>
					</div>
	</form>
				</div>
			</div>
	</div>
</div>


        </div>
<?php
}

include('../includes/connect.php');

if (isset($_POST['submit']))
{

if (is_numeric($_POST['id']))
{

$id = $_POST['id'];
$firstname = mysqli_real_escape_string($connection,$_POST['firstname']);
$lastname = mysqli_real_escape_string($connection,$_POST['lastname']);
$username = mysqli_real_escape_string($connection,$_POST['username']);
$email = mysqli_real_escape_string($connection,$_POST['email']);
$role = mysqli_real_escape_string($connection,$_POST['role']);
$school = mysqli_real_escape_string($connection,$_POST['school']);

if ($firstname == ''|| $lastname == ''||$username == ''||$email == ''||$role == ''||$school == '')
{

$error = 'ERROR: Please fill in all required fields!';


valid($id,$firstname , $lastname ,$username,$email ,$role ,$school, $error);
}
else
{
mysqli_query($connection,"UPDATE users SET FirstName='$firstname',LastName='$lastname',Username='$username',Email='$email',RoleId='$role',SchoolId='$school' where UserId=$id")
or die(mysqli_error($connection));
header("Location: userview.php?Message=edit");
///header("Location: userview.php");
}
}
else
{

echo 'Error!';
}
}
else
{
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM users WHERE userid='$id'")
or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);

if($row)
{
    $firstname  = $row['FirstName'];
    $lastname = $row['LastName']; 
    $username = $row['Username'];
    
    $email  = $row['Email'];
    $role  = $row['RoleId'];
    $school = $row['SchoolId'];

valid($id,$firstname,$lastname,$username,$email,$role,$school,'');
}
else
{
echo "No results!";
}
}
else
{
echo 'Error!';
}
}
?>