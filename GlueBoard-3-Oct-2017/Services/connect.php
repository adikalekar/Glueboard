<?php
$connection = mysqli_connect('localhost', 'root', 'X@m@r!n');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'glueboard');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}