<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/05/02
 * Time: 19:26
 */
//获取期信息
$sql="SELECT * FROM paiban_phase_info ORDER BY start_date DESC LIMIT 5";
$phase_result = mysqli_query($conn,$sql);
$phase_result_t=mysqli_fetch_all($phase_result,MYSQLI_ASSOC);
foreach ($phase_result_t as $usergroup_data_tmp){
    $phase_data[]=$usergroup_data_tmp;
}
//var_dump($phase_data);
//获取处理的当期信息
$sql="SELECT * FROM paiban_phase_info WHERE phase_id=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $phase_id);
$stmt->execute();
$this_phase_result = $stmt->get_result();
$this_phase_data=mysqli_fetch_all($this_phase_result,MYSQLI_ASSOC);
$this_phase_data=$this_phase_data[0];
$is_phase_active=$this_phase_data['is_active'];
//echo $is_phase_active;
//var_dump($this_phase_data);

//获取组信息
$sql="SELECT * FROM paiban_group_info WHERE phase_id=? ORDER BY group_id+0 ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $phase_id);
$stmt->execute();
$group_result = $stmt->get_result();
$group_data=mysqli_fetch_all($group_result,MYSQLI_ASSOC);
//var_dump($group_data);
//获取时间信息
$sql="SELECT time_id, time_format(begin_time,'%H:%i') as begin_time, time_format(end_time,'%H:%i') as end_time from paiban_time_info where phase_id=? ORDER BY time_id+0 ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $phase_id);
$stmt->execute();
$time_result = $stmt->get_result();
$time_data = array();
while($row = mysqli_fetch_assoc($time_result)) {
    $time_data[$row['time_id']]=array(
        'begin_time'=>$row['begin_time'],
        'end_time'=>$row['end_time']
    );
}
$time_num=count($time_data); //获取时间数
//var_dump($group_data);

//排班_人员信息预处理
$sql="SELECT name FROM user WHERE id in(SELECT user_id FROM paiban_info WHERE phase_id=? AND group_id=?)";
$username_stmt = $conn->prepare($sql);
//获取用户已选的group
$sql="select group_id from paiban_info where phase_id=? and user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $phase_id,$user_id);
$stmt->execute();
$usergroup_result = $stmt->get_result();
$usergroup_data_t=mysqli_fetch_all($usergroup_result,MYSQLI_NUM);
foreach ($usergroup_data_t as $usergroup_data_tmp){
    $usergroup_data[]=$usergroup_data_tmp[0];
}
//var_dump($usergroup_data);