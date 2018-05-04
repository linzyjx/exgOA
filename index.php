<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 20:57
 */

include_once('inc.php');
include_once('sidebar.php')
?>
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    e修哥
                </li>
            </ol>
            <div class="card mb-3">
                <div class="card-body">
                    你好，<?php echo $user_name;?>.
                </div>
            </div>
        </div>

<?php
include_once('footer.php');