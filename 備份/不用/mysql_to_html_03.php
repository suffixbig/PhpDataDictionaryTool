<?php
header('Content-type:text/html;charset=utf-8');

//配置數據庫 載入設定檔
require('config.inc.mysql.php');//載入資料庫帳號設定檔

//其他配置
$title=$database.' 数据库数据字典';
$mysql_conn=@mysql_connect("$dbserver","$dbusername","$dbpassword") or die("Mysql connect is error.");
mysql_select_db($database,$mysql_conn);
mysql_query('SET NAMES utf8',$mysql_conn);
$table_result=mysql_query('show tables',$mysql_conn);
//取得所有的表名
while($row=mysql_fetch_array($table_result)){
    $tables[]['TABLE_NAME']=$row[0];
}
//循环取得所有表的备注
foreach ($tables AS $k=>$v){
    $sql='SELECT * FROM ';
    $sql.='INFORMATION_SCHEMA.TABLES ';
    $sql.='WHERE ';
    $sql.="table_name='{$v['TABLE_NAME']}'  AND table_schema='{$database}'";
    $table_result=mysql_query($sql,$mysql_conn);
    while($t=mysql_fetch_array($table_result)){
        $tables[$k]['TABLE_COMMENT']=$t['TABLE_COMMENT'];
    }
    $sql='SELECT * FROM ';
    $sql.='INFORMATION_SCHEMA.COLUMNS ';
    $sql.='WHERE ';
    $sql.="table_name='{$v['TABLE_NAME']}' AND table_schema='{$database}'";
    $fields=array();
    $field_result=mysql_query($sql,$mysql_conn);
    while($t=mysql_fetch_array($field_result)){
        $fields[]=$t;
    }
    $tables[$k]['COLUMN']=$fields;
}
mysql_close($mysql_conn);
$html='';
//循环所有表
foreach($tables AS $k=>$v){
    $html.='<table  border="1" cellspacing="0" cellpadding="0" align="center">';
    $html.='<caption>'.$v['TABLE_COMMENT'].'（<span class="cr">'. $v['TABLE_NAME'].'</span>）</caption>';
    $html.='<tbody><tr><th width="120">字段名</th><th width="120">数据类型</th><th width="120">默认值</th>
    <th width="65">允许非空</th>
    <th width="360">备注</th></tr>';
    $html.='';
    foreach($v['COLUMN'] AS $f){
        $html.='<tr><td>'.$f['COLUMN_NAME'].'</td>';
        $html.='<td>'.$f['COLUMN_TYPE'].'</td>';
        $html.='<td>'.$f['COLUMN_DEFAULT'].'</td>';
        $html.='<td>'.$f['IS_NULLABLE'].'</td>';
        $html.='<td>'.$f['COLUMN_COMMENT'].($f['EXTRA']=='auto_increment'?'，自动递增':'').'</td>';
        $html.='</tr>';
    }
    $html.='</tbody></table></p>';
}
//输出
echo '<html>
<head>
<title>'.$title.'</title>
<style>
body,td,th{font-family:"宋体"; font-size:12px;}
table{border-collapse:collapse;border:1px solid #CCC;background:#efefef;}
table caption{text-align:left; background-color:#fff; line-height:2em; font-size:14px; font-weight:bold; }
table th{text-align:left; font-weight:bold;height:26px; line-height:26px; font-size:12px; border:1px solid #CCC;}
table td{height:20px; font-size:12px; border:1px solid #CCC;background-color:#fff;}
table caption,table td,table th{padding:0px 3px;}
#version{text-align:center;margin:0 auto;}
.cr{color:#ff0033;}
</style>
</head>
<body>';
echo '<h1>'.$title.'</h1>';
echo $html;
$version='<p id="version">made by <a href="http://www.phpernote.com" target="_blank">www.phpernote.com</a></p>';
echo '<p>&nbsp;</p>'.$version.'<p>&nbsp;</p></body></html>';