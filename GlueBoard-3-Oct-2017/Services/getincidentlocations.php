<?php
	// Include confi.php
	include_once('connect.php');

	$SchoolId = isset($_GET["SchoolId"]) ? mysqli_real_escape_string($connection,$_GET["SchoolId"]) :  "";
    $getresult = mysqli_query($connection,"SELECT sc.SchoolId FROM school sc WHERE sc.SchoolUniqueCode='$SchoolId'");
    $count = mysqli_num_rows($getresult);
	if($count>0){
        $schId="";
     while($row = mysqli_fetch_array($getresult))
    {
         $schId=$row['SchoolId'];  
    }
        
    $getresultlocation = mysqli_query($connection,"SELECT il.* FROM incidentlocations il
    where il.SchoolId='$schId' order by il.Location");
        
        $location =array();
		while($r = mysqli_fetch_array($getresultlocation)){
			extract($r);
			$location[] = array("Location" => $Location); 
		}
		$json = array("status" => 1, "location" => $location);
	}else{
		$json = array("status" => 0, "msg" => "Locations not found.");
	}
	@mysqli_close($connection);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);