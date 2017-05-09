<?php
$thisDir = "..";                        //config.inc.php檔的相對路徑
$_file = basename(__FILE__);        //自行取得本程式名稱
require($thisDir."/config.inc.php");    // 載入主參數設定檔
require(INCLUDE_PATH."/inc_password.php");  // 載入密碼登入系統
require($thisDir."/config.inc.mysql.php" ); //載入資料庫帳號設定檔
require_once INCLUDE_PATH."/mysql.inc.php";     // 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";     // 載入資料庫函式
/***********************************************************************************************/
$err_ok = 1;//缺少參數要失敗
$r[ 'sms' ] = '修改失敗';
//print_r($_POST);
if(isset($_POST['database']) && isset($_POST['tablename']) &&  isset($_POST['edittext']) ) {

	$database=trim($_POST['database']);
	$tablename=trim($_POST['tablename']);
	$edittext=trim($_POST['edittext']); 
	if ($database && $tablename && $edittext){
		$err_ok = 0;//缺少參數要失敗
		
	}else{
		$err_ok = 1;//缺少參數要失敗
		$r[ 'sms' ] = '沒填內容你要改啥';
	}

}


if ( $err_ok ) {
	$r[ 'ok' ] = 0; //失敗

}else{
	$r[ 'ok' ] = 1;
	$r[ 'sms' ] = '修改成功';
}				
echo json_encode( $r ); //返回json_encode
