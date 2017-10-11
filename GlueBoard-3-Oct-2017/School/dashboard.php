<?php
include('../includes/authenticate.php');
include('../includes/header.php');

function valid($AllBully,$OpenBully,$ClosedBully,$NewBully,$InProgressBully,$ResolvedBully){
?>
<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

        var newIncidents = <?php echo $NewBully?>;
        var openIncidents = <?php echo $OpenBully?>;
        var inProgressIncidents = <?php echo $InProgressBully?>;
        var closedIncidents = <?php echo $ClosedBully?>;
        var resolvedIncidents = <?php echo $ResolvedBully?>;

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Incident Status', 'Number of tickets'],
          ['New',     newIncidents],
          ['Open',      openIncidents],
          ['In Progress',  inProgressIncidents],
          ['Closed', closedIncidents],
          ['Resolved', resolvedIncidents]
        ]);

        var options = {
          title: 'Number of tickets with status',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var selectedStatus = data.getValue(selectedItem.row, 0);
            window.location.href = '../Bully/bullyview.php?status=' + selectedStatus;
                          
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }
    </script>
</head>
<body>
    
<div class="container content">
<div class="row-fluid privacy oc-release">
<div class="row margin-bottom-40 pricing-table">
    <a href="../Bully/bullyview.php?status=All">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-blue">Total Incidents</h3>
</div>
<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $AllBully; ?>
                 </p>
				  
				</div>
</div>
</div>
    </a>
     
    <a href="../Bully/bullyview.php?status=New">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-red">New Incidents</h3>
</div>
<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $NewBully; ?>
                 </p>
				  
				</div>
</div>
</div>
    </a>
     <a href="../Bully/bullyview.php?status=In Progress">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-darkyellow"> In Progress Incidents </h3>
</div>

<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $InProgressBully; ?>
                 </p></div>
</div>
</div>
    </a>
    
    
    </div></div>
<div class="row-fluid privacy oc-release">
<div class="row margin-bottom-40 pricing-table">
    
    <a href="../Bully/bullyview.php?status=Open">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-lightyellow"> Open Incidents </h3>
</div>

<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $OpenBully; ?>
                 </p></div>
</div>
</div>
    </a>
     <a href="../Bully/bullyview.php?status=Closed">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-green"> Closed Incidents </h3>
</div>

<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $ClosedBully; ?>
                 </p></div>
</div>
</div>
    </a>
<a href="../Bully/bullyview.php?status=Resolved">
<div class="col-md-4">
<div class="pricing hover-effect oc-pricing oc-download">
<div class="pricing-head oc-pricing-head">
<h3 class="oc-darkgreen"> Resolved Incidents </h3>
</div>

<div class="pricing-footer">
<p class="text-center" style="
    font-size: 120px;
">
   <?php echo $ResolvedBully; ?>
                 </p></div>
</div>
</div>
    </a>

    </div>
    <div class="row-fluid privacy oc-release pull-right">
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
    </div></div>
</body></html>
<?php
}
include('../includes/connect.php');


$id=$_SESSION["SchoolId"];
$rolename=$_SESSION["RoleName"];


if($rolename=="School Admin"){
$result = mysqli_query($connection,"SELECT count(b.BullyId) as count, status from bully b where SchoolId='$id' Group By status")
or die(mysqli_error($connection));
}
else if($rolename=="Counsellor"){
    $counselorId = $_SESSION["UserId"];
$result = mysqli_query($connection,"SELECT count(b.BullyId) as count, status from bully b where SchoolId='$id' and b.CounselorId='$counselorId' Group By status")
or die(mysqli_error($connection));
}

$AllBully=0;
$NewBully=0;
$InProgressBully=0;
$OpenBully=0;
$ClosedBully=0;
$ResolvedBully=0;

while($row = mysqli_fetch_array( $result ))
{
if($row['status']==1)
$NewBully = $row['count'];

if($row['status']==2)
$InProgressBully = $row['count'];
    
if($row['status']==3)
$OpenBully = $row['count'];
    
if($row['status']==4)
$ClosedBully = $row['count'];
    
if($row['status']==5)
$ResolvedBully = $row['count'];

  $AllBully =   $NewBully + $InProgressBully + $OpenBully + $ClosedBully + $ResolvedBully;
}
valid($AllBully,$OpenBully,$ClosedBully,$NewBully,$InProgressBully,$ResolvedBully);

?>