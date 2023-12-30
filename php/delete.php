<?php

// 장바구니테이블에서
// 해당 제품이름을 가지고 있는 열을 지우기


$conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

session_start();
$ID=$_SESSION['user_id'];


$name = $_POST['name']; //제품이름
// $sql="SELECT * FROM `장바구니` WHERE 제품이름='.$GET[제품이름]'";
$sql="DELETE * FROM `장바구니` WHERE ID='$ID' AND 제품이름='$name' ";


// $sql="DELETE FROM `장바구니` WHERE 제품이름='".$_GET[제품이름]"' ";

$ret=mysqli_query($conn, $sql);
if ($ret) {
  $count=mysqli_num_rows($ret);
  if ($count==0) {
    echo "장바구니 회원 x <br>";
  }
}
else {
  echo "장바구니 삭제 실패"."<br>";
  echo "실패 원인 :".mysqli_error($conn);
  exit();
}

// $row=mysqli_fetch_array($ret);
//
// $제품이름=$row['제품이름'];




 ?>

 <!-- <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
   </head>
   <body>


   </body>
 </html> -->
