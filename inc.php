<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 18:15
 */
include_once("conn_db.php");
include_once("session_chk.php");
//header("Content-type: text/html; charset=utf-8");
header("Strict-Transport-Security: max-age=63072000; includeSubdomains; preload");
date_default_timezone_set('Asia/Shanghai');
if($user_resetpw==1){
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密码已过期，请重设密码."."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."reset_pw.php"."\""."</script>";
    die();
}
if (isset($mod_level) && $user_gid > $mod_level){
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."抱歉，您没有权限访问."."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."index.php"."\""."</script>";
    die();
}
include_once("functions.php");
$DEBUG=0;