<?php
$thisDir = "..";                        //config.inc.php檔的相對路徑
$_file = basename(__FILE__);        //自行取得本程式名稱
require($thisDir."/config.inc.php");    // 載入主參數設定檔
require(INCLUDE_PATH."/inc_password.php");  // 載入密碼登入系統
require($thisDir."/config.inc.mysql.php" ); //載入資料庫帳號設定檔
require_once INCLUDE_PATH."/mysql.inc.php";     // 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";     // 載入資料庫函式
/***********************************************************************************************/

$dblink=_mysql_open();//開資料庫連線================================================

//$database='cart_opencart_00';//指定資料庫
//$v_TABLE_NAME="oc_product";//指定資料表
if (empty($_GET['database'])) {
//echo "缺少database參數";exit;
} else {
    $database=$_GET['database'];
}
if (empty($_GET['tablename'])) {
    echo "缺少tablename參數";
    exit;
} else {
    $v_TABLE_NAME=$_GET['tablename'];
}
//===========================================================

if ($database) {
    mysqluse($dblink, $database);//切換資料庫
}
//===========================================================
$sql = 'SELECT TABLE_COMMENT FROM ';
$sql .= 'INFORMATION_SCHEMA.TABLES ';
$sql .= 'WHERE ';
$sql .= "table_name = '{$v_TABLE_NAME}'  AND table_schema = '{$database}'";
$v[ 'TABLE_COMMENT' ]=row_sql1p($sql, 0, $dblink);


$sql = 'SELECT * FROM ';
$sql .= 'INFORMATION_SCHEMA.COLUMNS ';
$sql .= 'WHERE ';
$sql .= "table_name = '{$v_TABLE_NAME}' AND table_schema = '{$database}'";

$v[ 'COLUMN' ]=assoc_sql($sql, $dblink);
/*
print_r($TABLE_COMMENT);
print_r($date);
exit;
*/
_mysql_close($dblink);//關資料庫==============================================================
//print_r($tables);
/***********************************************************************************************/

$html = ''; //循環所有表

    $TABLE_NAME=$database;

    $b=cut_annotations($TABLE_NAME, $v[ 'TABLE_COMMENT' ]);//參數英文名和註解

    //重整出 標題名
    $tablesB[ 'TABLE_NAME' ][] = $b['TABLE_NAME']; //放表英文名
    $tablesB[ 'TABLE_COMMENT1' ][] = $b['TABLE_COMMENT1']; //中文
    $tablesB[ 'TABLE_COMMENT2' ][] = $b['TABLE_COMMENT2']; //註解
    $k=0;

    //顯示第1行字標題
    $html.='<a name="'.$TABLE_NAME.'" id="'.$TABLE_NAME.'">';//id
        $html.='</a>';//id
    $html .= '	<h2>' . $tablesB[ 'TABLE_COMMENT1' ][ $k ] . '  （<span class="cr">' . $TABLE_NAME . '</span>）</h2>' . "\n"; //標題

    //顯示第2行字註解
if ($tablesB[ 'TABLE_COMMENT2' ][ $k ]) {
    $html .= '<div><h3>';
    $html .= str_replace( "#", "<br>\n", $tablesB[ 'TABLE_COMMENT2' ][ $k ] ); //替換換行字串
    $html .= '</h3></div>';
}

    $html .= '<table border="1" cellspacing="0" cellpadding="0" width="100%" class="table table-striped table-bordered" >' . "\n";
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
foreach ($v[ 'COLUMN' ] as $f) {
    $html .= '			<tr>' . "\n";
    $html .= '				<td class="c1">' . $f[ 'COLUMN_NAME' ] . '</td>' . "\n";
    $html .= '				<td class="c2">' . _lang( $f[ 'DATA_TYPE' ], $lang_columntype ) . '</td>' . "\n";
    $html .= '				<td class="c0c">' . $f[ 'DATA_TYPE' ] . '</td>' . "\n";
    //長度
    $LENGTH = "";
    if ($f[ 'NUMERIC_PRECISION' ]) {
        $LENGTH = $f[ 'NUMERIC_PRECISION' ];
    } else {
        if ($f[ 'CHARACTER_OCTET_LENGTH' ]) {
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
?>
<div class="warp">
        <?php echo $html; ?>
</div>
