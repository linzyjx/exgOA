<?php
/**
 * Created by PhpStorm.
 * User: linzy
 * Date: 2018/05/02
 * Time: 17:37
 */
include_once ("inc.php");

function format_week(int $w){
    $week_row=array(
      '1'=>'星期一',
      '2'=>'星期二',
      '3'=>'星期三',
      '4'=>'星期四',
      '5'=>'星期五',
      '6'=>'星期六',
      '7'=>'星期天'
    );
    return($week_row[$w]);
}

function date_format_week($t_date){
    return(format_week(date("w",strtotime($t_date))));
}

function getstatus($status, $position) {
    $t = $status & pow(2, $position - 1) ? 1 : 0;
    return $t;
}
