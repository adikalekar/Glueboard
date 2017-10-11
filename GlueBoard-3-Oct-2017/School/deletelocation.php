
<?php
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];
$location = $_GET['location'];

$result = mysqli_query($connection,"DELETE FROM incidentlocations WHERE SchoolId=$id and Location='$location'")
or die(mysqli_error($connection));
 header("Location: schoolview.php?Message=deleteLocation");
}
else

{
header("Location: schoolview.php");
}
?>