<?php 
include('../includes/connect.php');

if(isset($_POST['token']))
{
	$data=json_decode($_POST['data']);
	$order=1;
	foreach($data as $key=>$id)
	{
        mysqli_query($connection,"UPDATE schoolpolicy SET DisplayOrder=".$order." WHERE PolicyId=".$id) or die(mysqli_error()); 
		$order++;
	}	
}
?>
