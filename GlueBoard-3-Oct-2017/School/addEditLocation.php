<div class='modal-header'>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class='modal-title'>Add/Edit Incident Location</h4>
</div>
<div class='modal-body'>
			<div class="panel panel-default">				
				<div class="panel-body">
<?php
include('../includes/connect.php');
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM incidentlocations where SchoolId='$id'")
or die(mysqli_error($connection));
?>

<table id='locationTable' class='table table-bordered'>
    <thead>
<tr>
<th><font></font></th>
<th><font>School Id</font></th>
<th><font>Location</font></th>
</tr>
    </thead>
    <tbody>
<?php
while($row = mysqli_fetch_array( $result ))
{
echo "<tr>";
$oldLocation = json_encode('hello');
echo '<td><a id="deleteLocation" onClick="return deletelocationconfirm()" href="deletelocation.php?id=' . $row['SchoolId'] . '&location=' . $row['Location'] . '" ><span class="glyphicon glyphicon-remove black"></span></a>
</td>';

echo '<td><font>' . $row['SchoolId'] . '</font></td>';
echo '<td><font>' . $row['Location'] . '</font></td>';
echo "</div></tr>";

}
?>
</tbody>
</table>
                    
<div class="row">
						<div class="col-xs-12 col-md-12 buttons-container">
							<div class="edit-butons">
    <button id="addLocation" name="addLocation" class="btn btn-primary btn-sm" onClick="return showAddLocation()">Add Location</button>
                            </div></div></div>
<br>

<div class="panel panel-default" id="addLocationInput" style="display:none;">				
				<div class="panel-body">
<form action="addEditLocation.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>
<input type="hidden" name="queryType" value="Insert"/>
<div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">New Location:</label>
        <div class="col-xs-8 col-md-8"> 
      <input type="text" class="form-control"  name="location" required>
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

<!--<div class="panel panel-default" id="editLocationInput" style="display:none;">				
<div class="panel-body">
<form action="addEditLocation.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>
<input type="hidden" name="queryType" value="Update"/>
<div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Existing Location:</label>
        <div class="col-xs-8 col-md-8"> 
      <input type="text" class="form-control"  name="location" required>
        </div>
     </div>           
    </div>
    
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Update</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "cancelUser" data-dismiss='modal'>Cancel</a>
                            </div></div></div>
    </form>
                </div></div>-->
                    
    </div></div></div>

<?php
}
include('../includes/connect.php');

if (isset($_POST['submit']))
{
if (is_numeric($_POST['id']))
{
$id = $_POST['id'];
    $queryType= mysqli_real_escape_string($connection,$_POST['queryType']);
$location= mysqli_real_escape_string($connection,$_POST['location']);
if($queryType=="Insert"){
mysqli_query($connection,"INSERT incidentlocations SET SchoolId='$id', Location='$location'")
or die(mysqli_error($connection));
    header("location: schoolview.php?Message=insertLocation");
}
else if($queryType=="Update"){
    $oldLocation= mysqli_real_escape_string($connection,$_POST['oldLocation']);
mysqli_query($connection,"UPDATE incidentlocations SET Location='$location' WHERE SchoolId='$id' and Location='$oldLocation'")
or die(mysqli_error($connection));
     header("location: schoolview.php?Message=editLocation");
}
 
}
else
{
echo 'Error!';
}
}
?>