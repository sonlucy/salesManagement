<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <title>주문취소 목록</title>
<head>
<body>
    <h1>주문취소 목록</h1>
    <?php
    $con=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');
    session_start();
    $ID=$_SESSION['user_id'];
    $s_num=$_GET['s_num'];
    $date = date('Y-m-d H:i:s', time());

    $sql= "DELETE * FROM 판매정보 WHERE 판매원ID ='$ID' and 판매번호 = '$s_num'";
    $ret = mysqli_query($con, $sql);

    $sql2= "SELECT * FROM 판매제품정보 WHERE 판매번호 = '$s_num'"; 
    $ret2 = mysqli_query($con, $sql2);
    $row=mysqli_fetch_array($ret2);

    $sql3 = "INSERT INTO 반품정보 (판매제품코드, 제품이름, 수량, 반품일자) VALUES('$row[판매제품코드]', '$row[제품이름]', '$row[수량]', '$date')";
    $ret3 = mysqli_query($con, $sql3);

    $sql4 = "SELECT * FROM 반품정보 WHERE 판매제품번호 = ALL (SELECT 판매제품번호 FROM 판매제품정보 WHERE 판매번호 = ALL (SELECT 판매번호 FROM 판매정보 WHERE ID  = $ID]";
    $ret4=mysqli_query($con, $sql4);
    if ($ret4) {
    $count=mysqli_num_rows($ret4);
    }
    else {
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
    }

    echo "<table border='5'>";
    echo "<tr>";
    echo "<th>주문취소 번호</th><th>판매제품코드</th><th>제품이름</th><th>수량</th>";
    echo "</tr>";

    while ($row2=mysqli_fetch_array($ret4)) {
     echo "<tr>";
     echo "<td>", $row2['주문취소번호'], "</td>";
     echo "<td>", $row2['판매제품코드'], "</td>";
     echo "<td>", $row2['제품이름'], "</td>";
     echo "<td>", $row2['수량'], "</td>";
     echo "<td>", $row2['반품일자'], "</td>";
     echo "</tr>";
     }

    mysqli_close($con);
    echo "</table>";
    echo "<br> <a href='main.php'>메인 화면으로 돌아가기</a>";
    ?>
</body>
</head>
</html>