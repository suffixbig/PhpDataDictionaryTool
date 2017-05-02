<?php
//密碼系統
$adminpass2=substr(base64_encode(date("Y-m")."dddujjm23uc"),2,10);//打對一次密碼可以撐到月底 超級密碼-通過就不鎖IP
if(isset($_COOKIE['adminpass2'])){
 	 if( $_COOKIE['adminpass2']==$adminpass2){
 	 }else{
		//未登入就跳頁 
		header("Refresh: 0; url=login.php");
 	 	exit;
 	 }
}else{
		//未登入就跳頁 
		header("Refresh: 0; url=login.php");
 	 	exit;
}