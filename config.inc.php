<?php
header("Content-Type:text/html;charset=utf-8");//全程式總編碼指定
//date_default_timezone_set('Asia/Taipei');//設定系統時區
define('WEB_ROOT_PATH', str_replace('\\','/',dirname(__FILE__))); //目前檔案所在絕對路徑，尾端沒協線
define('INCLUDE_PATH', WEB_ROOT_PATH . '/_inc');//設定檔所在目錄
$CT_CONFIG['logo_title']='數據字典';//網站名子
$CT_CONFIG['html_title']=$CT_CONFIG['logo_title'];//網頁標題
$CT_CONFIG['language']='zh-tw';//語系設置
require(INCLUDE_PATH.'/language/' . $CT_CONFIG['language'] . '.php' ); //載入語言策略
/*******************************************************************************************************/
/*陣列字串代換函式   A陣列為主 B陣列為轉換目標 2者數目要相同  若B陣列比數目較小也是會建立 預設的值為無****************/
function GetIndexName( $aryIndex, $aryName ) {
	if ( count( $aryIndex ) != count( $aryName ) ) {
		echo "A欄位" . count( $aryIndex ) . "筆B欄位" . count( $aryName ) . "筆，有資料欄位數目不相同，無法轉換";
		exit;
	}
	for ( $i = 0; $i < count( $aryIndex ); $i++ ) {
		$sBuf[ $aryIndex[ $i ] ] = $aryName[ $i ];
	}
	return $sBuf;
}

//字串翻譯 參數1 英文，
function _lang($key,$array){
		if(is_array($key))
		return '翻譯凾式錯誤';
		if(empty($array[$key]))
		return '';
		else
		return $array[$key];
}

/*******************************************************************************************************/
$idx_i_COLUMN_TYPEa = array( "int","tinyint","varchar","text","mediumtext","datetime","date","time","timestamp","bigint","char","varbinary","float","double","decimal","smallint","enum","set");
$idx_i_COLUMN_TYPEb = array( "數字","數子選項","字串","文章","超大文章","日期時間","日期","時間","數字時間戳","大數值","長度固定<br>字串","可變長度<br>二進位資料","浮點數","倍準<br>浮點數","定點數","3萬以下<br>整數","單選項","複選項"); //欄位
$lang_columntype = GetIndexName( $idx_i_COLUMN_TYPEa, $idx_i_COLUMN_TYPEb );

//表名英翻中
//OPENCART 2.1.0.1 增加表
$idx_i_oca = array("address","affiliate","affiliate_activity","affiliate_login","affiliate_transaction","api","attribute","attribute_description","attribute_group","attribute_group_description","banner","banner_image","banner_image_description","category","category_description","category_filter","category_path","category_to_layout","category_to_store","country","coupon","coupon_category","coupon_history","coupon_product","currency","custom_field","custom_field_customer_group","custom_field_description","custom_field_value","custom_field_value_description","customer","customer_activity","customer_ban_ip","customer_group","customer_group_description","customer_history","customer_ip","customer_login","customer_online","customer_reward","customer_transaction","download","download_description","event","extension","filter","filter_description","filter_group","filter_group_description","geo_zone","information","information_description","information_to_layout","information_to_store","language","layout","layout_module","layout_route","length_class","length_class_description","location","manufacturer","manufacturer_to_store","marketing","modification","module","openbay_faq","option","option_description","option_value","option_value_description","order","order_custom_field","order_fraud","order_history","order_option","order_product","order_recurring","order_recurring_transaction","order_status","order_total","order_voucher","product","product_attribute","product_description","product_discount","product_filter","product_image","product_option","product_option_value","product_recurring","product_related","product_reward","product_special","product_to_category","product_to_download","product_to_layout","product_to_store","recurring","recurring_description","return","return_action","return_history","return_reason","return_status","review","setting","stock_status","store");
$idx_i_ocb = array("用戶地址","加盟會員","加盟活動","加盟登錄","加盟交易","API","屬性","屬性描述","屬性組","屬性組描述","橫幅","橫幅圖片","橫幅圖片描述","品類","品類描述","品類過濾","品類路徑","品類佈局","品類倉庫","國家","優惠券","品類優惠券","優惠券歷史","產品優惠券","貨幣","定制字段表","定制字段客戶組","定制字段描述","定制字段值","定制字段值描述","會員","會員活動","會員禁止IP","會員分組","會員分組描述","會員歷史","會員IP","會員登錄","會員在線信息","會員積分","會員交易","文件下載","文件下載描述","事件","模塊擴展","過濾","過濾描述","過濾組","過濾組描述","地理區域","附屬信息","附屬信息描述","附屬信息佈局","店舖附屬信息","語言","佈局","佈局模式","佈局路徑","長度單位","長度單位描述","場所","品牌商","店舖品牌商","市場營銷","修改","模塊定義","商品詢問","商品屬性選項","商品屬性選項描述","商品屬性選項值","商品屬性選項值描述","訂單信息","客戶訂單字段","欺詐訂單信息","訂單履歷","訂單選項","訂單商品信息","反覆購買的商品訂單","反覆購買的商品交易","訂單狀態","訂單總額","禮券訂單","商品","商品屬性","商品屬性描述","商品打折","商品過濾","商品圖片","商品屬性選項","商品屬性選項值","反覆購買的商品","商品關聯信息","商品積分","特賣商品","商品品類","商品下載","商品佈局","店舖商品","反覆購買信息","反覆購買信息描述","退換貨","退換貨動作","退換貨歷史","退換貨原因","退換貨狀態","反饋評論","參數設置","庫存狀態","店舖信息");
$idx_i_oca=array_merge($idx_i_oca,array("tax_class","tax_rate","tax_rate_to_customer_group","tax_rule","upload","url_alias","user","user_group","voucher","voucher_history","voucher_theme","voucher_theme_description","weight_class","weight_class_description","zone","zone_to_geo_zone"));
$idx_i_ocb=array_merge($idx_i_ocb,array("稅金信息","稅率信息","客戶組稅率","稅率規則","文件上傳","鏈接搜索別名信息","系統用戶","系統用戶組","憑證","憑證履歷","憑證主題","憑證主題描述","重量單位","重量單位描述","地區信息","地理區域地區信息"));
//OPENCART 2.3.0.2 增加表
$idx_i_oca=array_merge($idx_i_oca,array("customer_search","customer_wishlist","theme","translation","menu","menu_description","menu_module"));
$idx_i_ocb=array_merge($idx_i_ocb,array("會員搜尋紀錄","會員心願表","主題","翻譯","選單","選單描述","選單模塊"));
$lang_tablenames = GetIndexName( $idx_i_oca, $idx_i_ocb );
