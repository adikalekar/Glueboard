<?php
include('../includes/authenticate.php');
include('../includes/header.php');
include('../includes/connect.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<title>Glue Board</title>

</head>
<body>
<script>
$(document).ready(function() {
$('#bullyTable').DataTable( {
    fixedColumns: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
initComplete: function () {
this.api().columns(5).every( function () {
var column = this;
var select = $('<select><option value="">' + $(this.header()).html() + '</option></select>')
                .appendTo( $(column.header()).empty() )
.on( 'change', function () {
var val = $.fn.dataTable.util.escapeRegex(
$(this).val()
);

column
.search( val ? '^'+val+'$' : '', true, false )
.draw();
} );

column.data().unique().sort().each( function ( d, j ) {
select.append( '<option value="'+d+'">'+d+'</option>' )
} );
} );
}
} );
} );

</script>
<div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
<h5 class='panel-title checkbox'>			
    <span style=''>Incidents</span>
</h5>
</div>
<div class='panel-body'>
    <table id='bullyTable' class='table table-bordered'>
        <thead>
<tr>
<th><font>View</font></th>
<th><font>Victims</font></th>
<th><font>Incident Date</font></th>
<th><font>Incident Details</font></th>
<th><font>Accuses</font></th>
<th><font>Status</font></th>

</tr>
</thead>
        <tbody>
<?php
$schoolid = isset($_GET['schoolid']) ? mysqli_real_escape_string($connection,$_GET['schoolid']) :  "";
            $schoolId=$_SESSION["SchoolId"];
             $rolename=$_SESSION["RoleName"];
                            
            $queryString = "";
            //Check Role of the logged in user
            if($rolename=="School Admin"){
                $queryString .= "where b.SchoolId='$schoolId'";
            }
            else if($rolename=="Counsellor"){
                $counselorId = $_SESSION["UserId"];
                $queryString .= "where b.SchoolId='$schoolId' and b.CounselorId='$counselorId'";
            }
            
            //Check status of the incidents to be fetched
            if (isset($_GET['status']) && !empty($_GET['status']))
            {
                $status = $_GET['status'];
                if($status=="All"){
                   $queryString .= ""; 
                }else{
                    if($rolename=="App Admin"){
                        $queryString .= " where ";
                    }else{
                        $queryString .= " and ";
                    }
                    
                if($status=="New"){
                   $queryString .= "b.status='1'"; 
                }
                else if($status=="In Progress"){
                   $queryString .= "b.status='2'"; 
                }
                else if($status=="Open"){
                   $queryString .= "b.status='3'"; 
                }
                else if($status=="Closed"){
                   $queryString .= "b.status='4'"; 
                }
                else if($status=="Resolved"){
                   $queryString .= "b.status='5'"; 
                }
                }
                
            }
            
$query = 'SELECT b.BullyId,b.Victims,LEFT(b.IncidentDetails , 50) as IncidentDetails,
b.Accuses,b.Location,b.IncidentDate,b.PicofAccuse,b.AreYouVictim,b.IsAnonymous,ib.behaviourname as IncidentBehaviour,s.statusname as status
FROM bully b 
INNER JOIN incidentbehaviour ib ON ib.behaviourId = b.IncidentBehaviour
INNER JOIN status s ON s.StatusId = b.status '. $queryString;

$timezone = $_SESSION['timezone'];        
$result = mysqli_query($connection,$query) or die(mysqli_error($connection));

while($row = mysqli_fetch_array( $result ))
{
echo "<tr>";
echo '<td><font><a href="bullydetailview.php?id=' . $row['BullyId'] . '">View Detail</a></font></td>';
echo '<td><font>' . $row['Victims'] . '</font></td>';
    // create a $dt object with the UTC timezone
    $dt = new DateTime($row['IncidentDate'], new DateTimeZone('UTC'));
    // change the timezone of the object without changing it's time
    $dt->setTimezone(new DateTimeZone($timezone));
    // format the datetime
    $incidentDate = $dt->format('m-d-Y, g:i:s A');
echo '<td><font>' . $incidentDate  . '</font></td>';
echo '<td><font>' . $row['IncidentDetails'] . '</font></td>';
echo '<td><font>' . $row['Accuses'] . '</font></td>';
echo '<td>' . $row['status'] . '</td>';
echo "</tr>";
}
        ?></tbody>
    </table></div></div></div>
</body>
</html>