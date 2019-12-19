<?php
include_once "../sqlhelper.php";
date_default_timezone_set('Asia/Shanghai');

$mysqli = new sqlhelper();
$sql = "SELECT * FROM teacher_class";
$res = $mysqli->execute_dql($sql);
$row = $res->fetch_array(MYSQLI_NUM);
$rows=array();
$rows[]=$row;
while($row = $res->fetch_array(MYSQLI_NUM))
{
    $rows[]=$row;
}
echo json_encode($rows);