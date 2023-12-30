<?php
$conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

session_start();
$ID=$_SESSION['user_id'];
$s_num=$_GET['s_num'];
$s_date=$_GET['s_date'];
$sql="SELECT * FROM `판매제품정보` WHERE 판매번호='$s_num'";
$ret=mysqli_query($conn, $sql);
// $sql1="SELECT * FROM `제품 정보` WHERE 제품이름='.$_GET[제품이름]'";
// $ret1=mysqli_query($conn, $sql1);

echo "<h1>주문상세</h1><hr>";
echo "주문날짜: ",$s_date;
echo "<table border='1'>";
echo "<tr><th>제품명</th><th>수량</th><th>가격</th></tr>";
$final=0;
while ($row=mysqli_fetch_array($ret) ) {
  $product = $row['제품이름'];
  $amount = $row['수량'];
  echo "<tr><td>&nbsp;", $product, "&nbsp;</td>";
  echo "<td>&nbsp;", $amount, "개&nbsp;</td>";

  $sql1 = "SELECT 가격 FROM `제품정보` WHERE 제품이름 = '$product'";
  $ret1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_array($ret1);
  $price = $row1['가격'];
  echo "<td>&nbsp;", number_format($price), "원&nbsp;</td></tr>";

  $final+=$price*$amount;
}
echo "</tr></table>";
echo "총 금액: ",number_format($final),"원<br><br>";

echo '<form method="get" action="주문취소목록.php">';
echo '제품명: <input type="text" name="product">&nbsp;';
echo '수량: <input type="number" min="1" max="50" name="num">&nbsp;';
echo "<input type='hidden' name='s_num' value='$s_num'>";
echo '<input type="submit" value="주문취소"></p>';
echo "</form>";
echo "<br><a href='주문목록.php'>-주문목록으로 이동</a>";
echo "<br><a href='main.php'>-메인화면으로 돌아가기</a>";

mysqli_close($conn);
?>