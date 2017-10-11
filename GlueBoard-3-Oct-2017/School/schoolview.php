<?php
include('../includes/authenticate.php');
include('../includes/header.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<title>Glue Board</title>
</head>
<body>

<script>
$(document).ready(function() {
   
    $('#schoolTable').removeAttr('width').DataTable({
        columnDefs: [
            { width: 100, targets: 0}
        ],
        fixedColumns: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });
    
} );

function showAddLocation() {
    $('#addLocationInput').show();
}
      

function deleteconfirmPolicy() {
   if (confirm("Are you sure you want to delete this Policy Document?") == true) {
    return true;
} else {
   return false;
}
}
 
    function deleteconfirm() {
   if (confirm("Are you sure you want to delete this school?") == true) {
    return true;
} else {
   return false;
}
}
</script>
<?php
include('../includes/connect.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="edit"){
    print '<script type="text/javascript">toastr.success("School has been updated successfully.");</script>';
    }
    else if($_GET['Message']=="insert"){
    print '<script type="text/javascript">toastr.success("School has been added successfully.");</script>';
    }
   else if($_GET['Message']=="delete"){
    print '<script type="text/javascript">toastr.success("School has been deleted successfully.");</script>';
    }
     else if($_GET['Message']=="Policydelete"){
    print '<script type="text/javascript">toastr.success("Policy Document has been deleted successfully.");</script>';
    }
    else if($_GET['Message']=="EmergencyEmailIdUpdate"){
    print '<script type="text/javascript">toastr.success("Emergency Email Ids have been updated successfully.");</script>';
    }
    else if($_GET['Message']=="EmergencyEmailIdInsert"){
    print '<script type="text/javascript">toastr.success("Emergency Email Ids have been saved successfully.");</script>';
    }
}
     $timezone = $_SESSION["timezone"];
     $schoolId=$_SESSION["SchoolId"];
     $rolename=$_SESSION["RoleName"];
    if($rolename=="App Admin"){
$result = mysqli_query($connection,"SELECT * FROM school order by schoolid desc")
or die(mysqli_error());
    }else
    {
        $result = mysqli_query($connection,"SELECT * FROM school where schoolid='$schoolId' order by schoolid desc")
or die(mysqli_error());
    }
?>

<div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
<h5 class='panel-title checkbox'>			
    <span style=''>Schools</span>
    <div class='pull-right'>
        <?php    
  $rolename=$_SESSION["RoleName"];
        if($rolename=="App Admin"){
	echo '<a id="addSchool" href="insertschool.php" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-plus black"></span></a>';
        }
        ?>
	</div>
</h5>
</div>
<div class='panel-body'>
<table id='schoolTable' class='table table-bordered'>
    <thead>
<tr>
<th><font></font></th>
<th><font>Id</font></th>
<th><font>School Name</font></th>
<th><font>Address</font></th>
<th><font>Email</font></th>
<th><font>Logo</font></th>
<th><font>School Unique Code Name</font></th>
<th><font>Phone</font></th>
</tr>
</thead>
<tbody>
<?php    
  $rolename=$_SESSION["RoleName"];
while($row = mysqli_fetch_array( $result ))
{
if($rolename=="App Admin"){
echo "<tr>";
echo '<td><a id="deleteSchool" onClick="return deleteconfirm()" class="link" href="deleteschool.php?id=' . $row['SchoolId'] . '" ><span class="glyphicon glyphicon-remove black"></span></a>
<a id="editSchool" class="link" href="editschool.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-edit black">&nbsp;</span></a> 
<a id="uploadFiles" class="link" href="uploadfiles.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-upload black">&nbsp;</span></a> 
<a id="showFiles" class="link" href="viewdeletepolicy.php?id='.$row['SchoolId'].'&timezone='.$timezone.'" data-toggle="modal" data-target="#showPolicyModal"><span class="glyphicon glyphicon-download black">&nbsp;</span></a>
</td>'; }
    else if($rolename=="School Admin")
    {
       echo "<tr>";
echo '<td>
<a id="uploadFiles" class="link" href="uploadfiles.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-upload black">&nbsp;</span></a> 
<a id="showFiles" class="link" href="viewdeletepolicy.php?id='.$row['SchoolId'].'&timezone='.$timezone.'" data-toggle="modal" data-target="#showPolicyModal"><span class="glyphicon glyphicon-download black">&nbsp;</span></a>
<a id="addEditEmergencyEmailId" class="link" href="addEditEmergencyEmailId.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-envelope black">&nbsp;</span></a>
<a id="addEditLocation" class="link" href="addEditLocation.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-map-marker black">&nbsp;</span></a>
</td>'; 
    }
    else if($rolename=="Counsellor")
    {
       echo "<tr>";
echo '<td>
<a id="uploadFiles" class="link" href="uploadfiles.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-upload black">&nbsp;</span></a> 

<a id="uploadFiles" class="link" href="viewdeletepolicy.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-download black">&nbsp;</span></a>
</td>'; 
    }
echo '<td><font>' . $row['SchoolId'] . '</font></td>';
echo '<td><font>' . $row['SchoolName'] . '</font></td>';
echo '<td><font>' . $row['Address'] . '</font></td>';
echo '<td><font>' . $row['Email'] . '</font></td>';
echo '<td><font><img src="../images/SchoolLogo/'. $row['logoPath'] .'" width="100px" height="100px" style="border:1px solid #333333; margin-left: 30px;>"</font></td>';
echo '<td><font>' . $row['SchoolUniqueCode'] . '</font></td>';
echo '<td><font>' . $row['Phone'] . '</font></td>';
echo "</tr>";
}
?>
    </tbody>
</table></div></div>

<div class='modal fade' id='addEditSchoolModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        
      </div>
      
    </div>
</div>

<div class='modal fade' id='showPolicyModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        
      </div>
      
    </div>
</div>
</div>
    <?php
echo '<script type="text/javascript">  
     $("body").on("hidden.bs.modal", ".modal", function () {
        $(this).removeData("bs.modal");
      });

       $("#showPolicyModal").on("shown.bs.modal", function () {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
      });
      
      	$(document).on("click","#saveReorder",function(){
    	  var list = new Array();
		$("#sortable").find(".ui-sortable-handle").each(function(){
			 var id=$(this).attr("data-id");	
			 list.push(id);
		});
		var data=JSON.stringify(list);

		$.ajax({
        url: "savePolicyReorder.php",
        type: "POST",
        data: {token:"reorder",data:data},
        datatype: "json",
        success: function(message) {
			alert(message);
        }
    });
	});
</script>'; 
?>
    </body>
</html>