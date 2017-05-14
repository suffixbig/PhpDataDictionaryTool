<?php
/*
2014/05/14
suffixbig
*/

//php二維陣列排序 第一個參數放陣列，第二個參數放要排序的欄位名
//升降羃flag有 asc 或 desc
function array_csort($arr, $keys, $type)
{
    if (is_array($arr) && $keys) {
        $keysvalue = array();
        $i = 0;
        foreach ($arr as $key => $val) {
            $val[$keys] = str_replace("-", "", $val[$keys]);
            $val[$keys] = str_replace(" ", "", $val[$keys]);
            $val[$keys] = str_replace(":", "", $val[$keys]);
            $keysvalue[] = $val[$keys];
        }
        asort($keysvalue); //key值排序
        reset($keysvalue); //指針重新指向數組第一個
        foreach ($keysvalue as $key => $vals) {
            $keysort[] = $key;
        }
        $new_array = array();
        if ($type != "asc") {
            for ($ii = count($keysort) - 1; $ii >= 0; $ii--) {
                $new_array[] = $arr[$keysort[$ii]];
            }

        } else {
            for ($ii = 0; $ii < count($keysort); $ii++) {
                $new_array[] = $arr[$keysort[$ii]];
            }
        }
        return $new_array;
    } else {
        return false;
    }
}

//查參數裏面是否純數字 否就中斷
function is_num($str)
{
    if (is_numeric($str)) {
        return $str;
    } else {
        echo "參數非純數字";
        exit;
    }
}

//查參數裏面是否有空格-有空格就中斷-不能讓SQL裏面有空格
function check_mysql($str)
{
    if (is_array($str)) {
        foreach ($str as $key => $v) {
            if (preg_match("@chr\(@i", $str)) {
                echo "參數內含非法字元";
                exit;
            } else if (preg_match("@char\(@i", $str)) {
                echo "參數內含非法字元";
                exit;
            } else if (substr_count($v, " ") > 0) {
                echo "參數內有非法字元空格";
                exit;
            }
        }
    } else {
        if (preg_match("@chr\(@i", $str)) {
            echo "參數內含非法字元";
            exit;
        } else if (preg_match("@char\(@i", $str)) {
            echo "參數內含非法字元";
            exit;
        } else if (substr_count($str, " ") > 0) {
            echo "參數內有非法字元空格";
            exit;
        }
    }
    return $str;
}

/*解決中文檔名下載問題*/
function d_ie_firefox($my_file)
{
    $my_file = str_replace(" ", "_", $my_file);//解決空格問題-把空格換掉
    $my_file = str_replace("#", "", $my_file);//解決空格問題
    $my_file = str_replace("'", "", $my_file);//解決空格問題
    $my_file = str_replace('"', "", $my_file);//解決空格問題
    $my_file = str_replace('+', "", $my_file);//解決空格問題

    if (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT']))
        return $my_file;
    return str_replace('+', '%20', urlencode($my_file));
}

//MYSQL資料庫收詢不能讓一般人使用%字元
function search_check($str)
{
    // 判斷magic_quotes_gpc是否打開
    if (MAGIC_QUOTES_GPC) {
    } else {
        $str = addslashes($str);// 沒開進行過濾
    }
    $str = str_replace("_", "\_", $str);     // 把 '_'過濾掉
    $str = str_replace("%", "\%", $str);     // 把 '%'過濾掉
    return $str;
}

//收詢結果變色處理 參數1變數 2參數字串
function ct_search_text($str, $s)
{
    $s1 = "<span class=\"search_text_r\">";
    $s2 = "</span>";
    if ($s && $str) {
        $str2 = str_replace($s, $s1 . $s . $s2, $str);
    } else {
        $str2 = $str;
    }
    return $str2;
}


/*字串處理區 開始==============================================================================================*/

//切utf8碼中文字串 參數 $rBuf字串 $no字數 參數3可省 後面加上刪節符號... 或不加
function cut_string($rBuf, $no, $dot = '...')
{
    $len = mb_strlen($rBuf, 'utf8');
    $tmpBuf = $rBuf;
    if ($no > 0) {
        if ($len > $no) {
            $tmpBuf = mb_substr($rBuf, 0, $no, 'utf8') . $dot;
        }
    }
    return $tmpBuf;
}

//切utf8碼中文字串 包含去除HTML 參數 $rBuf字串 $no字數 參數3可省 後面加上刪節符號... 或不加
function cut_string_html($rBuf, $no, $dot = '...')
{
//去HTML，換行，和空格，簡介裁100字
    $patterns = array("'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 標籤
        "'/\s+/'",                       // 去掉換行字元
        '@' . chr(10) . '@i',                  // 去掉換行字元-實驗過這樣才能去掉掉換行
        '@ @i',                           // 去掉空白
        "@,@i",                               // 去除,號
        "@\)@i",                           // 去除)號
        "@\(@i",                           // 去除(號
        "@（@i",                               // 去除（號
        "@）@i",                               // 去除）號
        "@'@i",                           // 去除'號
        '@"@i',                           // 去除"號
    );
    $str = preg_replace($patterns, "", $rBuf);//去換行和空格等....
    return cut_string($str, $no, $dot);
}

//字串處理'一律加反斜線。	非get,post,cookie傳來的字串一定要加反斜線才能入資料庫
function c_addslashes($string)
{
    return addslashes($string);
}

/**
 * 自訂的addslashes函式，可以處理字串或字串陣列
 * @param string|array $string 要進行addslashes處理的字串，可以是單純字串或字串陣列
 * @param int $force 強制進行addslashes處理，不管MAGIC_QUOTES_GPC功能有沒有打開 1=是 0=否
 * @return string|array 處理好的字串或字串陣列
 */
function ct_addslashes($string, $force = 0)
{
    //!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());//此行已加在config.ini
    //沒開或$force=1都處理
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = addslashes($val);//把陣列處理完
            }
        } else {
            $string = addslashes($string);//非陣列處理完
        }
    }
    return $string;
}


/**
 * 將HTML符號轉換成相對應的HTML Entity，轉換的符號包括&"<>
 * 可以接受單純字串或字串陣列
 * @param string $string 欲處理的字串
 * @return string 處理好的字串
 */
function ct_htmlspecialchars($string)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = ct_htmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
            str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}


/**
 * 顯示alert訊息並跳轉頁面
 * @param string $message 要顯示的訊息，可以放入\n來換行
 * @param string $url 要跳轉的頁面URL
 * @param integer $flag 回上一頁還是跳轉到$url指定的頁面
 */
function ct_goback($message, $url, $flag)
{
    global $CT_CONFIG;
    echo "<!DOCTYPE HTML>\n";
    echo "<HTML>\n";
    echo "<HEAD>\n";
    echo "<meta charset=\"" . $CT_CONFIG['charset'] . "\">\n";
    echo "</HEAD>\n";
    echo "<script type=\"text/javascript\">\n";
    if (trim($message) != "")
        echo "alert(\"" . $message . "\");\n";
    switch ($flag) {
        case 0 :
            echo "history.back();\n";
            break;
        case 1 :
            echo "document.location.replace(\"" . $url . "\");\n";
            break;
    }
    echo "</script>\n";
    echo "<body>\n";
    echo "</body>\n";
    echo "</HTML>\n";
}

/*字串處理區 END==============================================================================================*/

/*陣列涵式區 開始==============================================================================================*/

//一維陣列  取單值 參數1陣列 2.欄位名 (一唯陣列用)
function arrayx01($array, $name = 0)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if ($key == $name)
                $arrayB = $value;
        }
        return $arrayB;
    } else {
        return false;
    }
}

//將二唯陣列轉一維陣列 以陣列中單一欄位建立新1維陣列 參數1陣列 2.欄位 (二唯陣列用)
function arrayx02($array, $name = 0)
{
    if (is_array($array)) {

        for ($i = 0; $i < count($array); $i++) {
            if (is_array($array[$i])) {
                foreach ($array[$i] as $key => $value) {
                    if ($key == $name) {
                        $arrayB[] = $value;
                    }
                }
            }
        }
        return $arrayB;

    } else {
        return false;
    }
}

/*陣列涵式區 END==============================================================================================*/


//判斷文字是否UTF8編碼
function is_utf8($str)
{
    $i = 0;
    $len = strlen($str);

    for ($i = 0; $i < $len; $i++) {
        $sbit = ord(substr($str, $i, 1));
        if ($sbit < 128) {
            //本字節為英文字符，不與理會
        } elseif ($sbit > 191 && $sbit < 224) {
            //第一字節為落於192~223的utf8的中文字(表示該中文為由2個字節所組成utf8中文字)，找下一個中文字
            $i++;
        } elseif ($sbit > 223 && $sbit < 240) {
            //第一字節為落於223~239的utf8的中文字(表示該中文為由3個字節所組成的utf8中文字)，找下一個中文字
            $i += 2;
        } elseif ($sbit > 239 && $sbit < 248) {
            //第一字節為落於240~247的utf8的中文字(表示該中文為由4個字節所組成的utf8中文字)，找下一個中文字
            $i += 3;
        } else {
            //第一字節為非的utf8的中文字
            return 0;
        }
    }
    //檢查完整個字串都沒問體，代表這個字串是utf8中文字
    return 1;
}

//字串轉HTML16編碼輸出
//參數1-輸入編碼,參數2變數,參數3為英文是否轉換1為轉預設不轉
function nochaoscode($encode, $str, $isbail = false)
{
    $str = iconv($encode, "utf-16", $str);
    for ($i = 0; $i < strlen($str); $i++, $i++) {
        $code = ord($str{$i}) * 256 + ord($str{$i + 1});
        if ($code < 128 and !$isbail) {
            $output .= chr($code);
        } else if ($code != 65279) {
            $output .= "&#" . $code . ";";
        }
    }
    return $output;
}

//代入時間-和現在時間相比差多久
//小於3600秒以分為單位，小於86400以小時為單位，大於等於86400秒以天為單位
function timego($date)
{

    $a = time() - strtotime($date);
    if ($a > 2592000) {
        $b = floor($a / 2592000);
        return $b . "月前";
    } else if ($a > 604800) {
        $b = floor($a / 604800);
        return $b . "週前";
    } else if ($a > 86400) {
        $b = floor($a / 86400);
        return $b . "天前";
    } else if ($a > 3600) {
        $b = floor($a / 3600);
        return $b . "小時前";
    } else if ($a > 60) {
        $b = floor($a / 60);
        return $b . "分鐘前";
    } else if ($a > 1) {
        $b = floor($a);
        return $b . "秒前";
    } else {
        return "0秒前";
    }


}

/* 將秒數轉成  x分鐘x秒 這樣的字串
 * @param int $seconds 秒數
 * @return string 未超過1小時 顯示x分鐘x秒 超過1小時 顯示X小時X分
 */
function convertSeconds($seconds)
{
    $seconds = (int)abs($seconds);

    $point_string = "";
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds %= 60;

    if ($hours != 0)
        $point_string .= $hours . '小時';

    //有超過1小時就不顯示分秒
    if ($hours < 1) {

        if ($minutes != 0)
            $point_string .= $minutes . '分鐘';
        else if ($point_string != "")
            $point_string .= '0分鐘';


        //有超過分就不顯秒
        if ($minutes < 1) {

            if ($seconds != 0)
                $point_string .= $seconds . '秒';
            else if ($point_string != "")
                $point_string .= '0秒';
        }

    }

    if ($point_string == "")
        $point_string = "0秒";
    return $point_string;
}


//排序函式-有下排序條件頁數就歸零
function ppp2($sale1, $title)
{
    global $pageURL2, $sale; //全域變數宣告 $sale1=變數  $title=項目文字
    $_file1 = $pageURL2;
    if ($sale == $sale1) {
        $_A = '<a class="list_desc_on" title="日前依' . $title . '遞減排序" href=' . $_file1 . 'sale=' . $sale1 . 'B>' . $title . '</a><span class="order_flag">▼</span>';
    } else if ($sale == $sale1 . "B") {
        $_A = '<a class="list_asc_on" title="日前依' . $title . '遞增排序" href=' . $_file1 . 'sale=' . $sale1 . '>' . $title . '</a><span class="order_flag">▲</span>';
    } else {
        $_A = '<a class="list_desc" title="依' . $title . '遞增排序" href=' . $_file1 . 'sale=' . $sale1 . 'B>' . $title . '</a>';//預設
    }
    return $_A;
}

//分頁選單用的-修正過20130727============================================================================
//參數 $type=0 頁數全顯，type=1頁數大於40個會只顯示頭尾10號和中間
function PageCount($type = 0)
{
//全域變數宣告，總頁數，目前頁，網址參數
    global $ALL_PAGE, $iPage, $pageURL;

    if ($type) {
        //當頁碼過大時 顯示前10 後10和中間20 最多40個頁碼
        if ($ALL_PAGE >= 40) {
            $y = 10;
            $yc = floor($ALL_PAGE / 2) - 5;
            $yend = ($ALL_PAGE - 10);
        }
    }
    for ($i = 1; $i <= $ALL_PAGE; $i++) {
        $selected = ($i == $iPage) ? "selected" : "";
        $scr .= "<option value=" . $pageURL . "page=" . $i . "  " . $selected . " >" . $i . "</option>";
        if ($y) {
            if ($i == $y) {
                $scr .= "<option value=\"#\" >...</option>";
                $i = $yc;
            }
            if ($i > $yc)
                $zz++;
            if ($zz == 10) {
                $scr .= "<option value=\"#\" >...</option>";
                $i = $yend;
            }
        }
    }
    return $scr;
}

//以下為分頁用的參數2013/07/27--------------------------------------------------------
//參數$ALL_PAGE＝總分頁數,$iPage=目前,$PageCount 是否關掉快速跳頁頁,$kk=1一頁最多顯示多少號碼一定要奇數不能偶數
//global參數 $pageURL=本頁網址
function page_1234($ALL_PAGE, $iPage, $pageCount = 1, $kk = 11)
{
    global $pageURL;
    if (empty($ALL_PAGE)) {
        $data_txt = "<div  style=\"position: absolute;top: 10px;left:50%;\" >抱歉!查無資料</div>";
    }
    //總頁數大於1頁才顯示
    if ($ALL_PAGE > 1) {
//跳頁鈕
        if ($pageCount) {
            $jump_menu = '<select name="select2"   onchange="window.location.href=this.options[this.selectedIndex].value;">';
            $jump_menu .= PageCount(1);//跳頁
            $jump_menu .= '</select>';
        }

//有資料開始	
        $data_txt = "<DIV id='pagenum' class='blueott' >";
        if ($kk % 2) {
            //一頁最多顯示多少號碼如果是偶數就+1改為奇數
        } else {
            $kk = $kk + 1;
        }
        $kl = intval(floor(($kk - 1) / 2));//一頁最多顯示多少號碼一定要奇數不能偶數
        $kr = $kl;
        if (empty($iPage))
            $iPage = 1;//預設在第1頁
//分頁功能開始
        if ($ALL_PAGE <= $kk) {
            //總頁數小於-一頁要顯示的號碼
            $k_start = 1;//起始數
            $k_end = $ALL_PAGE;//結尾數
        } else if ($iPage >= ($ALL_PAGE - $kr)) {
            //目前頁-座落在頁尾範圍
            $k_start = $ALL_PAGE - $kk + 1;
            $k_end = $ALL_PAGE;//結尾數
        } else if ($iPage <= $kl) {
            //目前頁-座落在頁頭範圍
            $k_start = 1;
            $k_end = $kk;
        } else {
            //目前頁-在其他範圍
            $k_start = $iPage - $kl;
            $k_end = $iPage + $kr;//要顯示的頁尾數
        }
        //首頁
        //如果目前頁看不道第一頁 開頭多顯示...
        if ($iPage > $kl + 1) {
            $data_txt .= "<a href='" . $pageURL . "page=1" . $_to_a . "'>第1頁</a>";//顯示頁數
        }
        //目前大於第1頁就顯示上一頁
        if ($iPage > 1) {
            $data_txt .= "<a href='" . $pageURL . "page=" . ($iPage - 1) . $_to_a . "' class='prev' >上一頁</a>";
            $last_url = $pageURL . "page=" . ($iPage - 1);//大的上一頁!!!!!!!
        }
        //多少號碼換號
        for ($i = $k_start; $i <= $k_end; $i++) {
            if (($i) == $iPage) {
                $data_txt .= "<span class='PageButton2'>" . ($i) . "</span>";//頁數在目前頁換樣式
            } else {
                $data_txt .= "<a href='" . $pageURL . "page=" . ($i) . $_to_a . "'>" . ($i) . "</a>";//顯示頁數
            }
        }
//判斷目前的頁數是否是最末頁
//小於最末頁就顯示下一頁和最末頁
        if ($iPage < $ALL_PAGE) {
            $data_txt .= "<a href='" . $pageURL . "page=" . ($iPage + 1) . $_to_a . "' class='next' >下一頁</a>";
            $next_url = $pageURL . "page=" . ($iPage + 1);//大的下一頁!!!!!!!
        }
//頁尾要總頁數大於設定
        if ($iPage < $ALL_PAGE && $ALL_PAGE > $kk) {
            $data_txt .= "<a href='" . $pageURL . "page=" . $ALL_PAGE . $_to_a . ")'>尾頁</a>";
        }
        //顯示頁數
        $data_txt .= "&nbsp; <font size=\"2\" > 共</font>";//2位數和1位數顯示距離差很大
        //總頁數大於3頁才出現
        if ($ALL_PAGE >= 4) {
            if ($pageCount) {
                $data_txt .= $jump_menu . "/" . $ALL_PAGE;//跳頁
            } else {
                $data_txt .= $ALL_PAGE;//跳頁
            }
        } else {
            $data_txt .= " " . $ALL_PAGE;
        }
        $data_txt .= "<font size=\"2\" > 頁</font></DIV>";
    }
    return $data_txt;
}

//顯示頁數END==================================================

/*
-----------------------------------------------------
資料表打註解原則
:前表示 表中文名
:後表示 表用途 (沒有也可以)
『#』號後都是註解，且之後『#』號表示換行 (沒有也可以)
------------------------------------------------------
範例1
	產品分類表
範例2
	產品分類表#主鍵：category_id
範例2
	產品分類表：用於商品的多級分類#主鍵：category_id
範例3
	產品分類表：用於商品的多級分類#主鍵：category_id#備註第2行#備註第3行
------------------------------------------------------
*/
//切割表註解 //參數英文名和註解
function cut_annotations($TABLE_NAME, $TABLE_COMMENT)
{
    $TABLE_COMMENT = str_replace("：", ":", $TABLE_COMMENT); //替換字串-統一:字串
    $TABLE_COMMENT2 = ''; //第2行字

    //沒有:時的規則 以#做為切割
    if (preg_match("@#@", $TABLE_COMMENT)) {
        $TABLE_COMMENT1 = substr($TABLE_COMMENT, 0, stripos($TABLE_COMMENT, "#")); //切出#前的字
        $TABLE_COMMENT2 = substr($TABLE_COMMENT, stripos($TABLE_COMMENT, "#") + 1); //切出:後的字
    } else {
        $TABLE_COMMENT1 = $TABLE_COMMENT;
    }
    //如果文字中有:號
    if (preg_match("@:@", $TABLE_COMMENT1)) {
        $b1 = substr($TABLE_COMMENT1, 0, stripos($TABLE_COMMENT1, ":")); //切出:前的字
        $b2 = substr($TABLE_COMMENT1, stripos($TABLE_COMMENT1, ":") + 1); //切出:後的字
        $TABLE_COMMENT1 = $b1;
        if ($TABLE_COMMENT2) {
            $TABLE_COMMENT2 = $b2 . "#" . $TABLE_COMMENT2;//把字用到地2行後
        } else {
            $TABLE_COMMENT2 = $b2;
        }
    }

    //重整出 標題名
    $tablesB['TABLE_NAME'] = $TABLE_NAME; //放表英文名
    $tablesB['TABLE_COMMENT1'] = $TABLE_COMMENT1; //中文
    $tablesB['TABLE_COMMENT2'] = $TABLE_COMMENT2; //註解
    /*
    註解切割完畢
    */
    return $tablesB;
}

//重複程式碼
//參數$html,$tablesB=有放註解的數組,$k=第幾個,$v=表的各欄值,$editok=1編輯開關
//全域要載入global $lang_columntype;//翻譯文字
function combination_of_content($html,$tablesB,$k,$v,$editok){
global $lang_columntype,$lang;//翻譯文字
        $bn="\n";
	    $TABLE_NAME = $tablesB['TABLE_NAME'][$k];//表英文名修改後
   		//顯示第1行字標題
        $html .= '<a name="' . $TABLE_NAME . '" id="' . $TABLE_NAME . '">'; //id
        $html .= '</a>'; //id
        $html .= '<h2>';//標題
        //只有1個的話，就沒有數字編號	
        	if(count($tablesB[ 'TABLE_NAME' ])>1){
        	$html .=($k + 1) . '、'	;
			}
        $html .= $tablesB['TABLE_COMMENT1'][$k] . '  （<span class="cr">' . $TABLE_NAME . '</span>）</h2>' .$bn; //標題
        //顯示第2行字註解
        if ($tablesB['TABLE_COMMENT2'][$k]) {
            $html .= '<div><h3>';
            $html .= str_replace("#", "<br>\n", $tablesB['TABLE_COMMENT2'][$k]); //替換換行字串
            $html .= '</h3></div>';
        }

        $html .= '<table border="1" cellspacing="0" cellpadding="0" width="100%" class="table table-striped table-bordered" >' .$bn;
        $html .= '		<tbody>' .$bn;
        $html .= '			<tr>' .$bn;
        $html .= '				<th>字段名</th>' .$bn;
        $html .= '				<th>數據類型</th>' .$bn;
        $html .= '				<th>數據類型</th>' .$bn;
        $html .= '				<th>長度</th>' .$bn;
        $html .= '				<th>屬性</th>' .$bn;
        $html .= '				<th>默認值</th>' .$bn;
        $html .= '				<th>允許非空</th>' .$bn;
        $html .= '				<th>主鍵</th>' .$bn;
        $html .= '				<th>備註</th>' .$bn;
            if($editok){
            $html .= '				<th class="w50px">編輯</th>' .$bn;
            }
        $html .= '			</tr>' .$bn;
        //表的值COLUMN
        foreach ($v['COLUMN'] as $f) {
            $html .= '			<tr class="csssssss">' .$bn;
            $html .= '				<td class="c1">' . $f['COLUMN_NAME'] . '</td>' .$bn;
            $html .= '				<td class="c2">' . _lang($f['DATA_TYPE'], $lang_columntype) . '</td>' .$bn;
            $html .= '				<td class="c0c">' . $f['DATA_TYPE'] . '</td>' .$bn;
                //主鍵
                $kkkkk=$f['COLUMN_KEY'] . ($f['EXTRA'] == 'auto_increment' ? '+自增' : '&nbsp;') ;
                //屬性
                if(preg_match("@ZEROFILL@i", $f['COLUMN_TYPE'])){
                $sssss=_lang("unsignedzerofill",$lang);
                }elseif(preg_match("@unsigned@i", $f['COLUMN_TYPE'])){
                $sssss=_lang("unsigned",$lang);
                }elseif(preg_match("@binary@i", $f['COLUMN_TYPE'])){
                $sssss=_lang("binary",$lang);
                }else{
                $sssss="";    
                }
            //長度
            $LENGTH = "";
            if ($f['NUMERIC_PRECISION']) {
                $LENGTH = $f['NUMERIC_PRECISION'];
            } else {
                if ($f['CHARACTER_OCTET_LENGTH']) {
                    $LENGTH = $f['CHARACTER_OCTET_LENGTH'];
                }
            }
            $html .= '				<td class="c0c">' . $LENGTH . '</td>' .$bn;
            $html .= '				<td class="c0c">' . $sssss . '</td>' .$bn;
            $html .= '				<td class="c0c">' . $f['COLUMN_DEFAULT'] . '</td>' .$bn;
            $html .= '				<td class="c0c">' . $f['IS_NULLABLE'] . '</td>' .$bn;
            $html .= '				<td class="c5">' . $kkkkk . '</td>' .$bn;
            if($editok){
            //編輯**************************************************************************************
            $cid="gyit_".$tablesB['TABLE_NAME0'][$k].$f['COLUMN_NAME'];//ID名規則 //放表英文名未取代字串前+欄位名
                $html .= "<td><textarea class=\"w100 h100\" name=\"edit_text\" rows=\"1\" id=\"".$cid."\">" . $f['COLUMN_COMMENT'] . "</textarea></td>" . $bn;//修改
                $html .= '<td>';
                $html .= '<button type="button" class="btn5 w50px" data-container="body"  data-placement="right" id="b'.$cid.'" onclick="javascript:edit_im(\''.$tablesB['TABLE_NAME0'][$k].'\',\''.$f['COLUMN_NAME'].'\',\''.$cid.'\')">修改</button>';
                $html .= '</td>' . $bn;//修改按鈕END
            }else{
                $html .= '				<td class="c6">' . $f['COLUMN_COMMENT'] . '</td>' .$bn;//不編輯
            }
            //編輯END**************************************************************************************
            $html .= '			</tr>' .$bn;
        }
        $html .= '		</tbody>' .$bn;
        $html .= '	</table>' .$bn;
        return $html;
}
?>
