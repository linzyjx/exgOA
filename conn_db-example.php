<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 18:14
 */
//数据库信息
$servername = MYSQL_DATABASE;
$username = MYSQL_USERNAME;
$password = MYSQL_PASSWORD;
$dbname = "exiuge";
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
mysqli_query($conn,"SET CHARACTER SET UTF8");