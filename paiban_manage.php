<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/26
 * Time: 22:32
 */

$mod_level=3;
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
                e修哥
            </li>
            <li class="breadcrumb-item active">排班管理</li>
            <li class="breadcrumb-item active">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $phase_id;?>期
                    </button>
                    <div class="dropdown-menu">
                        <?php foreach ($phase_data as $row){?>
                        <a class="dropdown-item" href="?phase=<?php echo $row['phase_id'];?>"><?php echo $row['phase_id'];?>期</a>
                        <?php }?>
                    </div>
                </div>
            </li>
        </ol>
    <div class="card mb-3">
        <div class="card-body">
        <?php
        if($is_phase_active){
            ?>
                <span>正在运行</span>&ensp;&ensp;<a href="paiban_manage_post.php?<?php echo "phase=$phase_id&id=$user_id&phase_active=0"; ?>" class="btn btn-info btn-sm" role="button">截止该期</a><?php
        }else{
            ?>
            <span>已停止</span>&ensp;&ensp;<a href="paiban_manage_post.php?<?php echo "phase=$phase_id&id=$user_id&phase_active=1"; ?>" class="btn btn-info btn-sm" role="button">恢复该期</a><?php
            }
        ?>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-table"></i>排班表</div>
        <div class="card-body">
            <div class="table-responsive">
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
                            echo '<td>';
                            if($i<count($group_data) && $group_data[$i]['time_id']==$j){
//                                echo $i;
                                $ti=$group_data[$i]['group_id'];
//                                echo $ti;
                                $username_stmt->bind_param("ii", $phase_id,$ti);
                                $username_stmt->execute();
                                $username_result = $username_stmt->get_result();
                                while($row = mysqli_fetch_assoc($username_result)) {
                                    echo $row['name'].' ';
                                }
                                $i++;
                            }
                            echo '</td>';
                            $j++;
                        }
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div class="row">
        <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> 班次</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>日期</th>
                            <th>时间</th>
                            <th>人数</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($group_data as $row){ ?>
                            <tr>
                                <td><?php echo $row["group_id"];?></td>
                                <td><?php echo $row["date"];?></td>
                                <td><?php echo $time_data[$row["time_id"]]['begin_time'];?>-<?php echo $time_data[$row["time_id"]]['end_time'];?></td>
                                <td><?php echo $row["user_num"];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i>期列表</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>编号</th>
                                <th>起始日期</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($phase_data as $row) { ?>
                                <tr>
                                    <td><?php echo $row["phase_id"];?></td>
                                    <td><?php echo $row["start_date"];?></td>
                                    <td><?php echo ($row["is_active"]==1)?'运行':null;
                                    echo ($row["is_active"]==0)?'停止':null;?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>