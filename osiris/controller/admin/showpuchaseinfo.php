<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');

$mysqli = new sqlhelper();
$rows=array();
$sql = "SELECT * FROM user_book order  by puchaseDate asc ";
$res = $mysqli->execute_dql($sql);
while($row = $res->fetch_array(MYSQLI_NUM))
{
    $sql2="SELECT username,classnum FROM user where sno='$row[1]'";
    $res2 = $mysqli->execute_dql($sql2);
    $row2 = $res2->fetch_array();
    $rows[]=array_merge($row,$row2);

}
echo json_encode($rows);