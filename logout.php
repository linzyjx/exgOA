<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 19:08
 */
session_start();
session_destroy();
echo '<html>';
echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
echo "<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."已退出，跳转回登录页面"."\"".")".";"."</script>";
echo "<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
echo "</html>";