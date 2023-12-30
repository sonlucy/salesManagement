<html>
<head>       
<title>제품 검색 결과 페이지</title>
<meta charset="utf-8">
</head>
<body>

<h1>제품 검색 결과</h1>
<form method="post" action="check.php">
<TABLE border = 1>
<TR>
<TH>제품 이름</TH><TH>사용부위</TH><TH>가격</TH><TH>생산공장넘버</TH>
</TR>
    <?php
    session_start();
    $con = mysqli_connect("localhost", "root", "0630", "sales_management");
    $keyname=$_POST["사용부위"];
    $min=$_POST["min"];
    $max=$_POST["max"];
    if($max==""){
        $max=1000000;
    }
    
    if($keyname == "얼굴"){
        $sql = "SELECT * FROM 제품정보 WHERE 사용부위 = '얼굴' and 가격 > '$min' and 가격 < '$max'";
    }
    elseif($keyname == "바디"){
        $sql = "SELECT * FROM 제품정보 WHERE 사용부위 = '바디' and 가격 > '$min' and 가격 < '$max'";
    }
    elseif($keyname == "손"){
        $sql = "SELECT * FROM 제품정보 WHERE 사용부위 = '손' and 가격 > '$min' and 가격 < '$max'";
    }
    elseif($keyname == "발"){
        $sql = "SELECT * FROM 제품정보 WHERE 사용부위 = '발' and 가격 > '$min' and 가격 < '$max'";
    }
    elseif($keyname == "전체"){
        $sql = "SELECT * FROM 제품정보 WHERE 가격 > '$min' and 가격 < '$max'";
    }           

    $ret = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($ret)){
    echo "<TR>";
    echo "<TD>", $row['제품이름'], "</TD>";
    echo "<TD>", $row['사용부위'], "</TD>";
    echo "<TD>", $row['가격'], "</TD>";
    echo "<TD>", $row['생산공장번호'], "</TD>";    
    echo "</TR>";
    }
    echo "</TABLE>";  
    ?>
<p>제품명: <input type="text" name="name"> 
수량: <input type="number" min="1" max="50" name="num">
<input type="submit" value="장바구니 담기"></p>
</form>

<br> <a href="제품검색.php">-제품검색으로 이동</a>
<br> <a href="main.php">-메인페이지로 이동</a>

</body>
</html>