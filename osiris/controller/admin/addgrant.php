<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');
if (isset($_POST['bookid'])) {
    $bookid = addslashes($_POST['bookid']);
    $time = addslashes($_POST['time']);
    $address = addslashes($_POST['address']);
    $status= addslashes($_POST['status']);
    $mysqli = new sqlhelper();
    $sq="SELECT id FROM book where id='$bookid'";
    if($sq)
    {
        $sql = " INSERT INTO grant_book(bookid, status,address,gtanttime) VALUE ($bookid,'$status','$address','$time')";
        $res = $mysqli->execute_dml($sql);
        if ($res) {
            echo "<script>alert('添加成功');window.location.href='../../resources/views/admin/admingrant.html';</script>";
        } else {
            echo "<script>alert('添加失败');</script>";
        }
    }
    else
        {
            echo "<script>alert('添加失败');</script>";
    }

}
else{
    echo "<script>alert('添加失败');</script>";
}

?>