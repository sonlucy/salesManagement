<?php
    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $con = mysqli_connect('localhost', 'root', '0630', 'sales_management');
    $sql = "SELECT * FROM `판매원정보` where ID='$user_id' and PW='$user_pw'";
    $res = mysqli_fetch_array(mysqli_query($con,$sql));
    if($res){
        session_start();
        $_SESSION['user_id'] = $res['ID'];
        $_SESSION['user_name'] = $res['이름'];
        $_SESSION['user_grade'] = $res['직급'];
        echo "<script>alert('로그인에 성공했습니다!');";
        echo "window.location.replace('main.php');</script>";
        exit;
    }
    else{
       echo "<script>alert('아이디 혹은 비밀번호가 잘못되었습니다.');";
       echo "window.location.replace('main.php');</script>";
    }
?>
