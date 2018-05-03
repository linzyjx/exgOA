<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/26
 * Time: 22:32
 */

include_once ("inc.php");
include_once('sidebar.php');
if(isset($_GET['phase'])){
    $phase_id=$_GET['phase'];
}else{
    $sql="SELECT phase_id FROM paiban_phase_info ORDER BY start_date DESC LIMIT 1";
    $result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $phase_id=$row["phase_id"];
}
//引入sql
include_once("paiban_sql.php");
?>
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">e修哥</a>
            </li>
            <li class="breadcrumb-item active">排班</li>
        </ol>
<!--        <form action="paiban_post.php?id=--><?php //echo $user_id;?><!--" method="post">-->
<!--            <div class="bd-example">-->
<!--                <div class="btn-group btn-group-toggle" data-toggle="buttons">-->
<!--                    <label class="btn btn-secondary active">-->
<!--                        <input type="checkbox" name="choices[]" value="dd" id="option3" checked="" autocomplete="off"> 经过-->
<!--                    </label>-->
<!--                    <label class="btn btn-secondary">-->
<!--                        <input type="checkbox" name="choices[]" value="dd" id="option3" autocomplete="off"> 经过-->
<!--                    </label>-->
<!--                    <input type="submit" value="Go!" />-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->

<!--        <form action="paiban_post.php?id=--><?php //echo $user_id;?><!--" method="post">-->
<!--            <div class="bd-example">-->
<!--                <div class="btn-group btn-group-toggle" data-toggle="buttons">-->
<!--                    <label class="btn btn-outline-primary active">-->
<!--                        <input type="checkbox" name="choices[]" value="aa" id="option3" checked="" autocomplete="off"> 1/2-->
<!--                    </label>-->
<!--                    <label class="btn btn-outline-primary">-->
<!--                        <input type="checkbox" name="choices[]" value="bb" id="option3" autocomplete="off"> 1/4-->
<!--                    </label>-->
<!--                </div>-->
<!--                <input class="btn btn-primary active" type="submit" value="提交">-->
<!--            </div>-->
<!--        </form>-->

        <?php if($is_phase_active==0){ ?>
        <div class="alert alert-warning" role="alert">
            本期选班已结束.
        </div>
        <?php }
        //错误代码
        if(isset($_GET['errcode'])){
            if($_GET['errcode']==0) { ?>
        <div class="alert alert-success" role="alert">
            <strong>提交成功!</strong>
        </div>
        <?php }else{
            $post_err=array(
            "1"=>"参数错误",
            "2"=>"参数错误 该期目前不可修改",
            "3"=>"有班次人数已满",
            "4"=>"数据库写入错误,请重试"
        );
        for($i=1;$i<=4;$i++){
            if(!getstatus($_GET['errcode'],$i)) continue;
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>提交失败:</strong><?php echo $post_err[$i];?>.
        </div>
        <?php }}}?>
<!--        已选状态-->
        <div class="card mb-3">
            <div class="card-body">
                当前已选 <?php echo count($usergroup_data);?> 班. 建议选择 <?php echo $this_phase_data['per_num'];?> 班.
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i>排班表</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="paiban_post.php?id=<?php echo $user_id;?>&phase=<?php echo $phase_id;?>" method="post">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <?php for($i=1;$i<=count($time_data);$i++) { ?>
                                <th><?php echo $time_data[$i]['begin_time']; ?>-<?php echo $time_data[$i]['end_time']; ?></th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //排班表输出
                        $i=0;
                        $k=0;
                        while($i<count($group_data)){
                            echo "<tr>";
                            $j=1;
                            echo "<td>".date_format_week($group_data[$i]['date']).'('.date("m-d",strtotime($group_data[$i]['date'])).')'."</td>";
                            while($j<=count($time_data)){
                                ?> <td> <?php
                                if($i<count($group_data) && $group_data[$i]['time_id']==$j){
                                    $t_group_id=$group_data[$i]['group_id'];
                                    $username_stmt->bind_param("ii", $phase_id,$t_group_id);
                                    $username_stmt->execute();
                                    $username_result = $username_stmt->get_result();

                                    //选单按钮处理
                                    $num_ex=mysqli_num_rows($username_result);
                                    $group_user_num=$group_data[$i]['user_num'];
                                    ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-primary btn-sm <?php echo @in_array($t_group_id,$usergroup_data)?'active':null; ?> <?php echo (($num_ex>=$group_user_num) &&!@in_array($t_group_id,$usergroup_data))?'disabled':null ?>">
                                            <input type="checkbox" name="group_choices[]" value="<?php echo $t_group_id; ?>" <?php echo @in_array($t_group_id,$usergroup_data)?'checked=""':null; ?> autocomplete="off">
                                            <?php
                                            echo "$num_ex/$group_user_num"?>
                                        </label>
                                    </div>
                                    <?php
                                    while($row = mysqli_fetch_assoc($username_result)) {
                                        echo $row['name'].' ';
                                    }
                                    $i++;
                                    $t_group_id=null;
                                }
                                ?> <?php
                                $j++;
                            }
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                        <input class="btn btn-primary active" type="submit" value="提交" <?php echo ($is_phase_active)?null:'disabled' ?>>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php include_once('footer.php'); ?>