<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 19:08
 */
session_start();
session_destroy();
echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."已退出，请重新登录"."\"".")".";"."</script>";
echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";