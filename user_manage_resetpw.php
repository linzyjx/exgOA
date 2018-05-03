<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/25
 * Time: 23:04
 */
$mod_level=1;
include_once("inc.php");
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
                echo "ok";
            }else{
                echo "fail";
            }
        } else {
            echo "symbol error";
        }
    }else{
        echo "no exist id ".$_GET['id'];
    }
}else{
    echo "no set id";
}