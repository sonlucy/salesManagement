<?php
    $con=mysqli_connect("localhost", "root", "0630", "sales_management") or die("MySQL 접속 실패");

    session_start();
    $user_sales = $_SESSION['user_sales']; // 본인매출
    $m_sales = array_sum($_SESSION['m_sales']); // 판매원매출
    $user_sales2 = $_SESSION['user_sales2']; // 본인매출_지난달
    $m_sales2 = array_sum($_SESSION['m_sales2']); // 판매원매출_지난달
    $grade = $_SESSION['user_grade']; // 본인 등급

    $sql = "SELECT * FROM 직급";
    $ret = mysqli_query($con, $sql);

    //---------------------------------------------
    while($r = mysqli_fetch_array($ret)) {
        if($r["직급"]==$grade) {
            $profit = $user_sales * $r["수익"] /100;
            $profit2 = $user_sales2 * $r["수익"] /100;
            $benefit = $m_sales * $r["보너스"] /100;
            $benefit2 = $m_sales2 * $r["보너스"] /100;
            
            $total_sales = $profit + $benefit;
            $total_sales2 = $profit2 + $benefit2;
        }
    }

    mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>수익확인</title>
</head>
<body>

<h1>수익 확인</h1><hr>

<fieldset>
<legend>이번달 수익</legend>
-본인 매출: <?php echo number_format($user_sales)?>원<br>
-판매원 매출: <?php echo number_format($m_sales)?>원<br><br>
-수익: <?php echo number_format($profit)?>원<br>
-보너스: <?php echo number_format($benefit)?>원<br>
-총수익: <?php echo number_format($total_sales)?>원<br>
</fieldset><br>

<fieldset>
<legend>지난달 수익</legend>
-본인 매출: <?php echo number_format($user_sales2)?>원<br>
-판매원 매출: <?php echo number_format($m_sales2)?>원<br><br>
-수익: <?php echo number_format($profit2)?>원<br>
-보너스: <?php echo number_format($benefit2)?>원<br>
-총수익: <?php echo number_format($total_sales2)?>원<br>
</fieldset><br>

<a href="main.php">메인 화면으로 돌아가기</a>

</body>
</html>