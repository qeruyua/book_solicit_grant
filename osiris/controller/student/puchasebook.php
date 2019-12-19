<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
session_start();

if (isset($_POST['ID'])) {
    $id = addslashes($_POST['ID']);
    $num = addslashes($_POST['num']);
    $mysqli = new sqlhelper();
    $sql = "SELECT * FROM book WHERE id = '$id'";
    $res = $mysqli->execute_dql($sql);
    if ($res) {
        $row = $res->fetch_row();
        $sno = $_SESSION['sno'];
        $time=date('Y-m-d h:i:s');
        $total=$row[4]*$num;
        $insert="INSERT INTO user_book (usernum,bookid,bookname,number,puchaseDate,total) VALUE ('$sno',$row[0],'$row[1]',$num,'$time',$total)";
        $res1=$mysqli->execute_dml($insert);
        if ($res1){

            echo "<script>alert('购买成功');window.location.href='../../resources/views/student/booksolicit.html';</script>";
        }else{
            echo "<script>alert('购买失败');</script>";
        }
    }else{
        echo "<script>alert('没有这本书');</script>";
    }
}
?>