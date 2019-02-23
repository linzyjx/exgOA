<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/25
 * Time: 23:04
 */
$mod_level=1;
include_once("inc.php");
echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
if(isset($_GET['id'])){
    $sql="select id from user where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $result=$stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    if((bool)$row["id"]) {
        if (isset($_GET['resetpw']) && $_GET['resetpw'] == 1) {
//            echo "resetpw:" . $row["id"];
            $sql = "UPDATE user SET resetpw = '1' WHERE id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $row['id']);
            if($stmt->execute()){
                echo "resetpw ok </br>";
            }else{
                echo "resetpw fail </br>";
            }
        }
        if (isset($_GET['defaultpw']) && $_GET['defaultpw'] == 1){
            $sql = "UPDATE user SET passwd=? WHERE id =?";
            $stmt = $conn->prepare($sql);
            $npwhash=password_hash($row['id'], PASSWORD_DEFAULT);
            $stmt->bind_param("si",$npwhash, $row['id']);
            if($stmt->execute()){
                echo "已重置为默认密码：学号 </br>";
            }else{
                echo "defaultpw fail </br>";
            }
        } else {
            echo "symbol error";
        }
    }else{
        echo "no exist id ".$_GET['id'].'</br>';
    }
}else{
    echo "no set id </br>";
}