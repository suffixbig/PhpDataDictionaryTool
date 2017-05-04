<?php
// 配置數據庫 第1組
$i=1;
$cfg['servers'][$i]['host'] = 'localhost';          //服務器位址
$cfg['servers'][$i]['port'] = 3306;                 //端口
$cfg['servers'][$i]['user'] = 'root';            //數據庫用戶名
$cfg['servers'][$i]['password'] = 'azsx1277'; //密碼
$cfg['servers'][$i]['database'] = '';      //預設開啟資料庫
// 配置數據庫 第2組
$i++;//不用打2;++就是以此類推+1的意示
$cfg['servers'][$i]['host'] = 'localhost';          		//服務器位址
$cfg['servers'][$i]['port'] = 33306;                 		//端口
$cfg['servers'][$i]['user'] = 'root';            			//數據庫用戶名
$cfg['servers'][$i]['password'] = 'azsx1277'; 				//密碼
$cfg['servers'][$i]['database'] = 'cart_opencart_00';      //預設開啟資料庫
// 配置數據庫 第3組
$i++;//不用打3;++就是以此類推+1的意示
$cfg['servers'][$i]['host'] = '192.168.1.3';          //服務器位址
$cfg['servers'][$i]['port'] = 3306;                 //端口
$cfg['servers'][$i]['user'] = 'big1234';            //數據庫用戶名
$cfg['servers'][$i]['password'] = 'dada_0727_lala'; //密碼
$cfg['servers'][$i]['database'] = 'credit';      //預設開啟資料庫
//**************************
$i=1;//本次使用第幾組設定
//**************************
//後台是否要密碼才能進入0否1是
define("background_switch",1); 
//是的話密碼是什麼
define("background_password", "taiwan no 1"); 

//特別網址下測試時-設定特別條件
if(!preg_match("@test.com@",$_SERVER['HTTP_HOST'])){
$i=2;//不是在test.com這個網址下時都使用第2組設定
}

$cfg['servers']['y']=$i;
$database = $cfg['servers'][$i]['database'];//資料庫名
//**************************
unset($i);//釋放變數$i
//**************************

