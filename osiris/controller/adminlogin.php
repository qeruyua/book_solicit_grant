<?php
include_once "./AES.php";
include_once "./sqlhelper.php";
session_start();
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['name'])) {
    $username = addslashes($_POST['name']);
    $password = addslashes($_POST['password']);
    $mysqli = new sqlhelper();
    $sql = "SELECT id,adminname,pwd FROM admin WHERE adminname = '$username'";
    $res = $mysqli->execute_dql($sql);
    if ($res) {
        $row = $res->fetch_row();
        if ($row[2]===encrypt($password)){
            //TODO
            $_SESSION['userid'] = $row[0];
            $_SESSION['username'] = $row[1];
            echo "<script>alert('管理员登陆成功');window.location.href='../resources/views/admin.html';</script>";
        }else{
            echo "<script>alert('管理员登陆失败');window.location.href='../resources/views/auth/adminlogin.html';</script>";
        }
    }else{
        echo "<script>alert('没有这个管理员');window.location.href='../resources/views/auth/adminlogin.html';</script>";
    }
}
?>