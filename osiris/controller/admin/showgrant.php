<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');

$mysqli = new sqlhelper();
$rows=array();
$sql = "SELECT bookid,status,address,gtanttime FROM grant_book order  by gtanttime asc ";
$res = $mysqli->execute_dql($sql);
while($row = $res->fetch_array(MYSQLI_NUM))
{
    $sql2="SELECT bookname,booknum,author FROM book where id='$row[0]'";
    $res2 = $mysqli->execute_dql($sql2);
    if($res2)
    {
        $row2 = $res2->fetch_array();
        $rows[]=array_merge($row,$row2);
    }
    else
    {
        echo"<script>alert('发放失败')</script>";
    }

}
echo json_encode($rows);