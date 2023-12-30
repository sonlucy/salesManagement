<?php
$conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

session_start();
$ID = $_SESSION['user_id']; // 본인
$product_arr = array(); // 제품
$amount_arr = array(); // 가격

$sql = "SELECT * FROM 장바구니 WHERE ID = '$ID'"; // 본인 장바구니
$ret = mysqli_query($conn, $sql);

echo" <h1>장바구니</h1><hr>";
echo "<table border='1'>";
echo "<tr><th>상품이름</th><th>가격</th><th>수량</th></tr>";

$final = 0;
while ($row=mysqli_fetch_array($ret)) {
  $product = $row['제품이름'];
  array_push($product_arr, $product);
  echo "<tr><td>&nbsp;", $product, "&nbsp;</td>";

  $sql1 = "SELECT 가격 FROM `제품정보` WHERE 제품이름 = '$product'";
  $ret1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_array($ret1);
  $price = $row1['가격'];
  echo "<td>&nbsp;", number_format($price), "원&nbsp;</td>";

  $amount = $row['수량'];
  array_push($amount_arr, $amount);
  echo "<td>&nbsp;", $amount, "개&nbsp;</td></tr>";

  $final+=$price*$amount;
}

echo "</table>";
echo "최종결제금액: ",number_format($final),"원<br>";

echo "<form method='post', action='order.php'>";
for($i=0;$i<count($product_arr);$i++){
  echo "<input type='hidden' name='product[]' value='$product_arr[$i]'>";
  echo "<input type='hidden' name='amount[]' value='$amount_arr[$i]'>";
}
echo "<input type='submit' value='주문하기'>";
echo "</form>";

echo "<br><a href='main.php'>메인 화면으로 돌아가기</a>";

mysqli_close($conn);
?>