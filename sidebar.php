<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/04/19
 * Time: 20:55
 */
include_once('header.php');
?>

<!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">e修哥</a>
    <button class="navbar-toggler navbar-toggller-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="仪表盘">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">仪表盘</span>
          </a>
        </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="排班">
          <a class="nav-link" href="paiban.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">排班</span>
          </a>
        </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="账号设置" data-target="#myModal">
              <a class="nav-link" data-toggle="modal" data-target="#nopre"><!--调出模态框-->
                  <i class="fa fa-fw fa-user"></i>
                  <span class="nav-link-text">账号设置</span>
              </a>
          </li>
          <?php
          if($user_gid<=3 && $user_gid>=0) {
              ?>
              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="用户管理">
                  <a class="nav-link" href="paiban_manage.php">
                      <i class="fa fa-fw fa-wrench"></i>
                      <span class="nav-link-text">排班管理</span>
                  </a>
              </li>
          <?php }?>
          <?php
          if($user_gid<=1 && $user_gid>=0) {
              ?>
              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="用户管理">
                  <a class="nav-link" href="user_manage.php">
                      <i class="fa fa-fw fa-wrench"></i>
                      <span class="nav-link-text">用户管理</span>
                  </a>
              </li>
          <?php }?>
<!--          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="用户管理">-->
<!--              <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">-->
<!--                  <i class="fa fa-fw fa-wrench"></i>-->
<!--                  <span class="nav-link-text">用户管理</span>-->
<!--              </a>-->
<!--              <ul class="sidenav-second-level collapse" id="collapseComponents">-->
<!--                  <li>-->
<!--                      <a href="navbar.html">Navbar</a>-->
<!--                  </li>-->
<!--                  <li>-->
<!--                      <a href="cards.html">Cards</a>-->
<!--                  </li>-->
<!--              </ul>-->
<!--          </li>-->
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                 <?php echo $user_name;?></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>退出</a>
        </li>
      </ul>
    </div>
  </nav>
<div class="content-wrapper">