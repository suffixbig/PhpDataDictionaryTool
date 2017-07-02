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













//**************************
//以下是不常用設定-不是很了解作用請勿修改
//**************************
//**************************
//後台是否要密碼才能進入0否1是
//**************************
define("background_switch",0);
//是的話密碼是什麼
define("background_password", "taiwanno1"); 

//**************************
//設定不要顯示，或只能顯示的資料庫，優先權上 只顯示條件大於不顯示條件
//**************************
$ok_show_databases =array();//只能顯示的數據庫 注意部要改成=''，這設定值一定要是數組
$no_show_databases = array('information_schema', 'mysql', 'performance_schema', 'sys'); //不需要顯示的數據庫
$no_show_table = array(); //不需要顯示的數據表


//特別網址下測試時-設定特別條件
//在bkk.tw這個網址下時使用特別設定
if(preg_match("@bkk.tw@",$_SERVER['HTTP_HOST']) or preg_match("@m729499.com@",$_SERVER['HTTP_HOST']) or preg_match("@phpmytool.com@",$_SERVER['HTTP_HOST']) ){
	$cfg['servers'][$i]['port'] = 33306;//端口修改
	$cfg['servers'][$i]['database'] = 'coachmin';      //預設開啟資料庫
	$ok_show_databases =array('cart_opencart_00','credit','coachmin');//只能顯示的數據庫
}

$cfg['servers']['y']=$i;
$database = $cfg['servers'][$i]['database'];//資料庫名
//**************************
unset($i);//釋放變數$i
//**************************
$cfg['savedir']="_save";	//設定佔存目錄名