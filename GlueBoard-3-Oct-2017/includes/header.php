<!DOCTYPE html>
<html lang="en"> 
<head>
  <title>Glue Board</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
     <link rel="stylesheet" href="../css/toastr.min.css"> 
    <script src="../css/toastr.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/main.css">  
    <script src="../css/fileinput.js"></script>  
    <script src="../css/sortable.js" type="text/javascript"></script>
    <script src="../css/fileinput.js" type="text/javascript"></script>
    <script src="../css/fr.js" type="text/javascript"></script>
    <script src="../css/es.js" type="text/javascript"></script>
    <script src="../css/theme.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
      <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script> 
     <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
   <link href="../css/page_pricing.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../css/blue.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../css/custom.css" media="all" rel="stylesheet" type="text/css"/>
    

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>
<div class="container">
    <div class="row">
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           
<?php
        if($_SESSION["RoleName"]=="School Admin" || $_SESSION["RoleName"]=="Counsellor")
        echo '<a class="navbar-brand" href="../School/dashboard.php"><img alt="" src="../includes/GlueBoard_Logo.png"></a>';
        else if($_SESSION["RoleName"]=="App Admin")
        echo '<a class="navbar-brand" href="../School/schoolview.php"><img alt="" src="../includes/GlueBoard_Logo.png"></a>';
    ?>
    
</div>
      <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav pull-right">
      
     <?php
        if($_SESSION["RoleName"]=="School Admin" || $_SESSION["RoleName"]=="Counsellor")
        echo '<li><a href="../School/dashboard.php">Home</a></li>';
    ?>
      <li><a href="../School/schoolview.php">School</a></li>
      <li><a href="../User/userview.php">User</a></li>
	  <li><a href="../Bully/bullyview.php?status=All">Incidents</a></li>
	  <li><a href="../Student/studentview.php">Student</a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class='glyphicon glyphicon-user'></span>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../User/resetpassword.php">Change Password</a></li>
        </ul>
      </li>
	  <li><a href="../logout.php"><span class='glyphicon glyphicon-off' title="Logout"></span></a></li>
    </ul>
	 </div>
  </div>
</nav>

    </div>
    </div>
    

