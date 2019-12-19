<?php


if (isset($_POST['id'])) {
    include_once "../sqlhelper.php";
    date_default_timezone_set('Asia/Shanghai');
    echo "<script>alert('111');</script>";
    $id = addslashes($_POST['id']);
    $mysqli = new sqlhelper();
    $sql = "DELETE FROM `grant_book` WHERE bookid='$id'";
    $res = $mysqli->execute_dql($sql);
    echo"<script>window.location.href='../../resources/views/admin/management.html'</script>";
}


?>