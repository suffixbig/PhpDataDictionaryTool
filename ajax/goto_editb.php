<?php
$thisDir = "..";                        //config.inc.php檔的相對路徑
$_file = basename(__FILE__);        //自行取得本程式名稱
require($thisDir."/config.inc.php");    // 載入主參數設定檔
require($thisDir."/config.inc.mysql.php" ); //載入資料庫帳號設定檔
if (background_switch) {require INCLUDE_PATH . "/inc_password.php"; // 載入密碼登入系統
}
require_once INCLUDE_PATH."/mysql.inc.php";     // 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";     // 載入資料庫函式
/***********************************************************************************************/
//http://test.com/github_cloud/PhpDataDictionaryTool/ajax/goto_edit.php?database=cart_opencart_00&tablename=oc_affiliate&edittext=abc
/***********************************************************************************************/
$err_ok = 1;//缺少參數要失敗
$r[ 'sms' ] = _lang('fail_to_edit',$lang);
if(isset($_POST['database']) && isset($_POST['tablename']) && isset($_POST['column_name']) &&  isset($_POST['edittext']) ) {

	$database=trim($_POST['database']);
	$tablename=trim($_POST['tablename']);
    $column_name=trim($_POST['column_name']);
	$edittext=trim($_POST['edittext']); 
	if ($database && $tablename && $column_name && $edittext){
$db = new Api_mysqli;
$dblink = $db->mysql_open(); //開資料庫連線================================================
//===========================================================
if ($database) {
    $db->mysqluse($database,$dblink); //切換資料庫
    //讀取結構格式
    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
    $sql .= 'WHERE ';
    $sql .= "COLUMN_NAME ='".$column_name."' AND table_name = '{$tablename}' AND table_schema = '{$database}'";
    $f = $db->assoc_sql1p($sql, $dblink);

    //默認值是
    if($f['COLUMN_DEFAULT'])
    $DEFAULT=" DEFAULT '".$f['COLUMN_DEFAULT']."' ";
    else
    $DEFAULT="";
    //預設值-允許空白
    if($f['IS_NULLABLE']=='NO')
    $NULL2='NOT NULL';
    else
    $NULL2='NULL';
    //print_r($f);
    /*修改原欄位名稱、修改資料長度、資料形態
    ALTER TABLE 資料表名稱 CHANGE COLUMN 舊欄位 新欄位 新形態(新長度), ADD INDEX(新欄位);
    例
    ALTER TABLE `email` CHANGE `sno` `sno` INT(11) NOT NULL COMMENT '序號A';
    ALTER TABLE `email` CHANGE `email_type` `email_type` TINYINT(9) NOT NULL DEFAULT '0' COMMENT '信件類別-1是訂單確認信一下訂就寄,2出貨通知信,3廣告信,4單獨寄的信1';
    */

	//修改註解-欄位
	$sql="ALTER TABLE `".$tablename."` ";
    $sql.="CHANGE `$column_name` `$column_name` ";
    $sql.=strtoupper($f['COLUMN_TYPE'])." $NULL2 $DEFAULT ";//轉大寫
	$sql.="COMMENT '".$edittext."' ";
    //print_r($f);
    //echo $sql;exit;
	$ok=$db->_sql($sql,$dblink);//成功不會有返回值
	$err_ok = 0;//參數都有
}
//===========================================================
//有指定資料庫 情況 END
$db->mysql_close($dblink); //關資料庫========================================================
	}else{
		$err_ok = 1;//缺少參數要失敗
		$r[ 'sms' ] = _lang('No_content_to_change_Han',$lang);
	}

}
if ( $err_ok ) {
	$r[ 'ok' ] = 0; //失敗

}else{
	$r[ 'ok' ] = 1;
	$r[ 'sms' ] = _lang('The_modification_is_complete',$lang);
}				
echo json_encode( $r ); //返回json_encode
