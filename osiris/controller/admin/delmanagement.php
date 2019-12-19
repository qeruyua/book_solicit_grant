<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['teacher'])) {

    $tea = addslashes($_POST['teacher']);
    $cl = addslashes($_POST['cl']);
    $mysqli = new sqlhelper();
    $sql = "DELETE FROM `teacher_class` WHERE teachername='$tea'and classnum='$cl'";
    $res = $mysqli->execute_dql($sql);
    return "<script>window.location.href='../../resources/views/admin/management.html'</script>";
}


?>