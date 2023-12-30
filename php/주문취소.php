<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>주문취소</title>
</head>

<body>
  <h1>주문취소</h1>
  <HR>
<form action="주문취소목록.php" method="post">

<?php
  $conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

  session_start();
  $ID=$_SESSION['user_id'];
  $sql= "SELECT * FROM `판매정보` WHERE 판매원ID='$ID'";

  $ret=mysqli_query($conn, $sql);
  if ($ret) {
    $count=mysqli_num_rows($ret);
  }
  else {
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($conn);
    exit();
  }

  echo "<table border='5'>";
  echo "<tr>";
  echo "<th>주문번호</th><th>주문날짜</th><th>주문상세</th>";
  echo "</tr>";

  while ($row=mysqli_fetch_array($ret)) {
    echo "<tr>";
    echo "<td>", $row['판매번호'], "</td>";  //판매번호가 주문번호
    echo "<td>", $row['판매일자'], "</td>";
    echo "<td>", "<a href='주문상세.php'?판매번호=", $row['판매번호'], "'>주문상세</a></td>'";
    echo "</tr>";
  } 

  mysqli_close($conn);
  echo "</table>";


?>
<p>번호: <input type="text" name="order_num" size = 1>
<input type="submit" value="주문취소"></p>
<br><br> <a href="main.php">-메인페이지로 이동</a>
</form>

</body>
</html>