<?php
include('../includes/connect.php');
// upload.php
// 'images' refers to your file input name attribute
if (empty($_FILES['schoolfiles'])) {
    echo json_encode(['error'=>'No files found for upload.']); 
    // or you can throw an exception 
    return; // terminate
}

// get the files posted
$images = $_FILES['schoolfiles'];
$schoolId = empty($_POST['userid']) ? '' : $_POST['userid'];
// get user id posted
//echo $userid;

// a flag to see if everything is ok
$success = null;

// file paths to store
$paths= [];

// get file names
$filenames = $images['name'];

// loop and process files
for($i=0; $i < count($filenames); $i++){
    $fName=$_FILES['schoolfiles']['name'];
     $target = "../images/SchoolLogo/"; 
 $target = $target . basename($_FILES['schoolfiles']['name']);
    if(move_uploaded_file($_FILES['schoolfiles']['tmp_name'], $target)) {
        $success = true;
        $paths[] = $target;
        $output = ['success'=>'true'];
        $sql=mysqli_query($connection,"SELECT max(DisplayOrder) as maxDisplayOrder FROM schoolpolicy WHERE SchoolId='$schoolId'");
        if(mysqli_num_rows($sql)){
while($rs=mysqli_fetch_array($sql)){
    $displayOrder = $rs['maxDisplayOrder'] + 1;    
  }
}
        $result=mysqli_query($connection,"INSERT schoolpolicy SET PolicyName='$fName',SchoolId='$schoolId',UploadDate=UTC_TIMESTAMP(),DisplayOrder='$displayOrder'")
or die(mysqli_error($connection));
    } else {
        $success = false;
        break;
    }
}
// return a json encoded response for plugin to process successfully
echo json_encode($output);
?>