
<?php
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];

$result = mysqli_query($connection,"DELETE FROM incidentbehaviour WHERE behaviourId=$id")
or die(mysqli_error($connection));

header("Location: behaviourview.php");
}
else

{
header("Location: behaviourview.php");
}
?>