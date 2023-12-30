<?php
// 주문 버튼 누르면, 주문목록에 뜰 수 있게해야함
// 장바구니테이블 비워야함
if(isset($_POST['product'])){
session_start();
$con = mysqli_connect('localhost', 'root', '0630', 'sales_management');

// 장바구니테이블(ID,제품이름,수량), ID는 판매원ID
$ID = $_SESSION['user_id']; // 본인
$product = $_POST['product']; //제품이름
$amount = $_POST['amount']; //수량
$d=date("Y-m-d H:i:s");

echo "<h2>주문이 완료되었습니다.</h2>";

// 장바구니→판매정보
$sql = "INSERT INTO `판매정보` (판매원ID, 판매일자, 구매방법) VALUES ('$ID', '$d', '카드')";
$ret = mysqli_query($con, $sql);

$sql1 = "SELECT * FROM `판매정보` WHERE 판매원ID = '$ID' and 판매일자 = '$d'";
$ret1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($ret1);
$s_num = $row1['판매번호'];
for($i=0;$i<count($product);$i++){
    $sql2 = "INSERT INTO `판매제품정보` (`판매번호`, `제품이름`, `수량`, `창고번호`) VALUES ('$s_num','$product[$i]','$amount[$i]','1')";
    $ret2 = mysqli_query($con, $sql2);
    echo "- ",$product[$i]," ", $amount[$i],"개<br>";
}

// 장바구니 비우기
$sql3 = "DELETE FROM `장바구니` WHERE ID='$ID'";
$ret3 = mysqli_query($con, $sql3);
} else {
    echo "<h2>장바구니를 채워주세요.</h2>";
}

echo "<br><a href='main.php'>-메인페이지로 이동</a>";
?>
