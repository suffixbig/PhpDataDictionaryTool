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

//載入設定檔
require( 'config.inc.php' ); //載入設定檔

//配置數據庫 載入設定檔
require( 'config.inc.mysql.php' ); //載入資料庫帳號設定檔

//mysql配置
$dblink = @mysqli_connect( "$dbserver", "$dbusername", "$dbpassword" )or die( "Mysql connect is error." );
mysqli_select_db( $dblink, $database ); //選表
mysqli_query( $dblink, 'SET NAMES utf8' );
$table_result = mysqli_query( $dblink, 'show tables' );
/*********************************************/
$no_show_databases = array( 'information_schema', 'mysql', 'performance_schema', 'sys' ); //不需要顯示的數據庫
$no_show_table = array(); //不需要顯示的數據表
$_GET[ 'prefix' ] = 'oc_'; //替換所有的表前綴
if ( isset( $_GET[ 'prefix' ] ) ) {
	$prefix = $_GET[ 'prefix' ];
} else {
	$prefix = "";
}
/*********************************************/
//mysql_list_dbs --- 列出 MySQL 伺服器上可用的資料庫
$sql = 'SHOW DATABASES';
$result = mysqli_query( $dblink, $sql );
while ( $row = mysqli_fetch_row( $result ) ) {
	//過濾不需要顯示的數據庫
	if ( !in_array( $row[ 0 ], $no_show_databases ) ) {
		$DATANAME[] = $row[ 0 ];
	}
}
$result->close(); //釋放記憶體

echo "<div class=\"warp\"><h3>\n";
echo "服務器上所有數據庫名稱: <br />";
print_r( $DATANAME );
echo "</h3></div>\n";


//取得所有的表名
while ( $row = mysqli_fetch_array( $table_result ) ) {
	if ( !in_array( $row[ 0 ], $no_show_table ) ) {
		$tables[][ 'TABLE_NAME' ] = $row[ 0 ];
	}
}
/*
print_r($tables);//所有的表名
exit;
*/
//如果有參數
//替換所有表的表前綴
if ( $prefix ) {
	for ( $i = 0; $i < count( $tables ); $i++ ) {
		$a = $tables[ $i ];
		$tables2[][ 'TABLE_NAME' ] = str_replace( $prefix, "", $a[ 'TABLE_NAME' ] ); //替換字串
	}
	//echo "替換表前綴" . $prefix . "替換成功！";
}

//循環取得所有表的備註及表中列消息
foreach ( $tables as $k => $v ) {
	$sql = 'SELECT * FROM ';
	$sql .= 'INFORMATION_SCHEMA.TABLES ';
	$sql .= 'WHERE ';
	$sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
	$table_result = mysqli_query( $dblink, $sql );
	while ( $t = mysqli_fetch_assoc( $table_result ) ) {
		$tables[ $k ][ 'TABLE_COMMENT' ] = $t[ 'TABLE_COMMENT' ];
	}
	//print_r($sql);

	$sql = 'SELECT * FROM ';
	$sql .= 'INFORMATION_SCHEMA.COLUMNS ';
	$sql .= 'WHERE ';
	$sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

	$fields = array();
	$field_result = mysqli_query( $dblink, $sql );
	while ( $t = mysqli_fetch_assoc( $field_result ) ) {
		$fields[] = $t;
	}
	$tables[ $k ][ 'COLUMN' ] = $fields;
}
mysqli_close( $dblink ); //關閉資料庫

//print_r($tables);

/*
-----------------------------------------------------
資料表打註解原則
:前表示 表中文名
:後表示 表用途 (沒有也可以)
『#』號後都是註解，且之後『#』號表示換行 (沒有也可以)
------------------------------------------------------
範例1
	產品分類表
範例2
	產品分類表#主鍵：category_id
範例2
	產品分類表：用於商品的多級分類#主鍵：category_id
範例3
	產品分類表：用於商品的多級分類#主鍵：category_id#備註第2行#備註第3行
------------------------------------------------------
*/
foreach ( $tables as $k => $v ) {
	//如果有替換所有表的表前綴的行為 
	if ( $prefix ) {
		$TABLE_NAME = $tables2[ $k ][ 'TABLE_NAME' ]; //表名
	} else {
		$TABLE_NAME = $v[ 'TABLE_NAME' ];
	}
	//標題字修改
	$TABLE_COMMENT2 = ''; //第2行字
	$TABLE_COMMENT = $v[ 'TABLE_COMMENT' ];
	$TABLE_COMMENT = str_replace( "：", ":", $TABLE_COMMENT ); //替換字串-統一:字串

	//沒有:時的規則 以#做為切割
	if ( preg_match( "@#@", $TABLE_COMMENT ) ) {
		$TABLE_COMMENT1 = substr( $TABLE_COMMENT, 0, stripos( $TABLE_COMMENT, "#" ) ); //切出#前的字
		$TABLE_COMMENT2 = substr( $TABLE_COMMENT, stripos( $TABLE_COMMENT, "#" ) + 1 ); //切出:後的字
	} else {
		$TABLE_COMMENT1 = $TABLE_COMMENT;
	}
	//如果文字中有:號
	if( preg_match( "@:@", $TABLE_COMMENT1 ) ) {
		$b1 = substr( $TABLE_COMMENT1, 0, stripos( $TABLE_COMMENT1, ":" ) ); //切出:前的字
		$b2 = substr( $TABLE_COMMENT1, stripos( $TABLE_COMMENT1, ":" ) + 1 ); //切出:後的字
		$TABLE_COMMENT1=$b1;
		if($TABLE_COMMENT2)
		$TABLE_COMMENT2=$b2."#".$TABLE_COMMENT2;//把字用到地2行後
		else
		$TABLE_COMMENT2=$b2;
	}
	
	//重整出 標題名
	$tablesB[ 'TABLE_NAME' ][] = $TABLE_NAME; //放表英文名
	$tablesB[ 'TABLE_COMMENT1' ][] = $TABLE_COMMENT1; //中文
	$tablesB[ 'TABLE_COMMENT2' ][] = $TABLE_COMMENT2; //註解
}
/*
註解切割完畢
*/
//print_r($tablesB);
//exit;


$html = ''; //循環所有表
foreach ( $tables as $k => $v ) {
	$TABLE_NAME=$tablesB[ 'TABLE_NAME' ][ $k ];
	//顯示第1行字標題
	$html.='<a name="'.$TABLE_NAME.'" >';//id
		$html.='</a>';//id
	$html .= '	<h2>' . ( $k + 1 ) . '、' . $tablesB[ 'TABLE_COMMENT1' ][ $k ] . '  （<span class="cr">' . $TABLE_NAME . '</span>）</h2>' . "\n"; //標題  

	//顯示第2行字註解
	if ( $tablesB[ 'TABLE_COMMENT2' ][ $k ] ) {
		$html .= '<div><h3>';
		$html .= str_replace( "#", "<br>\n", $tablesB[ 'TABLE_COMMENT2' ][ $k ] ); //替換換行字串
		$html .= '</h3></div>';
	}
	$html .= '<table  border="1" cellspacing="0" cellpadding="0" align="center">';
	$html .= '	<table border="1" cellspacing="0" cellpadding="0" width="100%">' . "\n";
	$html .= '		<tbody>' . "\n";
	$html .= '			<tr>' . "\n";
	$html .= '				<th>字段名</th>' . "\n";
	$html .= '				<th>數據類型</th>' . "\n";
	$html .= '				<th>數據類型</th>' . "\n";
	$html .= '				<th>長度</th>' . "\n";
	$html .= '				<th>默認值</th>' . "\n";
	$html .= '				<th>允許非空</th>' . "\n";
	$html .= '				<th>主鍵</th>' . "\n";
	$html .= '				<th>備註</th>' . "\n";
	$html .= '			</tr>' . "\n";
	//表的值COLUMN
	foreach ( $v[ 'COLUMN' ] as $f ) {
		$html .= '			<tr>' . "\n";
		$html .= '				<td class="c1">' . $f[ 'COLUMN_NAME' ] . '</td>' . "\n";
		$html .= '				<td class="c2">' . _lang( $f[ 'DATA_TYPE' ], $idx_i_COLUMN_TYPE ) . '</td>' . "\n";
		$html .= '				<td class="c0c">' . $f[ 'DATA_TYPE' ] . '</td>' . "\n";
		//長度
		$LENGTH = "";
		if ( $f[ 'NUMERIC_PRECISION' ] ) {
			$LENGTH = $f[ 'NUMERIC_PRECISION' ];
		} else {
			if ( $f[ 'CHARACTER_OCTET_LENGTH' ] ) {
				$LENGTH = $f[ 'CHARACTER_OCTET_LENGTH' ];
			}
		}
		$html .= '				<td class="c0c">' . $LENGTH . '</td>' . "\n";
		$html .= '				<td class="c0c">' . $f[ 'COLUMN_DEFAULT' ] . '</td>' . "\n";
		$html .= '				<td class="c0c">' . $f[ 'IS_NULLABLE' ] . '</td>' . "\n";
		$html .= '				<td class="c5">' . $f[ 'COLUMN_KEY' ] . ( $f[ 'EXTRA' ] == 'auto_increment' ? '+自增' : '&nbsp;' ) . '</td>' . "\n";
		$html .= '				<td class="c6">' . $f[ 'COLUMN_COMMENT' ] . '</td>' . "\n";
		$html .= '			</tr>' . "\n";
	}
	$html .= '		</tbody>' . "\n";
	$html .= '	</table>' . "\n";
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<title>管理後臺-後台登入</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--ico-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="apple-touch-icon" href="/icon48.png">
<link rel="apple-touch-icon" sizes="72×72" href="/icon72.png">
<link rel="apple-touch-icon" sizes="114×114" href="/icon144.png">
<meta name="keywords" lang="zh-TW" content="癌症別發生率統計資料">
<meta name="description" content="68-102年縣市別性別癌症別發生率資料">
<!-- jQuery文件。務必在bootstrap.min.js 之前引入 -->
<script src="skin/js/jquery-3.1.0.min.js"></script>
<!-- 新 Bootstrap 核心 CSS 文件-->
<link rel="stylesheet" href="skin/js/bootstrap/3.3.7/css/bootstrap.min.css" >
<!--圖示-->
<link rel="stylesheet" href="skin/js/bootstrap/3.3.7/css/font-awesome.min.css">

<!-- 新 Bootstrap 核心 CSS 文件 
<link rel="stylesheet" href="skin/js/bootstrap/3.3.5/css/bootstrap.min.css">-->
<!-- 本頁專用 -->
<style type="text/css">
		body,
		td,
		th {
			font-family: "微軟雅黑";
			font-size: 14px;
		}
		
		.warp {
			margin: auto;
			width: 1000px;
		}
		
		.warp h2 {
			margin: 0px;
			padding: 0px;
			line-height: 40px;
			margin-top: 10px;
		}
		
		.warp h3 {
			margin: 0px;
			padding: 0px;
			line-height: 30px;
			margin-top: 10px;
		}
		
		table {
			border-collapse: collapse;
			border: 1px solid #CCC;
			background: #efefef;
		}
		
		table th {
			text-align: left;
			font-weight: bold;
			height: 26px;
			line-height: 26px;
			font-size: 14px;
			text-align: center;
			border: 1px solid #CCC;
			padding: 5px;
		}
		
		table td {
			height: 20px;
			font-size: 14px;
			border: 1px solid #CCC;
			background-color: #fff;
			padding: 5px;
		}
		
		.c0 {}
		
		.c0c {
			text-align: center;
		}
		
		.c1 {
			width: 120px;
		}
		/*c2中文類型*/
		
		.c2 {
			width: 100px;
			text-align: center;
		}
		
		.c3 {
			width: 150px;
		}
		
		.c4 {
			width: 80px;
			text-align: center;
		}
		
		.c5 {
			width: 80px;
			text-align: center;
		}
		
		.c6 {
			min-width: 370px;
		}
		
		.cr {
			color: #ff0033;
		}
		.table01 table td {
    font-size: 14px;
    border: 1px solid #CCC;
    background-color: #fff;
			padding: 0px;}
	</style>
</head>

<body>
<div class="warp">
		<h1 style="text-align:center;">生成數據庫字典</h1>


<hr>
<div class="table01">
		<table border="1" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td>序號</td>
					<td>表名<a href=""</td>
					<td>用途</td>
					<td>備註</td>
				</tr>
<?php
//列出所有表
$bn="\n";
$c1=$tablesB[ 'TABLE_NAME' ];
$c2=$tablesB[ 'TABLE_COMMENT1' ];
$c3=$tablesB[ 'TABLE_COMMENT2' ];//註解
for($i=0;$i<count($c1);$i++){
	echo "<tr>".$bn;
		echo "<td>".($i+1)."</td>".$bn;
		echo "<td><a href=\"#".$c1[$i]."\">".$c1[$i]."</a></td>".$bn;
		echo "<td>".$c2[$i]."</td>".$bn;
		echo "<td>".$c3[$i]."</td>".$bn;
	echo "</tr>".$bn;	
}
?>	

			</tbody>
		</table>
</div>
<hr>	
		<?php echo $html; ?>
</div>





<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="skin/js/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>