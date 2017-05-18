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
if(isset($_POST['database']) && isset($_POST['tablename']) &&  isset($_POST['edittext']) ) {

	$database=trim($_POST['database']);
	$tablename=trim($_POST['tablename']);
	$edittext=trim($_POST['edittext']); 
	if ($database && $tablename && $edittext){
$db = new Api_mysqli;
$dblink = $db->mysql_open(); //開資料庫連線================================================
//===========================================================
if ($database) {
    $db->mysqluse($database,$dblink); //切換資料庫
	//修改註解
	$sql="ALTER TABLE `".$tablename."` ";
	$sql.="COMMENT='".$edittext."' ";
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
