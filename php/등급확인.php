<?php
    $con=mysqli_connect("localhost", "root", "0630", "sales_management") or die("MySQL 접속 실패");

    session_start();
    $w_member = $_SESSION['w_member']; //판매원
    $user_sales = $_SESSION['user_sales']; // 당월 매출

    $sql = "SELECT * FROM 직급 ORDER BY 직급 DESC";
    $ret = mysqli_query($con, $sql);

    //--익월 등급 구하기
    while($r = mysqli_fetch_array($ret)) {
        if(count($w_member)>=$r["승급기준_판매원"] and $user_sales>=$r["승급기준_매출"]) {
            $rank = $r["직급"];
        } else {
            $lake_sales = $r["승급기준_매출"]-$user_sales;
            if($lake_sales<0) {$lake_sales=0;}
            $lake_member = $r["승급기준_판매원"]-count($w_member);
            if($lake_member<0) {$lake_member=0;}
            $next_rank = $r["직급"];
            break;
        }
    }
    mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>등급확인</title>
</head>
<body>

<h1>등급 확인</h1><hr>

<table border="1">
    <tr>
        <th>&nbsp;당월 매출&nbsp;</th>
        <td>&nbsp;<?php echo number_format($user_sales)?>원&nbsp;</td>
    </tr>
    <tr>
        <th>&nbsp;판매원 수&nbsp;</th>
        <td>&nbsp;<?php echo count($w_member)?>명&nbsp;</td>
    </tr>
</table>

<br>익월 등급: <?php echo $rank?>
<?php 
    if($rank!="A"){
        echo "<br>※",$next_rank,"등급 달성 기준: ", $lake_sales, "원 추가 구매, 판매원 ", $lake_member, "명 추가 필요";
    }
?>

<br><br><a href="main.php">메인 화면으로 돌아가기</a>

</body>
</html>