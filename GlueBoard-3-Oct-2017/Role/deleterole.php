
<?php
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
$id = $_GET['id'];

$result = mysqli_query($connection,"DELETE FROM roles WHERE roleid=$id")
or die(mysqli_error($connection));

header("Location: roleview.php");
}
else

{
header("Location: roleview.php");
}
?>