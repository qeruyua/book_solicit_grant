<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['bookname'])) {
    $bookname = addslashes($_POST['bookname']);
    $booknum = addslashes($_POST['booknum']);
    $author = addslashes($_POST['author']);
    $price = addslashes($_POST['price']);
    $mysqli = new sqlhelper();
    $sql = " INSERT INTO book(bookname, booknum, author,price) VALUE ('$bookname','$booknum','$author',$price)";
    $res = $mysqli->execute_dql($sql);
    if ($res) {
        echo "<script>alert('添加成功');window.location.href='../../resources/views/admin/adminbook.html';</script>";
    } else {
        echo "<script>alert('添加失败');</script>";
    }
}
    else{
        echo "<script>alert('添加失败');</script>";
    }

?>