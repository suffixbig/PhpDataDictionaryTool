<?php
$thisDir = "..";                        //config.inc.php檔的相對路徑
$_file = basename(__FILE__);        //自行取得本程式名稱
require($thisDir."/config.inc.php");    // 載入主參數設定檔
require(INCLUDE_PATH."/inc_password.php");  // 載入密碼登入系統
require($thisDir."/config.inc.mysql.php" ); //載入資料庫帳號設定檔
require_once INCLUDE_PATH."/mysql.inc.php";     // 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";     // 載入資料庫函式
/***********************************************************************************************/
$bn = "\n";
/***********************************************************************************************/
if (empty($_GET['database'])) {
    echo "缺少database參數";exit;
} else {
    $database=$_GET['database'];
}

if (isset($_GET['prefix'])) {
    $prefix = $_GET['prefix'];
} else {
    $prefix = "";
}

$etitokdiv=0;
//是否可編輯
if (!empty($_GET['etitokdiv'])){
    $etitokdiv=$_GET['etitokdiv'];
}

$db = new Api_mysqli;
$dblink = $db->mysql_open(); //開資料庫連線================================================
//mysql_list_dbs --- 列出 MySQL 伺服器上可用的資料庫

//===========================================================
    $db->mysqluse($database, $dblink); //切換資料庫
//===========================================================
//有指定資料庫 情況 S
if ($database) {
    $sql = 'show tables';
    $tablesaaa = $db->row_sql_a($sql, $dblink);
//過濾不需要顯示的表名
    for ($i = 0; $i < count($tablesaaa); $i++) {
        if (!in_array($tablesaaa[$i], $no_show_databases)) {
            $tables[]['TABLE_NAME'] = $tablesaaa[$i];
        }
    }

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
        $tables[$k]['TABLE_COMMENT'] = $db->row_sql1p($sql, 0, $dblink);
        //取得各表的每一欄註解
        //==============================================================
        $sql = 'SELECT * FROM ';
        $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
        $sql .= 'WHERE ';
        $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

        $fields = $db->assoc_sql($sql, $dblink);
        $tables[$k]['COLUMN'] = $fields; //子表內容
    }
//有指定資料庫 情況 END
}
$db->mysql_close($dblink); //關資料庫==============================================================
/***********************************************************************************************/

$html = ''; //循環所有表
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
        $tablesB['TABLE_NAME0'][] = $v['TABLE_NAME']; //放表英文名未取代字串前
        $tablesB['TABLE_NAME'][] = $b['TABLE_NAME']; //放表英文名
        $tablesB['TABLE_COMMENT1'][] = $b['TABLE_COMMENT1']; //中文
        $tablesB['TABLE_COMMENT2'][] = $b['TABLE_COMMENT2']; //註解
        $tablesB['TABLE_COMMENT0'][] = $v['TABLE_COMMENT']; //註解 為拆解前
    }
    foreach ($tables as $k => $v) {
        //重複程式碼
        //參數$html,$tablesB=有放註解的數組,$k=第幾個,$v=表的各欄值,$editok=1編輯開關
        $html = combination_of_content($html, $tablesB, $k, $v, 0);
    }
//有指定資料庫 情況 END
}




if($etitokdiv){
//===========================================================
//可編輯
//===========================================================
echo '
<!--響應式表格-->
<div class="generallist">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="info2">
                    <th class="sno">序號</th>
                    <th>表名</th>
                    <th>別人打的</th>
                    <th>自己打的</th>
                    <th class="w50px">修改</th>
                </tr>
            </thead>
            <tbody>';
//列出所有表
$c1 = $tablesB['TABLE_NAME'];
$c2 = $tablesB['TABLE_COMMENT0']; //註解
for ($i = 0; $i < count($c1); $i++) {
$cid = "edit_" . $tablesB['TABLE_NAME0'][$i]; //用原來的名 ID的規則是不能有點
echo "<tr class=\"csssssss\">" . $bn;
echo "<td class=\"cc\">" . ($i + 1) . "</td>" . $bn;
echo "<td><a class=\"page-scroll\" href=\"#" . $c1[$i] . "\">" . $c1[$i] . "</a></td>" . $bn;
echo "<td class=\"c4\">" . _lang($c1[$i], $lang_tablenames) . "</td>" . $bn;
echo "<td><textarea class=\"w100 h100\" name=\"edit_text\" rows=\"1\" id=\"" . $cid . "\">" . $c2[$i] . "</textarea></td>" . $bn; //修改
echo '<td>';
echo '<button type="button" class="btn5 w50px" data-container="body" data-toggle="popover" data-placement="right" id="b' . $cid . '">修改</button>';
echo '</td>' . $bn; //修改按鈕END
echo "</tr>" . $bn;
}
echo '
            </tbody>
        </table>
    </div>
</div>
';
echo "</div><!--/.generallist-->\n";
echo "<script>\n";
echo "$(function() {\n";
echo '
        //工具提示啟用
        $("[data-toggle=\'popover\']").popover({
            html: true,
            content: function(e) {
                var s = $(this).attr(\'id\');
                return \'<div id="popoverid_\' + s + \'">儲存中...</div>\';
            }
        });
        //var storage_status=0;
        //監測
        $("[data-toggle=\'popover\']").on(\'shown.bs.popover\', function(e) {
            //if (storage_status==0){
            var gid2 = e.currentTarget.id;
            var gid3 = gid2.replace(/\./g, "\\."); //如果欄位名中有.這樣可以讓他正常
            var gid = gid3.substring(6); //截短6個字
            var name = \'#\' + gid3.substring(1);
            var edittext = $(name).val();
            if (edittext == undefined) {
                console.log(\'錯誤\'); //測試使用
            }
            var pdata = new Object();
            pdata.database = \''.$database.'\';
            pdata.tablename = gid2.substring(6); //截短6個字
            pdata.edittext = edittext;
            var el = $(this);
            el.attr(\'disabled\', \'disabled\'); //按鈕禁用
            //console.log( pdata ); //測試使用
            //storage_status++;
            $.post("ajax/goto_edit.php", pdata, function(data) {
                if (data.ok) {
                    //成功 S
                    console.log(data); //測試使用
                    setTimeout(function() {
                        //el.popover("destroy");//銷毀
                        //el.popover("hide");//關掉彈出框
                        //el.popover({content :data.sms});//改內容
                        $("#popoverid_" + gid2).text(data.sms); //改內容
                        setTimeout(function() {
                            el.popover("hide"); //關掉彈出框
                            setTimeout(function() {
                                el.removeAttr("disabled"); //按鈕能用
                                //storage_status=0;//恢復監聽
                            }, 200);
                        }, 500);
                    }, 500);
                    //成功 END
                } else {
                    //失敗
                    //console.log(data.sms); //測試使用
                    //關鍵不能同一時間2個指令
                    setTimeout(function() {
                        $("#popoverid_" + gid2).text(data.sms); //改內容
                        setTimeout(function() {
                            el.popover("hide"); //關掉彈出框
                            setTimeout(function() {
                                el.removeAttr("disabled"); //按鈕能用
                                //storage_status=0;//恢復監聽
                            }, 200);
                        }, 700);
                    }, 500);
                }
            }, "json");
            // }//storage_status if END
        });
    }); //function END
</script>';
}else{
//===========================================================
//不可編輯
//===========================================================
echo '
<!--響應式表格-->
<div class="generallist">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="info2">
                    <th class="sno">序號</th>
                    <th>表名</th>
                    <th>備註</th>
                    <th>備註(自己打的)</th>
                </tr>
            </thead>
            <tbody>';
//列出所有表
$c1 = $tablesB['TABLE_NAME'];
$c2 = $tablesB['TABLE_COMMENT0']; //註解
for ($i = 0; $i < count($c1); $i++) {
$cid = "edit_" . $tablesB['TABLE_NAME0'][$i]; //用原來的名 ID的規則是不能有點
echo "<tr class=\"csssssss\">" . $bn;
echo "<td class=\"cc\">" . ($i + 1) . "</td>" . $bn;
echo "<td><a class=\"page-scroll\" href=\"#" . $c1[$i] . "\">" . $c1[$i] . "</a></td>" . $bn;
echo "<td class=\"c4\">" . _lang($c1[$i], $lang_tablenames) . "</td>" . $bn;
echo "<td>". $c2[$i] . "</td>" . $bn; //修改
echo "</tr>" . $bn;
}
echo '
            </tbody>
        </table>
    </div>
</div>
';
echo '</div><!--/.generallist-->';
/*
echo "<script>\n";
echo "$(function() {\n";
echo '
//連結捲過去有使用jquery-ui
        $("a.page-scroll").bind(\'click\', function (event) {
            var $anchor = $(this);
            $("html, body").stop().animate({
                scrollTop: $($anchor.attr(\'href\')).offset().top
            }, 1500, \'easeInOutExpo\');
            event.preventDefault();
        });
    }); //function END
</script>';
*/
}
?>