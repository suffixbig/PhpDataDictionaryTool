<?php
$thisDir = ".";      //config.inc.php檔的相對路徑
$_file = basename(__FILE__);  //自行取得本程式名稱
require($thisDir . "/config.php"); // 載入主參數設定檔
//==========================================================================
require_once INCLUDE_PATH . "/inc_password_admin.php"; // 載入管理員密碼驗證
//==========================================================================
require_once INCLUDE_PATH . "/mysql.inc.php"; // 載入資料庫函式
require_once INCLUDE_PATH . "/global_suffix.php"; // 載入資料庫函式
/* * ******************************************************************************************** */
$i_my = '後台';
/* * ******************************************************************************************** */
$linkID = omysql($CT_CONFIG['db_name']); //開資料庫================================================
$db_name = $CT_CONFIG['db_name'].'.`dir_client`'; //資料表名稱
	
$sql = "SELECT * FROM " . $db_name . " WHERE `del_date` IS NULL ORDER BY `sno` ASC"; //查詢資料
$data = assoc_sql($sql, $linkID); //單行
//print_r($data);
cmysql($linkID); //關資料庫==============================================================    
/* * ******************************************************************************************** */
$tab_name = array('sno' => '序號', 'name' => '客戶名稱', 'password' => '密碼', 'dir' => '目錄', 'adddate' => '新增時間');
?>

<?php
require('_inc/inc_head.php');   //載入表頭
?>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="skin/js/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- 可選的Bootstrap主題文件（一般不用引入） 
<link rel="stylesheet" href="/skin/js/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
<!-- 本頁專用 -->
<link href="skin/css/admin.css" rel="stylesheet">
</head>
<style>
.info th{text-align:center;}
</style>
<body>

    <br>
    <h1></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12" align="center">
                <div class="background01">
                    <H2>系統後台 <a href="edit.php?type=news" class="btn btn-danger">新增資料</a> <a href="/loginok2.php?type=del">登出</a></H2>             
                </div>
            </div></div><!--./row./col-md-12--> 
    </div><!--./container-->    
<br>
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <!--响应式表格-->         
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="info">
                                <?php
                                foreach ($tab_name as $key => $v) {
                                    if($key=='dir'){
                                    echo "<th>" . $v . "</th>";    
                                    echo "<th>目錄檢查</th>";
                                    }else{
                                    echo "<th>" . $v . "</th>";
                                    }
                                }
                                ?>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($data); $i++) {
                                $a = $data[$i];
                                $sno = $a['sno'];
                                /* 	
                                  [sno] => 3
                                  [name] => 測試客戶2
                                  [password] => 56789
                                  [dir] => user_02
                                  [adddate] => 2017-03-22 16:39:05
                                  [del_date] =>
                                 */
                                $del = "send.php?type=del&sno=" . $sno;
                                $edit = "edit.php?type=edit&sno=" . $sno;
                                ?>
                                <tr>
                                    <?php
                                    foreach ($tab_name as $key => $v) {
                                        if($key=='dir'){
                                        echo "<td><a href=\"/". $a[$key] ."\">".$a[$key]."</a></td>";//目錄這欄
                                            if(is_dir($a['dir'])){
                                               echo "<td align=\"center\">有</td>"; 
                                            }else{
                                               echo "<td align=\"center\">否</td>"; 
                                            }
                                        
                                        }else{
                                        echo "<td>" . $a[$key] . "</td>";
                                        }
                                    }
                                    ?>
                                    <td align="center"><a href="<?= $del ?>">刪除</a> | <a href="<?= $edit ?>">修改</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


            </div></div><!--./row./col-md-12--> 
    </div><!--./container-->    
    <?php
    require('_inc/inc_footer_s.php');   //載入表尾
    ?>    
</body>
</html>