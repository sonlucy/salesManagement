<?php
  $conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

  session_start();
  $ID=$_SESSION['user_id'];
  $sql= "SELECT * FROM `판매정보` WHERE 판매원ID='$ID'";
  $ret=mysqli_query($conn, $sql);

  echo "<h1>주문목록</h1>";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>No.</th><th>주문날짜</th><th>주문상세</th>";
  echo "</tr>";
  
  $n = 1;
  while ($row=mysqli_fetch_array($ret)) {
    $s_num = $row['판매번호'];
    $s_date = $row['판매일자'];
    echo "<tr><td>&nbsp;", $n, "&nbsp;</td>";
    echo "<td>&nbsp;", $s_date, "&nbsp;</td>";
    
    echo '<form method="get" action="주문상세.php">';
    echo "<input type='hidden' name='s_num' value='$s_num'>";
    echo "<input type='hidden' name='s_date' value='$s_date'>";
    echo '<td><input type="submit" value="주문상세"</td>';
    echo "</form>";
    $n++;
  }
  
  echo "</tr></table>";
  echo "<br> <a href='main.php'>메인 화면으로 돌아가기</a>";

  mysqli_close($conn);
?>