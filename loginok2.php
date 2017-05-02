<?PHP
/* 登入用 */
//session_start();
$thisDir = ".";      //config.inc.php檔的相對路徑
$_file = basename(__FILE__);  //自行取得本程式名稱
require($thisDir . "/config.php"); // 載入主參數設定檔
require_once INCLUDE_PATH . "/mysql.inc.php"; // 載入資料庫函式
//require_once INCLUDE_PATH . "/mysqli.inc.php"; // 載入資料庫函式
//require_once INCLUDE_PATH . "/global_suffix.php"; // 載入資料庫函式
/* * ******************************************************************************************** */

$COOKIE_DOMAIN = str_replace("www.", "", $_SERVER["SERVER_NAME"]); //COOKIE記億父網域名去掉最前面WWW登入用

//登出-清除COOKIE
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'del') {
        //COOKIE全清
        if (is_array($_COOKIE)) {
            foreach ($_COOKIE as $key => $val) {
                if ($key != 'PHPSESSID') {
                    setcookie($key, "", time() - 86400, "", $COOKIE_DOMAIN); //多了TOOL_URL的清除
                    setcookie($key, "", time() - 86400, "/", $COOKIE_DOMAIN);
                }
            }
        }
        header("Refresh: 0; url=login2.php"); //跳頁
    }
}
if (isset($_POST['pass'])) {
//登入  
$password=$_POST['pass'];
$adminpass2 = substr(base64_encode(date("Y-m") ."s3dfgdfgfdc6gew"), 2, 10); //打對一次密碼可以撐到月底 後台的密碼
/* * ******************************************************************************************** */
    if ($_POST['pass'] == 'a0922508800') {
        //通過密碼	
        setcookie('adminpass2', $adminpass2, time() + 2592000, "/", $COOKIE_DOMAIN); //記憶一個月
        header("Refresh: 0; url=admin.php"); //登入就跳首頁
    }
}

?>
登入失敗<br>
<a href="login.php">返回登入頁</a>
