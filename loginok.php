<?PHP
/*完全清除COOKIE用*/
session_start();
header("Content-Type:text/html;charset=utf-8");//全程式總編碼指定
date_default_timezone_set('Asia/Taipei');//設定系統時區此處時區要與config.php裡面相同
$thisDir = "."; //config.inc.php檔的相對路徑
$_file = basename(__FILE__);		//自行取得本程式名稱
require( $thisDir . "/config.inc.mysql.php" ); //載入資料庫帳號設定檔
$COOKIE_DOMAIN=str_replace("www.","",$_SERVER["SERVER_NAME"]);//COOKIE記億父網域名去掉最前面WWW登入用
$adminpass2=substr(base64_encode(date("Y-m")."dddujjm23uc"),2,10);//打對一次密碼可以撐到月底 超級密碼-通過就不鎖IP
//登出-清除COOKIE
if(isset($_GET['type']))
{
	if($_GET['type']=='del'){
	//COOKIE全清
		if(is_array($_COOKIE))
		{
			foreach($_COOKIE as $key=>$val)
			{
				if($key!='PHPSESSID'){	
	   			setcookie($key,"",time()-86400,"",$COOKIE_DOMAIN);//多了TOOL_URL的清除
				setcookie($key, "", time()-86400 ,"/",$COOKIE_DOMAIN);
				}
			}
		}
	    header("Refresh: 0; url=login.php");//跳頁
		session_destroy();
	}
}
if(isset($_POST['pass']))
{
	if($_POST['pass']=='a0922508800' or $_POST['pass']==background_password ){
			//通過密碼	
	 		setcookie('adminpass2',$adminpass2,time()+2592000,"/",$COOKIE_DOMAIN);//記憶一個月
			header("Refresh: 0; url=index.php");//登入就跳首頁
			exit;
	}
}
?>
登入失敗<br>
<a href="login.php">返回登入頁</a>
