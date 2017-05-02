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
白底黑字
適用PHP5.4~PHP7.0
*/
header("Content-type: text/html; charset=utf-8");
//配置數據庫 載入設定檔
require('config.inc.mysql.php');//載入資料庫帳號設定檔
//其他配置
$dblink = @mysqli_connect("$dbserver", "$dbusername", "$dbpassword") or die("Mysql connect is error.");
mysqli_select_db($dblink,$database);//選表
mysqli_query($dblink, 'SET NAMES utf8');
$table_result = mysqli_query($dblink, 'show tables');

$no_show_databases = array('information_schema','mysql','performance_schema','sys');   //不需要顯示的數據庫
$no_show_table = array();    //不需要顯示的表
$no_show_field = array();   //不需要顯示的字段


//mysql_list_dbs --- 列出 MySQL 伺服器上可用的資料庫
$sql='SHOW DATABASES';
$result = mysqli_query($dblink, $sql);
while($row = mysqli_fetch_array($result)){
	if(!in_array($row[0],$no_show_databases)){
		$DATANAME[] = $row[0];
	}
}
$result->close(); //釋放記憶體
echo "服務器上所有數據庫名稱: <br />";
print_r($DATANAME);

//取得所有的表名
while($row = mysqli_fetch_array($table_result)){
	if(!in_array($row[0],$no_show_table)){
		$tables[]['TABLE_NAME'] = $row[0];
	}
}


//如果有參數
//替換所以表的表前綴
if(@$_GET['prefix']){
	$prefix = 'czzj';
	foreach($tables as $key => $val){
		$tableName = $val['TABLE_NAME'];
		$string = explode('_',$tableName);
		if($string[0] != $prefix){  
			$string[0] = $prefix;  
			$newTableName = implode('_', $string);  
			mysqli_query('rename table '.$tableName.' TO '.$newTableName);  
		}
	}
	echo "替換成功！";exit();
}

//循環取得所有表的備註及表中列消息
foreach ($tables as $k=>$v) {
    $sql  = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.TABLES ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
    $table_result = mysqli_query($dblink,$sql);
    while ($t = mysqli_fetch_array($table_result) ) {
        $tables[$k]['TABLE_COMMENT'] = $t['TABLE_COMMENT'];
    }

    $sql  = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

    $fields = array();
    $field_result = mysqli_query($dblink,$sql);
    while ($t = mysqli_fetch_array($field_result) ) {
        $fields[] = $t;
    }
    $tables[$k]['COLUMN'] = $fields;
}
mysqli_close($dblink);


$html = '';
//循環所有表
foreach ($tables as $k=>$v) {
    $html .= '	<h3>' . ($k + 1) . '、' . $v['TABLE_COMMENT'] .'  （'. $v['TABLE_NAME']. '）</h3>'."\n";
    $html .= '	<table border="1" cellspacing="0" cellpadding="0" width="100%">'."\n";
    $html .= '		<tbody>'."\n";
	$html .= '			<tr>'."\n";
	$html .= '				<th>字段名</th>'."\n";
	$html .= '				<th>數據類型</th>'."\n";
	$html .= '				<th>默認值</th>'."\n";
	$html .= '				<th>允許非空</th>'."\n";
	$html .= '				<th>自動遞增</th>'."\n";
	$html .= '				<th>備註</th>'."\n";
	$html .= '			</tr>'."\n";

    foreach ($v['COLUMN'] as $f) {
		if(@!is_array($no_show_field[$v['TABLE_NAME']])){
			$no_show_field[$v['TABLE_NAME']] = array();
		}
		if(!in_array($f['COLUMN_NAME'],$no_show_field[$v['TABLE_NAME']])){
			$html .= '			<tr>'."\n";
			$html .= '				<td class="c1">' . $f['COLUMN_NAME'] . '</td>'."\n";
			$html .= '				<td class="c2">' . $f['COLUMN_TYPE'] . '</td>'."\n";
			$html .= '				<td class="c3">' . $f['COLUMN_DEFAULT'] . '</td>'."\n";
			$html .= '				<td class="c4">' . $f['IS_NULLABLE'] . '</td>'."\n";
			$html .= '				<td class="c5">' . ($f['EXTRA']=='auto_increment'?'是':'&nbsp;') . '</td>'."\n";
			$html .= '				<td class="c6">' . $f['COLUMN_COMMENT'] . '</td>'."\n";
			$html .= '			</tr>'."\n";
		}
    }
    $html .= '		</tbody>'."\n";
	$html .= '	</table>'."\n";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>生成數據庫字典</title>
<meta name="generator" content="ThinkDb V1.0" />
<meta name="author" content="南昌騰速科技有限公司http://www.tensent.cn" />
<meta name="copyright" content="2008-2014 Tensent Inc." />
<style>
body, td, th { font-family: "微軟雅黑"; font-size: 14px; }
.warp{margin:auto; width:900px;}
.warp h3{margin:0px; padding:0px; line-height:30px; margin-top:10px;}
table { border-collapse: collapse; border: 1px solid #CCC; background: #efefef; }
table th { text-align: left; font-weight: bold; height: 26px; line-height: 26px; font-size: 14px; text-align:center; border: 1px solid #CCC; padding:5px;}
table td { height: 20px; font-size: 14px; border: 1px solid #CCC; background-color: #fff; padding:5px;}
.c1 { width: 120px; }
.c2 { width: 120px; }
.c3 { width: 150px; }
.c4 { width: 80px; text-align:center;}
.c5 { width: 80px; text-align:center;}
.c6 { width: 270px; }
</style>
</head>
<body>
<div class="warp">
	<h1 style="text-align:center;">生成數據庫字典</h1>
<?php echo $html; ?>
</div>
</body>
</html>