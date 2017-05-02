<?php
/*
Create date:2014-01-01
Last update date:2017-04-19
Plugin Name: phpmysqli_dictionary
Plugin URI: http://www.bkk.tw
Description: PHP生成mysql數據庫字典工具 
Version: 1.0.1
Author: david
*/ 
/*
標題藍底白字
*/
header ( "Content-type: text/html; charset=utf-8" );

//配置數據庫 載入設定檔
require('config.inc.mysql.php');//載入資料庫帳號設定檔
// 其他配置
$title = '數據字典';

$mysql_conn = @mysql_connect ( "$dbserver", "$dbusername", "$dbpassword" ) or die ( "Mysql connect is error." );
mysql_select_db ( $database, $mysql_conn );
mysql_query ( 'SET NAMES utf8', $mysql_conn );
$table_result = mysql_query ( 'show tables', $mysql_conn );
// 取得所有的表名
while ( $row = mysql_fetch_array ( $table_result ) ) {
    $tables [] ['TABLE_NAME'] = $row [0];
}

// 循環取得所有表的備註及表中列消息
foreach ( $tables as $k => $v ) {
    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.TABLES ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
    $table_result = mysql_query ( $sql, $mysql_conn );
    while ( $t = mysql_fetch_array ( $table_result ) ) {
        $tables [$k] ['TABLE_COMMENT'] = $t ['TABLE_COMMENT'];
    }

    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

    $fields = array ();
    $field_result = mysql_query ( $sql, $mysql_conn );
    while ( $t = mysql_fetch_array ( $field_result ) ) {
        $fields [] = $t;
    }
    $tables [$k] ['COLUMN'] = $fields;
}
mysql_close ( $mysql_conn );

$html = '';
// 循環所有表
foreach ( $tables as $k => $v ) {
    // $html .= '<p><h2>'. $v['TABLE_COMMENT'] . '&nbsp;</h2>';
    $html .= '<table  border="1" cellspacing="0" cellpadding="0" align="center">';
    $html .= '<caption>' . $v ['TABLE_NAME'] . '  ' . $v ['TABLE_COMMENT'] . '</caption>';
    $html .= '<tbody><tr><th>字段名</th><th>數據類型</th><th>默認值</th>
    <th>允許非空</th>
    <th>自動遞增</th><th>備註</th></tr>';
    $html .= '';

    foreach ( $v ['COLUMN'] as $f ) {
        $html .= '<tr><td class="c1">' . $f ['COLUMN_NAME'] . '</td>';
        $html .= '<td class="c2">' . $f ['COLUMN_TYPE'] . '</td>';
        $html .= '<td class="c3">&nbsp;' . $f ['COLUMN_DEFAULT'] . '</td>';
        $html .= '<td class="c4">&nbsp;' . $f ['IS_NULLABLE'] . '</td>';
        $html .= '<td class="c5">' . ($f ['EXTRA'] == 'auto_increment' ? '是' : '&nbsp;') . '</td>';
        $html .= '<td class="c6">&nbsp;' . $f ['COLUMN_COMMENT'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table></p>';
}

// 輸出
echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>' . $title . '</title>
<style>
body,td,th {font-family:"細明體"; font-size:12px;}
table{border-collapse:collapse;border:1px solid #CCC;background:#6089D4;}
table caption{text-align:left; background-color:#fff; line-height:2em; font-size:14px; font-weight:bold; }
table th{text-align:left; font-weight:bold;height:26px; line-height:25px; font-size:16px; border:3px solid #fff; color:#ffffff; padding:5px;}
table td{height:25px; font-size:12px; border:3px solid #fff; background-color:#f0f0f0; padding:5px;}
.c1{ width: 150px;}
.c2{ width: 130px;}
.c3{ width: 70px;}
.c4{ width: 80px;}
.c5{ width: 80px;}
.c6{ width: 300px;}
</style>
</head>
<body>';
echo '<h1 style="text-align:center;">' . $title . '</h1>';
echo $html;
echo '</body></html>';

?>