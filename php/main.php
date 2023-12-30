<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $con=mysqli_connect("localhost", "root", "0630", "sales_management") or die("MySQL 접속 실패");

        $sql = "SELECT * FROM 판매원정보 ORDER BY 가입일";
        $ret = mysqli_query($con, $sql);
        $count = mysqli_num_rows($ret);

        $ID = $_SESSION['user_id'];
        $grade = $_SESSION['user_grade']; // 본인 등급
        $_SESSION['w_member'] = array(); //전체 판매원을 저장할 배열
        $_SESSION['d_member'] = array(); //직하 판매원을 저장할 배열

        if($count != 0) {
            //----< 하위 판매원 구하기 >----
            while($r = mysqli_fetch_array($ret)) {
                if ($r["해지일"]==NULL){
                    if($r["추천회원ID"]==$ID and $r["ID"]!=$ID){
                        //--<직하>-- (추천회원==본인, 본인X, 해지일X)
                        array_push($_SESSION['w_member'], $r["ID"]);
                        array_push($_SESSION['d_member'], $r["ID"]);
                    } else {
                        //--<전체>-- (추천회원==배열에 저장된 판매원, 본인X, 해지일X)
                        foreach($_SESSION['w_member'] as $m) {
                            if($r["추천회원ID"]==$m and $r["ID"]!=$m){
                                array_push($_SESSION['w_member'], $r["ID"]); // 하위 판매원을 배열에 저장
                                break;
                            }}}}}
            //----< 매출 구하기 >----
            $d = mktime(0,0,0, date("m"),1,date("Y"));
            $last_month_f = date("Y-m-01", strtotime("-1 month",$d)); // 지난달 1일
            $this_month_f = date("Y-m-01"); // 이번달 1일
            $today = date("Y-m-d"); // 오늘
            $tomorrow = date("Y-m-d", strtotime("+1 day", strtotime($today))); // 내일
            
            $_SESSION['user_sales'] = 0; // 본인매출
            $_SESSION['m_sales'] = array(); // 판매원매출
            $_SESSION['user_sales2'] = 0; // 본인매출_지난달
            $_SESSION['m_sales2'] = array(); // 판매원매출_지난달
            
            for($j=0;$j<2;$j++) {
                for($i=0;$i<=count($_SESSION['w_member']);$i++) {
                    if($i==0){ $who = $ID; }
                    else { $who = $_SESSION['w_member'][$i-1];
                        if($j==0){ array_push($_SESSION['m_sales'], 0); }
                        else{ array_push($_SESSION['m_sales2'], 0); }
                    }
                    if($j==0){ $date1 = $this_month_f; $date2 = $tomorrow; }
                    else{ $date1 = $last_month_f; $date2 = $this_month_f; }
                    
                    $sql1 = "SELECT * FROM 판매정보 WHERE 판매일자 >= '$date1' and 판매일자 <'$date2' and 판매원ID = '$who'";
                    $ret1 = mysqli_query($con, $sql1);
                    
                    while($r1 = mysqli_fetch_array($ret1)) {
                        $sales_num = $r1["판매번호"];

                        $sql2 = "SELECT * FROM 판매제품정보 WHERE 판매번호 = '$sales_num'";
                        $ret2 = mysqli_query($con, $sql2);
                        while($r2 = mysqli_fetch_array($ret2)) {
                            $product = $r2["제품이름"];
                            $amount = $r2["수량"];

                            $sql3 = "SELECT * FROM 제품정보 WHERE 제품이름 = '$product'";
                            $ret3 = mysqli_query($con, $sql3);
                            while($r3 = mysqli_fetch_array($ret3)) {
                                $price = $r3["가격"];
                                
                                if($j==0){
                                    if($i==0){ $_SESSION['user_sales'] += $amount*$price; }
                                    else { $_SESSION['m_sales'][$i-1] += $amount*$price; }
                                } else {
                                    if($i==0){ $_SESSION['user_sales2'] += $amount*$price; }
                                    else { $_SESSION['m_sales2'][$i-1] += $amount*$price; }                           
                                }
                                
                            }
                        }
                    }
                }
            }
        }        
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h2>로그인</h2>
        <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
        <form method="post" action="login_ok.php" autocomplete="off">
            <p>아이디: <input type="text" name="user_id" required></p>
            <p>비밀번호: <input type="password" name="user_pw" required></p>
            <input type="submit" value="로그인"><input type="button" value="회원가입"/> <br/>
        </form>
        <?php } else {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
            echo "<p>$user_name($user_id)님 환영합니다.";
            echo "<p><button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        ?>
        <fieldset>
                <legend>목록</legend>
                <a href="마이페이지.php">-마이페이지</a> <br> 
                <br> <a href="제품검색.php">-제품검색</a> <br>
                <br> <a href="장바구니.php">-장바구니</a> <br> 
                <br> <a href="주문목록.php">-주문목록</a> <br>
                <br> <a href="수익확인.php">-수익확인</a> <br> 
                <br> <a href="등급확인.php">-등급확인</a> <br> 
                <br> <a href="판매원정보.html">-판매원관리</a>
        </fieldset>
        <?php }?>
    </body>
</html>