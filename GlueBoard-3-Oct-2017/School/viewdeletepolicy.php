<?php 
function valid($id)
{
?>
<div class='modal-header'>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class='modal-title'>View School Policies</h4>
</div>
<div class='modal-body'>
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <input type="hidden" id="schoolid" value="<?php echo $id; ?>">
      <div class="row">
        <div class="col-xs-12 col-md-12">         
            <ul id="sortable">
             	  <?PHP
 $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
 $select="";
	  include('../includes/connect.php');
	  $sql=mysqli_query($connection,"SELECT * FROM schoolpolicy WHERE SchoolId='$id'  order by DisplayOrder");
if(mysqli_num_rows($sql)){
while($rs=mysqli_fetch_array($sql)){
    $logopath =$protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$rs['PolicyName'];
      echo '<li data-id="' . $rs['PolicyId'] . '"><a href="'.$logopath.'" target="_blank">'.$rs['PolicyName'].'</a> <a id="deleteSchoolPolicy" onClick="return deleteconfirmPolicy()" class="link" href="deleteschoolPolicy.php?id=' . $rs['PolicyId'] . '&PolicyName='.$rs['PolicyName'].'" ><span class="glyphicon glyphicon-remove black"></span></a></br></li>';   
  }
}
	  ?>
</ul> 
	  </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 modal-footer buttons-container">
            <div class="edit-butons">
                <button id="saveReorder" name="submit" class="btn btn-primary btn-sm" onClick="return validate();">Save</button>
                <a href="#" class="btn btn-primary btn-sm" id= "cancelPolicy" data-dismiss='modal'>Cancel</a>
            </div></div></div>
        </div>
    </form>
 </div>
<?php
}

include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
$id = $_GET['id'];
valid($id);
}
else
{
echo "No results!";
}

?>
