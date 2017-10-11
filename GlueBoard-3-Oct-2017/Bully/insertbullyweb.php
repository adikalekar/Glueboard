<?php
include('../includes/connect.php');
include('../includes/headerweb.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="done"){
    print '<script type="text/javascript">toastr.success("Counselor has been assign sucessfully.");</script>';
    }
}
function valid($schooluid){
?>
<html>
<head>
</head>
<body>    
    <div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
					<h5 class='panel-title checkbox'>						
                             <span style=''>Add Incident</span>
						</h5>
				</div>
<div class='panel-body'>
   <form method="POST" action="insertbully.php" enctype="multipart/form-data">
       <div class="form-group">
    <div class="row">
        <input type="hidden" name="schooluid" value="<?php echo $schooluid; ?>"/>
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Victims:</label>
        <div class="col-xs-8 col-md-8">
      <input  class="form-control" name="VictimName" required>
        </div>
    </div>
   	</div>
         <div class="form-group">
    <div class="row">
      <label for="Accuses" class="col-xs-4 col-md-3 control-label required-field">Accuses:</label>
        <div class="col-xs-8 col-md-8">
      <input class="form-control" name="Accuses" required>
        </div>
    </div>
   	</div>
            <div class="form-group">
    <div class="row">
      <label for="IncidentDetails" class="col-xs-4 col-md-3 control-label required-field">Incident Details:</label>
        <div class="col-xs-8 col-md-8">
      <textarea class="form-control" name="IncidentDetails" type="" required></textarea>
        </div>
                </div></div>
       
       <div class="form-group">
    <div class="row">
      <label for="Location" class="col-xs-4 col-md-3 control-label required-field">Location:</label>
        <div class="col-xs-8 col-md-8">
      <?PHP
    
	  include('../includes/connect.php');
  $schooluid=  $_GET['schoolid'];
	  $sql=mysqli_query($connection,"SELECT * FROM incidentlocations il
      Inner Join school s on s.SchoolId=il.SchoolId
      where s.SchoolUniqueCode='$schooluid'
      
      ");
if(mysqli_num_rows($sql)){
        $select= '<select name="Location" class="form-control">';
while($rs=mysqli_fetch_array($sql)){
        $select.='<option value="'.$rs['Location'].'">'.$rs['Location'].'</option>';
    }
  }
$select.='</select>';
echo $select;
	  ?>
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">IncidentDate:</label>
        <div class="col-xs-8 col-md-8">
      <input  class="form-control" type="date" id="IncidentDate" name="IncidentDate" required>
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">PicofAccuse:</label>
        <div class="col-xs-8 col-md-8">
     <input type="file" class="form-control" name="PictureofAccuse" id="PictureofAccuse" accept=".jpg,.jpeg,.png,.bmp,.gif">
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">IncidentBehaviour:</label>
        <div class="col-xs-8 col-md-8">
            <?PHP
    
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT * FROM incidentbehaviour");
if(mysqli_num_rows($sql)){
        $select= '<select name="IncidentBehaviour" class="form-control" required>';
while($rs=mysqli_fetch_array($sql)){
        $select.='<option value="'.$rs['behaviourId'].'">'.$rs['behaviourname'].'</option>';
    }
  }
$select.='</select>';
echo $select;
	  ?>
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Are You Victim:</label>
        <div class="col-xs-8 col-md-8">
       <select name="AreYouVictim" class="form-control">
    <option value="1" selected="selected">Yes</option>
    <option value="0">No</option>
      </select>
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Is Anonymous:</label>
        <div class="col-xs-8 col-md-8">
      <select name="IsAnonymous" class="form-control">
    <option value="1" selected="selected">Yes</option>
    <option value="0">No</option>
      </select>
        </div>
                </div></div>
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Your Email:</label>
        <div class="col-xs-8 col-md-8">
      <input type"email" class="form-control" name="email" required>
        </div>
                </div></div>
       <div class="row">
						<div class="col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
								 <button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Submit Incident</button>
							</div>
						</div>
					</div>
       </form>
    </div>
        </div></div>
</body>
</html>
<?php
}
include('../includes/connect.php');

$schooluid = isset($_GET['schoolid']) ? mysqli_real_escape_string($connection,$_GET['schoolid']) :  "";

   $message= isset($_GET['Message']) ? mysqli_real_escape_string($connection,$_GET['Message']) :  "";

	if(!empty($schooluid)){
		$qur = mysqli_query($connection,"select s.SchoolId from school s where s.SchoolUniqueCode='$schooluid'") or die(mysqli_error($connection));
        $count = mysqli_num_rows($qur);
        if($count>0)
        {
            valid($schooluid);
        }
        else
        {
            echo 'School not found. Please contact admnistrator.';
        }
    }
else
{
    if($message==""){
    echo "Invalid URL. Please contact admnistrator.";   
    }
    else if($message=="succ")
    {
        echo "Incident has been added successfully.";   
    }
    else if($message=="fail")
    {
       echo "Error in saving incident. Please contact admnistrator.";    
    }
}
	?>