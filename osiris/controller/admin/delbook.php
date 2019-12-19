<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['id'])) {

    $id = addslashes($_POST['id']);
    $mysqli = new sqlhelper();
    $sql = "DELETE FROM `book` WHERE id='$id'";
    $res = $mysqli->execute_dql($sql);
    return "<script>window.location.href='../../resources/views/admin/adminbook.html'</script>";
}


?>