<?php
include('../includes/connect.php');
function valid($firstname, $lastname,$schoolid ,$email ,$address,$uniqueid, $error)
{
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<div class='modal-header'>
          <h4 class='modal-title'>Add Student</h4>
</div>
<div class='modal-body'>
			<div class="panel panel-default">				
				<div class="panel-body">
<form action="insertstudent.php" method="post">
    <div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">First Name:</label>
        <div class="col-xs-8 col-md-8"> 
      <input type="text" class="form-control"  name="firstname" required value="<?php echo $firstname; ?>">
        </div>
     </div>           
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Last Name:</label>
        <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="lastname"required value="<?php echo $lastname; ?>">
    </div>
    </div>
    </div>
    <div class="form-group">
	<div class="row">
      <label for="school" class="col-xs-4 col-md-3 control-label required-field">School:</label>
	  <div class="col-xs-8 col-md-8">
       <?PHP
	include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT schoolid,schoolname FROM school");
if(mysqli_num_rows($sql)){
$select= '<select name="schoolId" class="form-control">';
while($rs=mysqli_fetch_array($sql)){
      $select.='<option value="'.$rs['schoolid'].'">'.$rs['schoolname'].'</option>';
  }
}
$select.='</select>';
echo $select;
	  ?>
    </div>
	</div>
	</div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Email:</label>
            <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="email" required value="<?php echo $email; ?>">
    </div>
            </div>
    </div>
	    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Address:</label>
            <div class="col-xs-8 col-md-8">
      <textarea class="form-control" rows="3" name="address"required value="<?php echo $address; ?>"></textarea>
    </div>
            </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Unique Id:</label>
            <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="uniqueid" required value="<?php echo $uniqueid; ?>">
    </div>
            </div>
    </div>
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "cancelUser" data-dismiss='modal'>Cancel</a>
                            </div></div></div>
</form>
</div></div>                   
</div>

<?php
}

if (isset($_POST['submit']))
{
$firstname= mysqli_real_escape_string($connection,$_POST['firstname']);
    $lastname=mysqli_real_escape_string($connection,$_POST['lastname']);
    $schoolid =mysqli_real_escape_string($connection,$_POST['schoolId']);
    $email =mysqli_real_escape_string($connection,$_POST['email']);
    $address=mysqli_real_escape_string($connection,$_POST['address']);
    $uniqueid=mysqli_real_escape_string($connection,$_POST['uniqueid']);


mysqli_query($connection,"INSERT student SET FirstName='$firstname',LastName='$lastname',SchoolId='$schoolid',Email='$email',Address='$address',UniqueId='$uniqueid'")
or die(mysqli_error($connection));

 header("Location: studentview.php?Message=insert");

}
else
{
valid('','','','','','','');
}
?>