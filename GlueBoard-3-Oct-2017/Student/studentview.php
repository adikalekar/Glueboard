<?php
include('../includes/authenticate.php');
include('../includes/header.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Glue Board</title>
     <script type="text/javascript">
    function deleteconfirm() {
   if(confirm("Are you sure you want to delete this student?") == true) {
    return true;
           } 
        else {
   return false;
}
}
    </script>
</head>
<body>    
<script>
$(document).ready(function() {
    $('#studentTable').removeAttr('width').DataTable( {
        columnDefs: [
            { width: 35, targets: 0}
        ],
        fixedColumns: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
} );
</script>
<?php
include('../includes/connect.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="edit"){
    print '<script type="text/javascript">toastr.success("Student has been updated successfully.");</script>';
    }
    else if($_GET['Message']=="insert"){
    print '<script type="text/javascript">toastr.success("Student has been added successfully.");</script>';
    }
    else if($_GET['Message']=="delete"){
    print '<script type="text/javascript">toastr.success("Student has been deleted successfully.");</script>';
    }
}
    $schoolId=$_SESSION["SchoolId"];
     $rolename=$_SESSION["RoleName"];
    if($rolename=="School Admin"){
$result = mysqli_query($connection,"SELECT s.*, sc.schoolname FROM student s
INNER JOIN school sc ON sc.schoolid = s.schoolid where s.SchoolId='$schoolId' order by s.StudentId desc")
or die(mysqli_error($connection));}
    else if($rolename=="App Admin")
    {
       $result = mysqli_query($connection,"SELECT s.*, sc.schoolname FROM student s
INNER JOIN school sc ON sc.schoolid = s.schoolid order by s.StudentId desc")
or die(mysqli_error($connection)); 
    }
?>
<div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
<h5 class='panel-title checkbox'>			
    <span style=''>Students</span>
</h5>
</div>
<div class='panel-body'><table id='studentTable' class='table table-bordered'>
    <thead>
<tr>
<th><font></font></th>
<th><font>Student Id</font></th>
<th><font>First Name</font></th>
<th><font>Last Name</font></th>
<th><font>Email</font></th>
<th><font>Address</font></th>
<th><font>School</font></th>
<th><font>UniqueId</font></th>
</tr>
</thead>
    <tbody>
<?php
while($row = mysqli_fetch_array( $result ))
{
$rolename=$_SESSION["RoleName"];
        if($rolename=="School Admin"){
echo "<tr>";
echo '<td><a id="deleteStudent" onClick="return deleteconfirm()" class="link" href="deletestudent.php?id=' . $row['StudentId'] . '" ><span class="glyphicon glyphicon-remove black"></span></a>
<a id="editUser" class="link" href="editstudent.php?id=' . $row['StudentId'] . '" data-toggle="modal" data-target="#addEditStudentModal"><span class="glyphicon glyphicon-edit black">&nbsp;</span></a> 
</td>';
        }
    else
    {
        echo "<tr>";
echo '<td></td>';
    }
echo '<td><font>' . $row['StudentId'] . '</font></td>';
echo '<td><font>' . $row['FirstName'] . '</font></td>';
echo '<td><font>' . $row['LastName'] . '</font></td>';
echo '<td><font>' . $row['Email'] . '</font></td>';
echo '<td><font>' . $row['Address'] . '</font></td>';
echo '<td><font>' . $row['schoolname'] . '</font></td>';
echo '<td><font>' . $row['UniqueId'] . '</font></td>';
echo "</tr>";

}
?></tbody>
</table></div></div>
<div class='modal fade' id='addEditStudentModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        
      </div>
      
    </div>
  </div></div>
<?php
echo '<script type="text/javascript">  
     $("body").on("hidden.bs.modal", ".modal", function () {
        $(this).removeData("bs.modal");
      });
</script>'; 
?>
</body>
</html>