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

if (empty($_POST['database'])) {
    echo "缺少database參數";exit;
} else {
    $database=$_POST['database'];
}

if (isset($_POST['prefix'])) {
    $prefix = $_POST['prefix'];
} else {
    $prefix = "";
}

$idall=$_POST['idall'];

$j=array("database"=> $database,                         
  "prefix"=>$prefix             
  );
$j["idall"]= $idall;


//檢查有沒有暫存檔目錄沒有就建立
if(!is_dir("../".$cfg['savedir'])){
    mkdir("../".$cfg['savedir']); 
}

$tempfile="../".$cfg['savedir']."/save_database.txt";//暫存檔名
//把值存檔
$json=json_encode($j);
$ok1=file_put_contents($tempfile,$json);//寫檔 //該函數將返回寫入到文件內數據的字節數。

    if($ok1){
        $r[ 'ok' ] = 1;
        $r[ 'sms' ] = '存檔成功';
    }else{
        $r[ 'ok' ] = 0;
        $r[ 'sms' ] = '失敗';
    }
echo json_encode($r);