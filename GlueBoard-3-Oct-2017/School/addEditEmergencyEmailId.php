<?php
     
function valid($id,$fireBrigadeEmailId,$policeEmailId,$clinicHospitalEmailId,$otherEmailId,$queryType,$error)
{
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<div class='modal-header'>
          <h4 class='modal-title'>Add/Edit Emergency Email ID</h4>
</div>
<div class='modal-body'>
			<div class="panel panel-default">				
				<div class="panel-body">
<form action="addEditEmergencyEmailId.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>
<input type="hidden" name="queryType" value="<?php echo $queryType; ?>"/>
<div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Fire Brigade:</label>
        <div class="col-xs-8 col-md-8"> 
      <input type="email" class="form-control"  name="fireBrigadeEmailId" required value="<?php echo $fireBrigadeEmailId; ?>">
        </div>
     </div>           
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Police:</label>
        <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="policeEmailId" required value="<?php echo $policeEmailId; ?>">
    </div>
    </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Clinic/Hospital:</label>
            <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="clinicHospitalEmailId" required value="<?php echo $clinicHospitalEmailId; ?>">
    </div>
            </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Other:</label>
            <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="otherEmailId" required value="<?php echo $otherEmailId; ?>">
    </div>
            </div>
    </div>
    
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="singlebutton" name="submit" class="btn btn-primary btn-sm" onClick="return validate();">Save</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "cancel" data-dismiss='modal'>Cancel</a>
                            </div></div></div>
    </form>
                </div></div></div>
<?php
}
include('../includes/connect.php');

if (isset($_POST['submit']))
{
if (is_numeric($_POST['id']))
{
$id = $_POST['id'];
    $queryType = $_POST['queryType'];
    $fireBrigadeEmailId= mysqli_real_escape_string($connection,$_POST['fireBrigadeEmailId']);
    $policeEmailId=mysqli_real_escape_string($connection,$_POST['policeEmailId']);
    $clinicHospitalEmailId =mysqli_real_escape_string($connection,$_POST['clinicHospitalEmailId']);
    $otherEmailId =mysqli_real_escape_string($connection,$_POST['otherEmailId']);
 if($queryType=='Update'){
  mysqli_query($connection,"UPDATE emergencymailid SET FireBrigade='$fireBrigadeEmailId',Police='$policeEmailId',Hospital='$clinicHospitalEmailId',Other='$otherEmailId' WHERE schoolid='$id'")
or die(mysqli_error($connection));
     header("location: schoolview.php?Message=EmergencyEmailIdUpdate");
 }else{
    mysqli_query($connection,"INSERT emergencymailid SET SchoolId='$id', FireBrigade='$fireBrigadeEmailId',Police='$policeEmailId',Hospital='$clinicHospitalEmailId',Other='$otherEmailId'")
or die(mysqli_error($connection));
     header("location: schoolview.php?Message=EmergencyEmailIdInsert");
 }
}
else
{
echo 'Error!';
}
}
else
{
if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM emergencymailid WHERE schoolid='$id'")
or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);

if($row)
{
$fireBrigadeEmailId = $row['FireBrigade'];
$policeEmailId = $row['Police'];
$clinicHospitalEmailId = $row['Hospital'];
$otherEmailId = $row['Other'];
valid($id,$fireBrigadeEmailId,$policeEmailId,$clinicHospitalEmailId,$otherEmailId,'Update','');
}
else
{
valid($id,'','','','','Insert','');
}
}
else
{
echo 'Error!';
}
}
?>