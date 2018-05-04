<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/20
 * Time: 00:15
 */
$mod_level=1;
include_once('inc.php');
$sql = "Select id, name, gid,resetpw, UNIX_TIMESTAMP(login_time) from user";
$stmt = $conn->prepare($sql);
//$stmt->bind_param("s", $test_id);
$stmt->execute();
$result = $stmt->get_result();
$group_name=array("超级管理员","用户管理员","2","版块管理员","4","用户");
$resetpw_name=array("否","是");
include_once('sidebar.php');
?>
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                e修哥
            </li>
            <li class="breadcrumb-item active">用户管理</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> 用户列表</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>姓名</th>
                            <th>角色</th>
                            <th>重设密码</th>
                            <th>最后登录</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>编号</th>
                            <th>姓名</th>
                            <th>角色</th>
                            <th>重设密码</th>
                            <th>最后登录</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                                <td><?php echo $row["id"];?></td>
                                <td><?php echo $row["name"];?></td>
                                <td><?php echo $group_name[$row["gid"]];?></td>
                                <td><?php echo $resetpw_name[$row["resetpw"]];?></td>
                                <td><?php echo date("Y-m-d H:i:s",$row["UNIX_TIMESTAMP(login_time)"]);?></td>
                            <td>
                                <!-- Example split danger button -->
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm" type="button">111</button>
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="user_manage_resetpw.php?id=<?php echo $row["id"];?>&resetpw=1">登录后修改密码</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
include_once('footer.php');
?>

