
<?php
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];
$PolicyName = $_GET['PolicyName'];
$target = "../images/SchoolLogo/"; 
    $path = $target. $PolicyName;
unlink($path);
$result = mysqli_query($connection,"DELETE FROM schoolpolicy WHERE PolicyId=$id")    
or die(mysqli_error($connection));
 header("Location: schoolview.php?Message=Policydelete");
}
else

{
header("Location: schoolview.php");
}
?>