<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <script type="text/javascript">
    function deleteconfirm() {
   if (confirm("Are you sure you want to delete this school?") == true) {
    return true;
} else {
   return false;
}
}
    function deletealert() {
  alert("test");
}    
          
              function validate()
{
    debugger;
var extensions = new Array("jpg","jpeg","gif","png","bmp");
var image_file = document.form.pic.value;
var image_length = document.form.image_file.value.length;
var pos = image_file.lastIndexOf('.') + 1;
var ext = image_file.substring(pos, image_length);
var final_ext = ext.toLowerCase();
for (i = 0; i < extensions.length; i++)
{
    if(extensions[i] == final_ext)
    {
    return true;
    }
}
echo (" Upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
return false;
}
    
    
    </script>
<title>Glue Board</title>
</head>
<body>
<?php
    
  
include('../includes/header.html');
include('../includes/connect.php');

$result = mysqli_query($connection,"SELECT * FROM school")
or die(mysqli_error());
?>

<div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
<h5 class='panel-title checkbox'>			
    <span style=''>Schools</span>
    <div class='pull-right'>
	<a id='addSchool' href='insertschool.php' data-toggle='modal' data-target='#addEditSchoolModal'><span class='glyphicon glyphicon-plus black'></span></a>
	</div>
</h5>
</div>
<div class='panel-body'>
<table class='table table-bordered'>
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
    
<?php    
  
while($row = mysqli_fetch_array( $result ))
{

echo "<tr>";
echo '<td><a id="deleteSchool" onClick="return deleteconfirm()" class="link" href="deleteschool.php?id=' . $row['SchoolId'] . '" ><span class="glyphicon glyphicon-remove black"></span></a>
<a id="editSchool" class="link" href="editschool.php?id=' . $row['SchoolId'] . '" data-toggle="modal" data-target="#addEditSchoolModal"><span class="glyphicon glyphicon-edit black">&nbsp;</span></a> 
</td>'; 
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
</table></div></div>

<div class='modal fade' id='addEditSchoolModal' role='dialog'>
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
</script>'; 
?>
    </body>
</html>