<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/05/02
 * Time: 23:30
 */
$mod_level=3;
include_once ("inc.php");
if(!(isset($_GET['phase'])&& isset($_GET['id']))){
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."参数错误!"."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban_manage.php?"."\""."</script>";
    die();
}
$phase_id_t=$_GET['phase'];
if(isset($_GET['phase_active'])){
    $sql="UPDATE paiban_phase_info set is_active=? where phase_id=?";
    $stmt = $conn->prepare($sql);
    if($_GET['phase_active']==1){
        $t=1;
    }elseif ($_GET['phase_active']==0){
        $t=0;
    }else{
        if($DEBUG) echo "phase_active参数错误.";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban_manage.php?phase=$phase_id_t"."\""."</script>";
        die();
    }
    $stmt->bind_param("ii", $t,$phase_id_t);
    $stmt->execute();
    if($DEBUG) echo "active状态更新成功.";
}
if($DEBUG) echo "</tr>done.";
echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."paiban_manage.php?phase=$phase_id_t"."\""."</script>";