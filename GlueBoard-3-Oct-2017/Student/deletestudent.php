
<?php
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];

$result = mysqli_query($connection,"DELETE FROM student WHERE studentid=$id")
or die(mysqli_error($connection));

header("Location: studentview.php?Message=delete");
}
else

{
header("Location: studentview.php");
}
?>