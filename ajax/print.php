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

$tempfile="../_save/save_database.txt";//暫存檔名
$data = @file_get_contents($tempfile);//讀取緩存檔案
$json=json_decode($data,true);


$database=$json['database'];
$prefix=$json['prefix'];
$idall=$json['idall'];

$powerswitch='b';

$html = ''; //循環所有表
   //===========================================================
    //顯示全部資料表 且可編輯
    //===========================================================
    $db = new Api_mysqli;
    $dblink = $db->mysql_open(); //開資料庫連線================================================
    $db->mysqluse($database,$dblink); //切換資料庫
    //===========================================================
    //有指定資料庫 情況 S
    if ($database) {
        $sql = 'show tables';
        $tablesaaa = $db->row_sql_a($sql, $dblink);

    //過濾需要顯示的表名********************************************************************
        for ($i = 0; $i < count($tablesaaa); $i++) {
            if (in_array($tablesaaa[$i],$idall )) {
                $tables[]['TABLE_NAME'] = $tablesaaa[$i];
            }
        }
    //過濾需要顯示的表名END*****************************************************************


    //如果有參數//替換所有表的表前綴
        if ($prefix) {
            for ($i = 0; $i < count($tables); $i++) {
                $a = $tables[$i];
                $tables2[]['TABLE_NAME'] = str_replace($prefix, "", $a['TABLE_NAME']); //替換字串
            }
            //echo "替換表前綴" . $prefix . "替換成功！";
        }
        
    //循環取得所有表的備註及表中列消息
        foreach ($tables as $k => $v) {
            //取得各表註解
            $sql = 'SELECT TABLE_COMMENT FROM ';
            $sql .= 'INFORMATION_SCHEMA.TABLES ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
            $tables[$k]['TABLE_COMMENT'] =$db->row_sql1p($sql, 0, $dblink);
            //取得各表的每一欄註解
            //==============================================================
            $sql = 'SELECT * FROM ';
            $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

            $fields = $db->assoc_sql($sql, $dblink);
            $tables[$k]['COLUMN'] = $fields;//子表內容
        }
    //有指定資料庫 情況 END
    }
    $db->mysql_close($dblink); //關資料庫==============================================================
    /***********************************************************************************************/
    
    //header('Access-Control-Allow-Origin:*');// 添加這行，允許跨網域!!
    //header('Access-Control-Allow-Origin:http://localhost'); //那就只限制當發生跨網域行為時，只有從本機發出請求才允許。
    echo "<html>";
    //有指定資料庫 情況 S
    if ($database) {
        foreach ($tables as $k => $v) {
            //如果有替換所有表的表前綴的行為
            if ($prefix) {
                $TABLE_NAME = $tables2[$k]['TABLE_NAME']; //表名
            } else {
                $TABLE_NAME = $v['TABLE_NAME'];
            }
            $b = cut_annotations($TABLE_NAME, $v['TABLE_COMMENT']); //參數英文名和註解
            //重整出 標題名
            $tablesB['TABLE_NAME0'][] = $v['TABLE_NAME'];   //放表英文名未取代字串前
            $tablesB['TABLE_NAME'][] =  $b['TABLE_NAME'];   //放表英文名
            $tablesB['TABLE_COMMENT1'][] = $b['TABLE_COMMENT1']; //中文
            $tablesB['TABLE_COMMENT2'][] = $b['TABLE_COMMENT2']; //註解
            $tablesB['TABLE_COMMENT0'][] = $v['TABLE_COMMENT']; //註解 為拆解前
        }
        foreach ($tables as $k => $v) {
            //重複程式碼
            $editok=0;//全顯不可編輯
            if($powerswitch=='a')
            $editok=1;//全顯可編輯
            //參數$html,$tablesB=有放註解的數組,$k=第幾個,$v=表的各欄值,$editok=1編輯開關
            $html=combination_of_content($html, $tablesB, $k, $v,$editok);
        }
    //有指定資料庫 情況 END
    }
    echo '<div class="warp">';
    echo $html;
    echo '</div>';