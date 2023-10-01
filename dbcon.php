<?php
session_start();

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'sistema_upload';

$conn = mysqli_connect ($dbHost, $dbUser, $dbPass,$dbName);// or die ('MySQL connect failed. ' . mysql_error());
//mysqli_select_db('filemgr',mysqli_connect('localhost','root',''))or die(mysqli_error());

//$conn=new PDO('mysql:host=localhost; dbname=sistema_upload', 'root', '') or die(mysqli_error());
?>