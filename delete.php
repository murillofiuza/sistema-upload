<?php
extract($_REQUEST);
include('dbcon.php');

$sql=mysqli_query($conn,"select * from upload where id='$del'");
$row=mysqli_fetch_array($sql);

unlink("files/".$row['rename_file']."");

mysqli_query($conn,"delete from upload where id='$del'");



?>
<script>
window.location.href="index.php";
</script>