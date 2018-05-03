<?php
include_once("conn_db.php");
include_once("session_chk.php");
    if(isset($_POST["subl"])){
        header("Content-type:text/html;charset=utf-8");
        @$login_pw0=$_POST["password0"];
        @$login_pw1=$_POST["password1"];
        @$login_pw2=$_POST["password2"];
//        echo $_POST["password0"].$_POST["password1"].$_POST["password2"];
      if($login_pw0==""||$login_pw1==""||$login_pw2=='')//判断是否为空
      {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."请填写正确的信息！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."reset_pw.php"."\""."</script>";
        exit;
      }
      if($login_pw1!=$login_pw2){
          echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."两次新密码填写不一致."."\"".")".";"."</script>";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."reset_pw.php"."\""."</script>";
          exit;
      }
//      $str="select password from register where username="."'"."$name"."'";
//      $result='111';
//      $pass='222';
        $sql = "SELECT id, name, passwd FROM user WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $pass= $row['passwd'];
//        var_dump(password_verify($login_pw,$pass));
        if(password_verify($login_pw0,$pass)){    //判断原密码密码是否正确
            if(password_verify($login_pw1,$pass)){    //验证新密码是否为旧密码
                echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."新密码和旧密码一致"."\"".")".";"."</script>";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."reset_pw.php"."\""."</script>";
                die();
            }
          $sql = "UPDATE user SET passwd=?,resetpw=0 WHERE id =?";
          $stmt = $conn->prepare($sql);
          $npwhash=password_hash($login_pw1, PASSWORD_DEFAULT);
          $stmt->bind_param("si", $npwhash,$row['id']);
          $stmt->execute();
          echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密码修改成功"."\"".")".";"."</script>";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."index.php"."\""."</script>";
          die();
      }else
      {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."登录失败"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."reset_pw.php"."\""."</script>";
        die();
      }
    }else{ ?>
        <!DOCTYPE html>
        <html lang="zh-cn">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>e修哥 - 修改密码</title>
            <!-- Bootstrap core CSS-->
            <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom fonts for this template-->
            <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <!-- Custom styles for this template-->
            <link href="css/sb-admin.css" rel="stylesheet">
        </head>

        <body class="bg-dark">
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">修改密码</div>
                <div class="card-body">
                    <form method="post" action="reset_pw.php">
                        <div class="form-group">
                            <label for="InputPassword0">原密码</label>
                            <input class="form-control" id="InputPassword0" name="password0" type="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="InputPassword1">新密码</label>
                            <input class="form-control" id="InputPassword1" name="password1" type="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="InputPassword2">确认密码</label>
                            <input class="form-control" id="InputPassword2" name="password2" type="password" placeholder="Password">
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" value="登录" name="subl">
                    </form>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        </body>

        </html>
    <?php }
?>