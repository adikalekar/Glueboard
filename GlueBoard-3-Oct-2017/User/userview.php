<?php
include('../includes/authenticate.php');
include('../includes/header.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Glue Board</title>
     <script type="text/javascript">
         function checkAvailability() {
jQuery.ajax({
url: "check_availability.php",
data:'username='+document.getElementsByName("username")[0].value,
type: "POST",
success:function(data){
    if(data=="<span class='status-not-available'>Username already exist.</span>")
        {
            document.getElementsByName("username")[0].value="";
        }
$("#user-availability-status").html(data);
},
error:function (){}
});
}
    function deleteconfirm() {
   if (confirm("Are you sure you want to delete this user?") == true) {
    return true;
} else {
   return false;
}
}
    </script>
</head>
<body>
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });
} );
</script>
<?php
include('../includes/connect.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="edit"){
    print '<script type="text/javascript">toastr.success("User has been updated successfully.");</script>';
    }
    else if($_GET['Message']=="insert"){
    print '<script type="text/javascript">toastr.success("User has been added successfully.");</script>';
    }
    else if($_GET['Message']=="delete"){
    print '<script type="text/javascript">toastr.success("User has been deleted successfully.");</script>';
    }
}
    $schoolId=$_SESSION["SchoolId"];
     $rolename=$_SESSION["RoleName"];
    if($rolename=="App Admin"){
$result = mysqli_query($connection,"SELECT u.UserId,u.FirstName,u.LastName,
u.Username,u.Email ,r.rolename as RoleId,s.schoolname as SchoolId FROM users u
INNER JOIN roles r ON r.roleid = u.roleid
INNER JOIN school s ON s.schoolid = u.schoolid order by u.UserId desc")
or die(mysqli_error($connection));
    }
    else
    {
        $result = mysqli_query($connection,"SELECT u.UserId,u.FirstName,u.LastName,
u.Username,u.Email ,r.rolename as RoleId,s.schoolname as SchoolId FROM users u
INNER JOIN roles r ON r.roleid = u.roleid
INNER JOIN school s ON s.schoolid = u.schoolid where u.SchoolId='$schoolId' order by u.UserId desc")
or die(mysqli_error($connection));
    }
?>
<div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
					<h5 class='panel-title checkbox'>						
                             <span style=''>Users</span>
						<div class='pull-right'>
                            <?php    
  $rolename=$_SESSION["RoleName"];
        if($rolename=="App Admin" || $rolename=="School Admin"){
							echo '<a id="addUser" href="insertuser.php" data-toggle="modal" data-target="#addEditUserModal"><span
								class="glyphicon glyphicon-plus black"></span></a>';
        }?>
						</div>
						</h5>
				</div>
<div class='panel-body'>
<table id='userTable' class='table table-bordered'>
    <thead>
<tr>
<th><font></font></th>
<th><font>User Id</font></th>
<th><font>First Name</font></th>
<th><font>Last Name</font></th>
<th><font>UserName</font></th>
<th><font>Email</font></th>
<th><font>Role</font></th>
<th><font>School</font></th>
</tr>
    </thead>
    <tbody>
<?php
while($row = mysqli_fetch_array( $result ))
{
$rolename=$_SESSION["RoleName"];
        if($rolename=="App Admin" || $rolename=="School Admin"){
echo "<tr><td>";
    if($_SESSION["UserId"]!=$row['UserId']){
        echo '<a id="deleteUser" onClick="return deleteconfirm()"  class="link" href="deleteuser.php?id=' . $row['UserId'] . '" ><span class="glyphicon glyphicon-remove black"></span></a>';
    }
echo '<a id="editUser" class="link" href="edituser.php?id=' . $row['UserId'] . '" data-toggle="modal" data-target="#addEditUserModal"><span class="glyphicon glyphicon-edit black">&nbsp;</span></a> 
</td>';
        }else
    {
        echo "<tr>";
echo '<td></td>';
    }
    
echo '<td><font>' . $row['UserId'] . '</font></td>';
echo '<td><font>' . $row['FirstName'] . '</font></td>';
echo '<td><font>' . $row['LastName'] . '</font></td>';
echo '<td><font>' . $row['Username'] . '</font></td>';
echo '<td><font>' . $row['Email'] . '</font></td>';
echo '<td><font>' . $row['RoleId'] . '</font></td>';
echo '<td><font>' . $row['SchoolId'] . '</font></td>';
echo "</div></tr>";

}
?>
        </tbody>
</table></div></div>

    
<div class='modal fade' id='addEditUserModal' role='dialog'>
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
