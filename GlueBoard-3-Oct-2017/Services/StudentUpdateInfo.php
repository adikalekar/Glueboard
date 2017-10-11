<?php

// Include confi.php
include('connect.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	
	$FirstName = isset($_POST['FirstName']) ? mysqli_real_escape_string($connection,$_POST['FirstName']) : "";
	$LastName = isset($_POST['LastName']) ? mysqli_real_escape_string($connection,$_POST['LastName']) : "";
	$Email = isset($_POST['Email']) ? mysqli_real_escape_string($connection,$_POST['Email']) : "";
	$Address = isset($_POST['Address']) ? mysqli_real_escape_string($connection,$_POST['Address']) : "";
	$UniqueId = isset($_POST['UniqueId']) ? mysqli_real_escape_string($connection,$_POST['UniqueId']) : "";


//3.1.2 If the posted values are equal to the database values, then session will be created for the user.

	// Insert data into data base
	$sql = "UPDATE `student` SET `FirstName`='$FirstName',`LastName`='$LastName',`Email`='$Email',`Address`='$Address' WHERE
`UniqueId`='$UniqueId'";
	$qur = mysqli_query($connection,$sql);
	if($qur){
		$json = array("status" => 1, "msg" => "Done information updated!");
	}else{
		$json = array("status" => 0, "msg" => "Error updating information!");
	}

	
}
else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

@mysqli_close($conn);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);