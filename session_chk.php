<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 18:46
 */
include_once("conn_db.php");
session_start();
header("Strict-Transport-Security: max-age=63072000; includeSubdomains; preload");
if (isset($_SESSION["user_id"])){
    $sql = "SELECT id, name, gid, resetpw FROM user WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $user_name= $row['name'];
    $user_gid= $row['gid'];
    $user_id= $row['id'];
    $user_resetpw= $row['resetpw'];
//    var_dump($row);
    if(empty($user_name)){
        echo '<html>';
        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
        header("Strict-Transport-Security: max-age=63072000; includeSubdomains; preload");
        echo"<script charset=\"UTF-8\" type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."身份异常!"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
        echo "</html>";
        exit();
    }
}else
{
    echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
    echo "<script charset=\"UTF-8\" type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."您未登录，·请先登录!"."\"".")".";"."</script>";
    echo "<script charset=\"UTF-8\" type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
    echo "</html>";
    exit();
}
