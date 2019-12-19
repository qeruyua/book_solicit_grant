<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['id'])) {

    $id = addslashes($_POST['id']);
    $mysqli = new sqlhelper();
    $sql = "DELETE FROM `user_book` WHERE id='$id'";
    $res = $mysqli->execute_dql($sql);
}


?>