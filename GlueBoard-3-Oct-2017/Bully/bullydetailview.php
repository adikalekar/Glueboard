<?php
include('../includes/authenticate.php');
include('../includes/header.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="done"){
    print '<script type="text/javascript">toastr.success("Counselor has been assign sucessfully.");</script>';
    }
}
function valid($Id,$Victims,$IncidentDetails,$Accuses,$Location,$IncidentDate,$PicofAccuse,$IncidentBehaviour,$AreYouVictim,$IsAnonymous,$status,$CounselorId,$StudentId){
?>
<html>
<head>
<script src="../js/chatUtility.js"></script>
<style>
fieldset.for-panel {
    background-color: #fcfcfc;
	border: 1px solid #999;
	border-radius: 4px;	
	padding:15px 10px;
	background-color: #d9edf7;
    border-color: #bce8f1;
	background-color: #f9fdfd;
	margin-bottom:12px;
}
fieldset.for-panel legend {
    background-color: #fafafa;
    border: 1px solid #ddd;
    border-radius: 5px;
    color: #4381ba;
    font-size: 14px;
    font-weight: bold;
    line-height: 10px;
    margin: inherit;
    padding: 7px;
    width: auto;
	background-color: #d9edf7;
	margin-bottom: 0;
}
</style>
</head>
<body>
    
<input type="hidden" id="bullyId" name="Id" value="<?php echo $Id; ?>"/>
<!--<input type="hidden" id="counselorId" name="counselorId" value="<?php echo $CounselorId; ?>"/>
<input type="hidden" id="studentId" name="studentId" value="<?php echo $StudentId; ?>"/>-->
<input type="hidden" id="name" name="name" value="<?php echo $_SESSION["Name"]; ?>"/>
<input type="hidden" id="role" name="role" value="<?php echo $_SESSION["RoleName"]; ?>"/>
<input type="hidden" id="timeZone" name="timeZone" value="<?php echo $_SESSION["timezone"]; ?>"/>

<div class="container">
    <div class="row">
        <fieldset class="for-panel">
          <legend>Incident Information</legend>
  <form class="form-horizontal" action="" method="post">
      <input type="hidden" name="Id" value="<?php echo $Id; ?>"/>
      <div class="col-sm-4">
    <div class="form-group">
      <label class="col-sm-6 control-label">Incident Id:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $Id; ?></p>
      </div>
    </div>
      <div class="form-group">
      <label class="col-sm-6 control-label">Victims:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $Victims; ?></p>  
      </div>
    </div>
      <div class="form-group">
      <label class="col-sm-6 control-label">Accuses:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $Accuses; ?></p>
      </div>
    </div>
      <div class="form-group">
      <label class="col-sm-6 control-label">Location:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $Location; ?></p>
      </div>
    </div>
      <div class="form-group">
      <label class="col-sm-6 control-label">Incident Date:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $IncidentDate; ?></p>
      </div>
    </div>
      <div class="form-group">
      <label class="col-sm-6 control-label">Incident Behaviour:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><?php echo $IncidentBehaviour; ?></p>
      </div>
    </div>
          <div class="form-group">
      <label class="col-sm-6 control-label">Pic of Accuse:</label>
      <div class="col-sm-6">
        <p class="form-control-static"><img src="../images/SchoolLogo/<?php echo $PicofAccuse; ?>"  width="100px" height="100px" style="border:1px solid #333333; margin-left: 30px;"></p>
      </div>
    </div>
</div>
      <div class="col-sm-8">
      <div class="form-group">
      <label class="col-sm-4 control-label">Incident Details:</label>
      <div class="col-sm-8">
        <p class="form-control-static"><?php echo $IncidentDetails; ?></p>             
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Are You Victim?</label>
      <div class="col-sm-2">
        <p class="form-control-static"><?php echo $AreYouVictim; ?></p>
      </div>
        </div>
          <div class="form-group">
      <label class="col-sm-4 control-label">Is Anonymous?</label>
      <div class="col-sm-2">
        <p class="form-control-static"><?php echo $IsAnonymous; ?></p>
      </div>
    </div>
        <div class="form-group">
      <label class="col-sm-4 control-label">Status:</label>
      <div class="col-sm-4">
        <?PHP
	   include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT statusid,statusname FROM status");
if(mysqli_num_rows($sql)){
$select= '<select name="status" class="form-control">';
while($rs=mysqli_fetch_array($sql)){
	 $selected = "";
    if ($rs['statusid'] == $status )
	{ 
$selected= "selected=selected";
	}
      $select.='<option value="'.$rs['statusid'].'" '.$selected.'>'.$rs['statusname'].'</option>';
  }
}
$select.='</select>';
echo $select;
	  ?>             
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Counselor:</label>
      <div class="col-sm-4">
        <?PHP
         $schoolId=$_SESSION["SchoolId"];
     $rolename=$_SESSION["RoleName"];
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT userid,firstname FROM users where SchoolId='$schoolId'");
if(mysqli_num_rows($sql)){
    $select="";
     if($rolename=="Counsellor"){
$select= '<select disabled name="councelorId" class="form-control">';
     }
    else
    {
       $select= '<select name="councelorId" class="form-control">';
        $select.='<option  value=""></option>';
    }
while($rs=mysqli_fetch_array($sql)){
	 $selected = "";
    if ($rs['userid'] == $CounselorId )
	{ 
$selected= "selected=selected";
	}
      $select.='<option  value="'.$rs['userid'].'" '.$selected.'>'.$rs['firstname'].'</option>';
  }
}
$select.='</select>';
echo $select;
	  ?>
      </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
      </div>
      <div class="col-sm-2">
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
      </div>
  </form>
        </fieldset>
    </div>
    <!--<div class="row">
        <div class="col-xs-3">
        <a id="startChat" class="black" href="#" style="display:none;"><span class="glyphicon glyphicon-comment"></span>&nbsp;Chat</a>
        </div>
    </div>-->
</div>
<div id="messageBox" class="msg_box" style="display:none">
	<div class="msg_head"><a id="toggleNotes" href="#" style="color:white"><span class="glyphicon glyphicon-list">&nbsp;</span>Notes</a>
	<a class='pull-right' style="color:white" id="refreshNotes" href="#"><span class="glyphicon glyphicon-refresh"></span></a>
	</div>
	<div class="msg_wrap">
		<div class="msg_body">
		</div>
	<div class="msg_footer"><textarea id="newMsgBox" class="msg_input" rows="4" placeholder="Enter a note"></textarea>
<div class="row">
    <div class="col-xs-6 col-md-6 modal-footer">
        <ul class="legend">
    <li><span class="schoolAdmin"></span> School Admin</li>
    <li><span class="counsellor"></span> Counsellor</li>
    <li><span class="student"></span> Student</li>
</ul></div>
            <div class="col-xs-3 col-md-3 modal-footer">   
  <label><input id="hideNote" type="checkbox" value="">&nbsp;Hide from Student</label>
    </div>
						<div class="col-xs-3 col-md-3 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="addNote" name="submit" class="btn btn-primary btn-sm">Add Note</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "reset" data-dismiss='modal'>Reset</a>
                            </div></div></div>
        
    </div>
</div>
</div>
</body>
</html>
<?php
}
include('../includes/connect.php');
 $rolename=$_SESSION["RoleName"];
if (isset($_POST['submit']))
{

if (is_numeric($_POST['Id']))
{

$id = $_POST['Id'];
$councelorId = mysqli_real_escape_string($connection,htmlspecialchars($_POST['councelorId']));
    $status = mysqli_real_escape_string($connection,htmlspecialchars($_POST['status']));
if($rolename=="Counsellor"){
mysqli_query($connection,"UPDATE bully SET status='$status' WHERE BullyId='$id'")
or die(mysqli_error());
}else
{
  mysqli_query($connection,"UPDATE bully SET CounselorId='$councelorId',status='$status' WHERE BullyId='$id'")
or die(mysqli_error());  
}
header("Location: bullydetailview.php?id=$id&Message=done");
}
else
{
echo 'Error!';
}
}else{
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{

$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT b.BullyId,b.Victims,b.IncidentDetails,b.status,
b.Accuses,b.Location,b.IncidentDate,b.PicofAccuse,b.AreYouVictim,b.IsAnonymous,b.CounselorId ,b.StudentId, b.SchoolId ,ib.behaviourname as IncidentBehaviour
FROM bully b 
INNER JOIN incidentbehaviour ib ON ib.behaviourId = b.IncidentBehaviour
INNER JOIN status s ON s.StatusId = b.status WHERE bullyid='$id'")
or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);

if($row)
{
$timezone = $_SESSION['timezone']; 
$BullyId = $row['BullyId'];
$Victims = $row['Victims'];
	$IncidentDetails = $row['IncidentDetails'];
	$Accuses = $row['Accuses'];
	$Location = $row['Location'];

	// create a $dt object with the UTC timezone
    	$dt = new DateTime($row['IncidentDate'], new DateTimeZone('UTC'));
    	// change the timezone of the object without changing it's time
    	$dt->setTimezone(new DateTimeZone($timezone));
    	// format the datetime
    	$IncidentDate = $dt->format('m-d-Y, g:i:s A');

	$PicofAccuse = $row['PicofAccuse'];
	$IncidentBehaviour = $row['IncidentBehaviour'];
	$AreYouVictim = $row['AreYouVictim'];
	$IsAnonymous = $row['IsAnonymous'];
	$status = $row['status'];
    	$CounselorId= $row['CounselorId'];
    $StudentId= $row['StudentId'];
$SchoolId= $row['SchoolId'];
	$victim="No";
	$IsAnonymous="No";
	if($row['AreYouVictim']==1)
	{
		$victim="Yes";
	}
	if($row['IsAnonymous']==1)
	{
		$IsAnonymous="Yes";
	}
valid($BullyId,$Victims,$IncidentDetails,$Accuses,$Location,$IncidentDate,$PicofAccuse,$IncidentBehaviour,$victim,$IsAnonymous,$status,
      $CounselorId,$StudentId);}
else
{
echo "No results!";
}
}
else

{
echo 'Error!';
}}
?>