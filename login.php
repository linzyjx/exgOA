<?php
include_once("conn_db.php");
    header("Content-type:text/html;charset=utf-8");
    if(isset($_POST["subl"]))
    {
      $login_id=$_POST["usernamel"];
      $login_pw=$_POST["passwordl"];
      if($login_id==""||$login_pw=="")//判断是否为空
      {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."请填写正确的信息！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
        exit;
      }
//      $str="select password from register where username="."'"."$name"."'";
//      $result='111';
//      $pass='222';
        $sql = "SELECT id, name, passwd FROM user WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $login_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $pass= $row['passwd'];
//        var_dump(password_verify($login_pw,$pass));
      if(password_verify($login_pw,$pass))//判断密码与注册时密码是否一致
      {
          session_start();
          $_SESSION["user_id"]=$row['id'];
          //更新登录时间
          $time=time();
          $sql = "UPDATE user SET login_time = FROM_UNIXTIME(?) WHERE id =?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii", $time,$row['id']);
          $stmt->execute();
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."index.php"."\""."</script>";
        die();
      }else
      {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."登录失败！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
        die();
      }
    }
?>