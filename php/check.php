<?php
session_start();
$con = mysqli_connect('localhost', 'root', '0630', 'sales_management');
$name = $_POST['name'];
$num = $_POST['num'];
$user_id = $_SESSION['user_id'];

echo "<h2>장바구니에 {$name} {$num}개가 추가되었습니다.</h2>";
$sql = "INSERT INTO `장바구니` VALUES('$user_id', '$name', '$num')";

$ret = mysqli_query($con, $sql);

echo "<br> <a href='장바구니.php'>-장바구니로 이동</a>";
echo "<br> <a href='제품검색.php'>-제품검색으로 이동</a>";
echo "<br> <a href='main.php'>-메인페이지로 이동</a>";
?>