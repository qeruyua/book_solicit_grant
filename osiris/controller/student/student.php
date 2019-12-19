<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2019/12/17
 * Time: 15:14
 */
include_once "../sqlhelper.php";
session_start();
date_default_timezone_set('Asia/Shanghai');
class student
{

    function paybook()
    {
        if (isset($_POST['ID'])) {
            $id = addslashes($_POST['ID']);
            $num = addslashes($_POST['num']);
            $mysqli = new sqlhelper();
            $sql = "SELECT * FROM book WHERE id = '$id'";
            $res = $mysqli->execute_dql($sql);
            if ($res) {
                $row = $res->fetch_row();
                $insert="insert into user_book values('$_SESSION[0]',row[0],row[1],row[2])";
                $res1=$mysqli->execute_dml($insert);
                if ($res1){

                    echo "<script>alert('购买成功')</script>";
                }else{
                    echo "<script>alert('购买失败');</script>";
                }
            }else{
                echo "<script>alert('没有这本书');</script>";
            }
        }
    }
}