<?php
// Include confi.php
include('connect.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	
    $FirstName=$obj->{'FirstName'};
    $LastName=$obj->{'LastName'};
    $UniqueId=$obj->{'UniqueId'};
    $Email=$obj->{'Email'};
    $Address=$obj->{'Address'};


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

@mysqli_close($connection);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);