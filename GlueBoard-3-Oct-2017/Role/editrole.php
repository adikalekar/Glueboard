<?php
function valid($id, $name, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Edit Records</title>
</head>
<body>
<?php

if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<form action="" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<table border="1">
<tr>
<td colspan="2"><b><font color='Red'>Edit Records </font></b></td>
</tr>
<tr>
<td width="179"><b><font color='#663300'>Name<em>*</em></font></b></td>
<td><label>
<input type="text" name="name" value="<?php echo $name; ?>" />
</label></td>
</tr>


<tr align="Right">
<td colspan="2"><label>
<input type="submit" name="submit" value="Edit Records">
</label></td>
</tr>
</table>
</form>
</body>
</html>
<?php
}

include('../includes/connect.php');

if (isset($_POST['submit']))
{

if (is_numeric($_POST['id']))
{

$id = $_POST['id'];
$name = mysqli_real_escape_string($connection,htmlspecialchars($_POST['name']));



if ($name == '')
{

$error = 'ERROR: Please fill in all required fields!';


valid($id, $name, $address,$city, $error);
}
else
{

mysqli_query($connection,"UPDATE roles SET rolename='$name' WHERE roleid='$id'")
or die(mysqli_error());

header("Location: roleview.php");
}
}
else
{

echo 'Error!';
}
}
else

{

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{

$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM roles WHERE roleid='$id'")
or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);

if($row)
{

$name = $row['RoleName'];
valid($id, $name,'');
}
else
{
echo "No results!";
}
}
else

{
echo 'Error!';
}
}
?>