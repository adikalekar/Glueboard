<?php
function valid($name, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Insert Records</title>
</head>
<body>
<?php

if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<form action="" method="post">
<table border="1">
<tr>
<td colspan="2"><b><font color='Red'>Insert Records </font></b></td>
</tr>
<tr>
<td width="179"><b><font color='#663300'>Name<em>*</em></font></b></td>
<td><label>
<input type="text" name="name" value="<?php echo $name; ?>" />
</label></td>
</tr>


<tr align="Right">
<td colspan="2"><label>
<input type="submit" name="submit" value="Insert Records">
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

$name = mysqli_real_escape_string($connection,$_POST['name']);


if ($name == '' )
{

$error = 'Please enter the details!';

valid($name,$error);
}
else
{

mysqli_query($connection,"INSERT incidentbehaviour SET behaviourname='$name'")
or die(mysqli_error($connection));

header("Location: behaviourview.php");
}
}
else
{
valid('','');
}
?>