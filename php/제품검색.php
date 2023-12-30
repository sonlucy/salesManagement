<html>
    <head>       
        <title>제품 검색 페이지</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>제품 검색</h1>
        <h3>
          <form method="post" action="제품상세.php">           
                <p>사용부위 :<p><input type="radio" name="사용부위" value="전체" checked> 전체
                            <input type="radio" name="사용부위" value="얼굴"> 얼굴 
                            <input type="radio" name="사용부위" value="바디"> 바디 
                            <input type="radio" name="사용부위" value="손"> 손
                            <input type="radio" name="사용부위" value="발"> 발 </p>
                            
                
                <p>가격 : <input type="text" name="min" size=10/>￦ ~ <input type="text" name="max" size=10/>￦</p>

                <input type="submit" value="검색"/>

                <?php
                session_start();
                $conn = mysqli_connect('localhost', 'root', '0630', 'sales_management');
                if(isset($_POST["사용부위"])){   
                echo "<script>window.location.replace('제품상세.php');</script>";
                exit;   
                }
?>
          </form>    
         </h2> 
         <br> <a href="main.php">-메인페이지로 이동</a>
    </body>
</html>
