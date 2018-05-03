<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/26
 * Time: 23:22
 */

include_once("inc.php");
$errcode=0b0;
@$group_choices=$_POST["group_choices"];
$get_id=$_GET["id"];
$get_phase_id=$_GET['phase'];
if($DEBUG) echo "user_id=$user_id </p>";
if($DEBUG) echo "get_id=$get_id </p>";
if(!($user_id==$get_id)) {
    $errcode+=0b1;
    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "参数错误!" . "\"" . ")" . ";" . "</script>";
    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "paiban.php?phase=$get_phase_id&errcode=$errcode" . "\"" . "</script>";
    die();
}
//校验目标期数是否可编辑
$sql="SELECT is_active FROM paiban_phase_info WHERE phase_id=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $get_phase_id);
$stmt->execute();
$phase_isactive_result = $stmt->get_result();
$phase_isactive_data=mysqli_fetch_all($phase_isactive_result,MYSQLI_NUM);
$is_phase_active=$phase_isactive_data[0][0];
if(!$is_phase_active==1) {
    $errcode+=0b10;
//    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "参数错误:该期目前不可修改." . "\"" . ")" . ";" . "</script>";
    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "paiban.php?phase=$get_phase_id&errcode=$errcode" . "\"" . "</script>";
    die();
}

//正式执行
mysqli_autocommit($conn,FALSE);
$sql="delete from paiban_info where phase_id=? and user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $get_phase_id,$get_id);
$stmt->execute();
if ($stmt->execute() === TRUE) {
    if($DEBUG) echo "删除成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    mysqli_rollback($conn);
    mysqli_autocommit($conn,TRUE);
    die();
}
//获取组信息
    $sql="SELECT user_num FROM paiban_group_info WHERE phase_id=? and group_id=?";
        $chk_num_stmt = $conn->prepare($sql);
        $sql="select count(*) as group_num from paiban_info where phase_id=? and group_id=?";
        $group_num_stmt = $conn->prepare($sql);
    //提交选单数据
    $sql="INSERT INTO paiban_info (phase_id, user_id, group_id) VALUES (?, ?, ?)";
        $commit_stmt = $conn->prepare($sql);
        if(!empty($group_choices)) {
            foreach ($group_choices as $choices_i) {
                $chk_num_stmt->bind_param("ii", $get_phase_id,$choices_i);
                $chk_num_stmt->execute();
                $chk_num_result = $chk_num_stmt->get_result();
                $chk_num_row=mysqli_fetch_assoc($chk_num_result);
                $group_num_stmt->bind_param("ii", $get_phase_id,$choices_i);
                $group_num_stmt->execute();
                $group_num_result = $group_num_stmt->get_result();
                $group_num_row=mysqli_fetch_assoc($group_num_result);
                if(!($chk_num_row['user_num']>$group_num_row['group_num'])){
                    mysqli_rollback($conn);
                    mysqli_autocommit($conn, TRUE);
                    $errcode+=0b100;
                    if($DEBUG) var_dump($chk_num_row);
                    if($DEBUG) echo "$choices_i,$get_phase_id";
//                    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."超过当前限制!"."\"".")".";"."</script>";
                    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban.php?phase=$get_phase_id&errcode=$errcode&errgroup=$choices_i"."\""."</script>";
                    die();
                }
                $commit_stmt->bind_param("iii", $get_phase_id, $get_id, $choices_i);
//                echo "$get_phase_id,$get_id,$choices_i";
                if ($commit_stmt->execute() === TRUE) {
//                    echo "新记录插入成功";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    mysqli_rollback($conn);
                    mysqli_autocommit($conn, TRUE);
                    $errcode+=0b1000;
//                    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."提交失败，请重试!"."\"".")".";"."</script>";
                    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban.php?phase=$get_phase_id&errcode=$errcode"."\""."</script>";
                    die();
                }
            }
        }
        mysqli_commit($conn);
        mysqli_autocommit($conn,TRUE);
    $errcode=0;
//    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."提交成功!"."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban.php?phase=$get_phase_id&errcode=$errcode"."\""."</script>";