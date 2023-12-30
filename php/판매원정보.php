<?php
    $con=mysqli_connect("localhost", "root", "0630", "sales_management") or die("MySQL 접속 실패");

    session_start();
    $sql = "SELECT * FROM 판매원정보 ORDER BY 가입일";
    
    $ret = mysqli_query($con, $sql);
    $count = mysqli_num_rows($ret);

    $ID = $_SESSION['user_id']; // 본인
    $w_member = $_SESSION['w_member']; // 판매원
    $d_member = $_SESSION['d_member']; // 판매원
    $m_sales = $_SESSION['m_sales']; // 이번달 판매원 매출
    $m_sales2 = $_SESSION['m_sales2']; // 지난달 판매원 매출
    $범위 = $_GET["범위"]; // whole or direct

    echo "<h1>판매원정보 검색결과</h1><hr>";
    if($범위 == "whole"){
        echo "<h3>전체판매원</h3>";
        $member = $w_member;
    } else {
        echo "<h3>직하판매원</h3>";
        $member = $d_member;
    }
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>No.</th><th>ID</th><th>이름</th><th>직급</th>";
    echo "<th>추천회원</th><th>지난달 매출</th><th>이번달 매출</th>";
    echo "</tr>";

    //--판매원 출력
    if($count == 0) {
        echo "</table>";
        echo "판매원이 없습니다.<br>";
    } else {
        $num=0;
        $index=0;
        while($r = mysqli_fetch_array($ret)) {
            foreach($member as $m) {
                if($r["ID"] == $m) {
                    $num += 1;
                    echo "<tr><td>&nbsp;",$num,"&nbsp;</td><td>&nbsp;",$r["ID"],"&nbsp;</td><td>&nbsp;",$r["이름"],"&nbsp;</td><td>&nbsp;",$r["직급"],"&nbsp;</td>";
                    echo "<td>&nbsp;",$r["추천회원ID"],"&nbsp;</td><td>&nbsp;",number_format($m_sales2[$index]),"원&nbsp;</td><td>&nbsp;",number_format($m_sales[$index]),"원&nbsp;</td></tr>";
                    $index++;
                }
            }
        }
        echo "</table>";
        echo "총 ", $num, "명 검색되었습니다.<br><br>";
    }
    echo "<a href='판매원정보.html'>이전으로 돌아가기</a><br>";
    echo "<a href='main.php'>메인 화면으로 돌아가기</a>";

    mysqli_close($con);
?>