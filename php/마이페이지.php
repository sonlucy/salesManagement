
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>마이페이지</title>
</head>
<body>


<h1>마이페이지</h1>
<HR>

      <?php


      $conn=mysqli_connect("localhost", "root", "0630", "sales_management")or die('MySQL접속실패');

      session_start();
      $ID=$_SESSION['user_id'];
      $sql= "SELECT * FROM `판매원정보` WHERE ID='$ID'";
      $ret=mysqli_query($conn, $sql);
      if ($ret) {
        $count=mysqli_num_rows($ret);
      }
      else {
        echo "`판매원 정보`데이터 조회 실패"."<br>";
        echo "실패 원인 :".mysqli_error($conn);
        exit();
      }

      if ($row=mysqli_fetch_array($ret))
      {
        echo "이름: ".$row["이름"]."<br/> 전화번호: ".$row["전화번호"]."<br/> 이메일: ".$row["이메일"]."
        <br/> 주소: ".$row["주소"]."<br/> 계좌번호: ".$row["계좌번호"]."<br/> 가입일: ".$row["가입일"]."<br/>";
      }

      mysqli_close($conn);


      ?>



<br>
<a href="main.php">메인 화면으로 돌아가기</a>

</body>
</html>
