<?php
include_once "./sqlhelper.php";
include_once "./AES.php";
session_start();
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['username'])) {
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $sex = addslashes($_POST['sex']);
    $sno = addslashes($_POST['sno']);
    $classnum = addslashes($_POST['classnum']);
    $password = encrypt($password);
    $mysqli = new sqlhelper();
    $sql = "INSERT INTO user ( username, pwd,sno, sex ,classnum)
VALUES('$username','$password','$sno','$sex','$classnum')";
    $res = $mysqli->execute_dml($sql);
    if ($res==1){
        //TODO
        $sq = "SELECT id,sno FROM user WHERE sno = '$sno'";
        $re = $mysqli->execute_dql($sql);
        if ($res)
        {
            $row = $res->fetch_row();
            $_SESSION['userid'] = $row[0];
            $_SESSION['sno'] = $row[1];
        }
        echo "<script>alert('注册成功');window.location.href='../resources/views/welcome.html';</script>";
    }else{
        echo "<script>alert('注册失败,用户名已被占用');</script>";
    }
}
?>