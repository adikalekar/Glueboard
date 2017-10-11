<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>View Records</title>
</head>
<body>
<?php
include('../includes/connect.php');
include('../includes/header.php');
$result = mysqli_query($connection,"SELECT * FROM roles")
or die(mysqli_error());

echo "<div class='container'><table class='table table-bordered'>";
echo "<tr>
<th><font>Id</font></th>
<th><font>Role Name</font></th>
<th><font>Edit</font></th>
<th><font>Delete</font></th>
</tr>";

while($row = mysqli_fetch_array( $result ))
{

echo "<tr>";
echo '<td><font>' . $row['RoleId'] . '</font></td>';
echo '<td><font>' . $row['RoleName'] . '</font></td>';
echo '<td><font><a href="editrole.php?id=' . $row['RoleId'] . '">Edit</a></font></td>';
echo '<td><font><a href="deleterole.php?id=' . $row['RoleId'] . '">Delete</a></font></td>';
echo "</tr>";

}

echo "</div></table>";
?>
<p><a href="insertrole.php">Insert new record</a></p>
</body>
</html>