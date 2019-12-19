<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2019/12/17
 * Time: 15:42
 */

class admin
{
    function add_book()
    {
        echo "<script>alert('111');</script>";
        if (isset($_POST['username'])) {
            $username = addslashes($_POST['username']);
            $password = addslashes($_POST['password']);
            $sex = addslashes($_POST['sex']);
            $sno = addslashes($_POST['sno']);
            $password = encrypt($password);
            $mysqli = new sqlhelper();
            $sql = "INSERT INTO user ( username, pwd,sno, sex )
VALUES('$username','$password','$sno','$sex')";
            $res = $mysqli->execute_dml($sql);
            if ($res==1){
                //TODO
                echo "<script>alert('注册成功');window.location.href='../resources/views/welcome.html';</script>";
            }else{
                echo "<script>alert('注册失败,用户名已被占用');</script>";
            }
        }
    }
}