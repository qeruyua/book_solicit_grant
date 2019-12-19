<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['teachername'])) {
    $teachername = addslashes($_POST['teachername']);
    $classnum = addslashes($_POST['classnum']);
    $mysqli = new sqlhelper();
    $sql = " INSERT INTO teacher_class(teachername, classnum) VALUE ('$teachername','$classnum')";
    $res = $mysqli->execute_dql($sql);
    if ($res) {
        echo "<script>alert('添加成功');window.location.href='../../resources/views/admin/management.html';</script>";
    } else {
        echo "<script>alert('添加失败');</script>";
    }
}
else{
    echo "<script>alert('添加失败');</script>";
}

?>