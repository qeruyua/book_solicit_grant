<?php
include_once "./AES.php";
include_once "./sqlhelper.php";
session_start();
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['name'])) {
    $username = addslashes($_POST['name']);
    $password = addslashes($_POST['password']);
    $mysqli = new sqlhelper();
    $sql = "SELECT id,sno,pwd FROM user WHERE username = '$username'";
    $res = $mysqli->execute_dql($sql);

    if ($res) {
        $row = $res->fetch_row();
        if ($row[2]===encrypt($password)){
            //TODO
            $_SESSION['userid'] = $row[0];
            $_SESSION['sno'] = $row[1];
            echo "<script>alert('登陆成功');window.location.href='../resources/views/welcome.html';</script>";
        }else{
            echo "<script>alert('登陆失败');window.location.href='../resources/views/auth/login.html';</script>";
        }
    }else{
        echo "<script>alert('没有这个用户名');window.location.href='../resources/views/auth/login.html';</script>";
    }
}
?>