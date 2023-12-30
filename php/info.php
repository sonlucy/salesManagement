<?php
   $con=mysqli_connect("localhost", "root", "0630", "") or die("MySQL 접속 실패");
   phpinfo();
   mysqli_close($con);
?>