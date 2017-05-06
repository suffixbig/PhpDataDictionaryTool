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

    $TABLE_NAME=$database;

    $b=cut_annotations($TABLE_NAME, $v[ 'TABLE_COMMENT' ]);//參數英文名和註解

    //重整出 標題名
    $tablesB[ 'TABLE_NAME' ][] = $b['TABLE_NAME']; //放表英文名
    $tablesB[ 'TABLE_COMMENT1' ][] = $b['TABLE_COMMENT1']; //中文
    $tablesB[ 'TABLE_COMMENT2' ][] = $b['TABLE_COMMENT2']; //註解
    $k=0;
	
	$html = ''; //循環所有表
	//重複程式碼
	//參數$html,$tablesB=有放註解的數組,$k=第幾個,$v=表的各欄值
	$html=combination_of_content($html,$tablesB,$k,$v);
?>
<div class="warp">
        <?php echo $html; ?>
</div>
