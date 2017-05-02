<?php
$thisDir = ".";						//config.inc.php檔的相對路徑
$_file = basename(__FILE__);		//自行取得本程式名稱
require($thisDir."/config.php");	// 載入主參數設定檔
require(INCLUDE_PATH."/inc_password.php");	// 載入密碼登入系統
require_once INCLUDE_PATH."/mysql.inc.php";	// 載入資料庫函式
//require_once INCLUDE_PATH."/global_suffix.php";	// 載入資料庫函式

$to_dir="/".$admin_dir;
//print_r($_COOKIE);
?>

<p><a href="<?=$to_dir?>">到您的目錄</a></p>
<p><a href="loginok.php?type=del">登出</a></p>