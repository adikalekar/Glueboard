<?php
	// Include confi.php
	include_once('connect.php');

	$uniqueid = isset($_GET['uniqueid']) ? mysqli_real_escape_string($connection,$_GET['uniqueid']) :  "";
	if(!empty($uniqueid)){
		$qur = mysqli_query($connection,"select * from `student`
        where UniqueId='$uniqueid'");
		$result =array();
		while($r = mysqli_fetch_array($qur)){
			extract($r);
			$result[] = array("FirstName" => $FirstName, 
                              "LastName" => $LastName
			, 'Email' => $Email
                              ,'Address'=>$Address
                              ); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "Information not found.");
	}
	@mysqli_close($connection);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);