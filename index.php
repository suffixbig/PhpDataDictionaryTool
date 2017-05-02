<?php
/*
Create date:2017-04-19
Last update date:2017-04-27
Plugin Name: phpmysqli_dictionary
Plugin URI: http://www.bkk.tw
Description: PHP生成mysql數據庫字典工具 
Version: 1.0.1
Author: david
*/
/*
適用PHP5.4~PHP7.0
*/
?>
<?php
$thisDir = ".";						//config.inc.php檔的相對路徑
$_file = basename(__FILE__);		//自行取得本程式名稱
require($thisDir."/config.inc.php");	// 載入主參數設定檔
require(INCLUDE_PATH."/inc_password.php");	// 載入密碼登入系統
require($thisDir."/config.inc.mysql.php" ); //載入資料庫帳號設定檔
require_once INCLUDE_PATH."/mysql.inc.php";	// 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";	// 載入資料庫函式
/***********************************************************************************************/
$typenamech2=array('全表列出','單表列出','自選列出');
$i_my='後台';
$no_show_databases = array( 'information_schema', 'mysql', 'performance_schema', 'sys' ); //不需要顯示的數據庫
$no_show_table = array(); //不需要顯示的數據表
$_GET[ 'prefix' ] = 'oc_'; //替換所有的表前綴
if (isset( $_GET[ 'prefix' ] )) {
    $prefix = $_GET[ 'prefix' ];
} else {
    $prefix = "";
}
$db_namec='數據/資料庫字典生成工具';
/***********************************************************************************************/
$dblink=_mysql_open();//開資料庫連線================================================
//mysql_list_dbs --- 列出 MySQL 伺服器上可用的資料庫
$sql = 'SHOW DATABASES';
$DATANAME=row_sql_a($sql, $dblink);

//過濾不需要顯示的數據庫
for ($i=0; $i<count($DATANAME); $i++) {
    if (!in_array( $DATANAME[$i], $no_show_databases )) {
        $DATANAME2[] = $DATANAME[$i];
    }
}
$DATANAME=$DATANAME2;
//===========================================================
if(isset($_GET['DATANAME'])){
	$database=$_GET['DATANAME'];	
	mysqluse($dblink,$database);//切換資料庫
}
//===========================================================

$sql='show tables';
$tablesaaa=row_sql_a($sql, $dblink);
//過濾不需要顯示的表名
for ($i=0; $i<count($tablesaaa); $i++) {
    if (!in_array( $tablesaaa[$i], $no_show_databases )) {
        $tables[][ 'TABLE_NAME' ] = $tablesaaa[$i];
    }
}
/*
print_r($tables);//所有的表名
exit;
*/
//如果有參數
//替換所有表的表前綴
if ($prefix) {
    for ($i = 0; $i < count( $tables ); $i++) {
        $a = $tables[ $i ];
        $tables2[][ 'TABLE_NAME' ] = str_replace( $prefix, "", $a[ 'TABLE_NAME' ] ); //替換字串
    }
    //echo "替換表前綴" . $prefix . "替換成功！";
}

//循環取得所有表的備註及表中列消息
foreach ($tables as $k => $v) {
    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.TABLES ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
    $table_result = mysqli_query( $dblink, $sql );
    while ($t = mysqli_fetch_assoc( $table_result )) {
        $tables[ $k ][ 'TABLE_COMMENT' ] = $t[ 'TABLE_COMMENT' ];
    }
    //print_r($sql);

    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

    $fields = array();
    $field_result = mysqli_query( $dblink, $sql );
    while ($t = mysqli_fetch_assoc( $field_result )) {
        $fields[] = $t;
    }
    $tables[ $k ][ 'COLUMN' ] = $fields;
}



_mysql_close($dblink);//關資料庫==============================================================
//print_r($tables);
/***********************************************************************************************/
/*********************************************/
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
foreach ($tables as $k => $v) {
    //如果有替換所有表的表前綴的行為
    if ($prefix) {
        $TABLE_NAME = $tables2[ $k ][ 'TABLE_NAME' ]; //表名
    } else {
        $TABLE_NAME = $v[ 'TABLE_NAME' ];
    }
	
	$b=cut_annotations($TABLE_NAME,$v[ 'TABLE_COMMENT' ]);//參數英文名和註解

    //重整出 標題名
    $tablesB[ 'TABLE_NAME' ][] = $b['TABLE_NAME']; //放表英文名
    $tablesB[ 'TABLE_COMMENT1' ][] = $b['TABLE_COMMENT1']; //中文
    $tablesB[ 'TABLE_COMMENT2' ][] = $b['TABLE_COMMENT2']; //註解
}
/*
註解切割完畢
*/
/*
print_r($tablesB);
exit;
*/

$html = ''; //循環所有表
foreach ($tables as $k => $v) {
    $TABLE_NAME=$tablesB[ 'TABLE_NAME' ][ $k ];
    //顯示第1行字標題
    $html.='<a name="'.$TABLE_NAME.'" id="'.$TABLE_NAME.'">';//id
        $html.='</a>';//id
    $html .= '	<h2>' . ( $k + 1 ) . '、' . $tablesB[ 'TABLE_COMMENT1' ][ $k ] . '  （<span class="cr">' . $TABLE_NAME . '</span>）</h2>' . "\n"; //標題

    //顯示第2行字註解
    if ($tablesB[ 'TABLE_COMMENT2' ][ $k ]) {
        $html .= '<div><h3>';
        $html .= str_replace( "#", "<br>\n", $tablesB[ 'TABLE_COMMENT2' ][ $k ] ); //替換換行字串
        $html .= '</h3></div>';
    }

    $html .= '<table border="1" cellspacing="0" cellpadding="0" width="100%" class="table table-striped table-bordered" >' . "\n";
    $html .= '		<tbody>' . "\n";
    $html .= '			<tr>' . "\n";
    $html .= '				<th>字段名</th>' . "\n";
    $html .= '				<th>數據類型</th>' . "\n";
    $html .= '				<th>數據類型</th>' . "\n";
    $html .= '				<th>長度</th>' . "\n";
    $html .= '				<th>默認值</th>' . "\n";
    $html .= '				<th>允許非空</th>' . "\n";
    $html .= '				<th>主鍵</th>' . "\n";
    $html .= '				<th>備註</th>' . "\n";
    $html .= '			</tr>' . "\n";
    //表的值COLUMN
    foreach ($v[ 'COLUMN' ] as $f) {
        $html .= '			<tr>' . "\n";
        $html .= '				<td class="c1">' . $f[ 'COLUMN_NAME' ] . '</td>' . "\n";
        $html .= '				<td class="c2">' . _lang( $f[ 'DATA_TYPE' ], $lang_columntype ) . '</td>' . "\n";
        $html .= '				<td class="c0c">' . $f[ 'DATA_TYPE' ] . '</td>' . "\n";
        //長度
        $LENGTH = "";
        if ($f[ 'NUMERIC_PRECISION' ]) {
            $LENGTH = $f[ 'NUMERIC_PRECISION' ];
        } else {
            if ($f[ 'CHARACTER_OCTET_LENGTH' ]) {
                $LENGTH = $f[ 'CHARACTER_OCTET_LENGTH' ];
            }
        }
        $html .= '				<td class="c0c">' . $LENGTH . '</td>' . "\n";
        $html .= '				<td class="c0c">' . $f[ 'COLUMN_DEFAULT' ] . '</td>' . "\n";
        $html .= '				<td class="c0c">' . $f[ 'IS_NULLABLE' ] . '</td>' . "\n";
        $html .= '				<td class="c5">' . $f[ 'COLUMN_KEY' ] . ( $f[ 'EXTRA' ] == 'auto_increment' ? '+自增' : '&nbsp;' ) . '</td>' . "\n";
        $html .= '				<td class="c6">' . $f[ 'COLUMN_COMMENT' ] . '</td>' . "\n";
        $html .= '			</tr>' . "\n";
    }
    $html .= '		</tbody>' . "\n";
    $html .= '	</table>' . "\n";
}


/*
print_r($tablesB);	
exit;
*/

require(INCLUDE_PATH.'/inc_head.php');   //載入表頭
?>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="skin/js/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- 可選的Bootstrap主題文件（一般不用引入） 
<link rel="stylesheet" href="/skin/js/bootstrap/3.3.7/css/bootstrap-theme.min.css">-->

<!-- 本頁專用 -->
<link href="skin/css/admin.css" rel="stylesheet">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">





<!--下拉跳網址 S-->
<div align="center">
<h3><select name="goto_url">
  <option value="" selected>選擇資料庫</option>
	<?php
	for($i=0;$i<count($DATANAME);$i++){
		if($database==$DATANAME[$i])
		$selected="selected=\"selected\"";
		else
		$selected="";
		echo "<option value=\"".$_file."?DATANAME=".$DATANAME[$i]."\" ".$selected." >".$DATANAME[$i]."</option>";
	}
	?>
</select></h3>
</div>
<!--下拉跳網址 END-->


<!-- 標題區 -->
<div class="title-block">
<h1 class="text_shadow"><?=$db_namec?></h1>
</div>

    
    
<!--PC頁簽區hidden-xs--> 
<div class="tab_memu">
  <ul class="nav nav-tabs" role="tablist">
<?php
for($i=0;$i<count($typenamech2);$i++){
//預設顯示3類中哪一類
if($i < 1)
$in='class="active"';
else
$in="";
$key=$i+1;
    echo '<li role="presentation" '.$in.'><a href="#home'.$key.'" data-toggle="tab" role="tab" aria-controls="tab'.$key.'"  onclick="cookie_intype('.$key.');">'.$typenamech2[$i].'</a></li>';
}
?>
  </ul>
</div>
<!--PC頁簽區END-->  
<div class="w100 height10"><!--間距--></div>  



<div id="tabContent1" class="tab-content"><!--DIV切換區 S-->  





<!--第1區END-->
<div role="tabpanel" class="tab-pane fade in active" id="home1"><!--預設選中-->
<div class="container">
<div class="row">
<div class="col-md-12">   

<!--第1區 內容 S-->

    <h1 style="text-align:center;"><?=$database?> 數據庫字典</h1>
    <hr>
<!--響應式表格-->
<div class="generallist" >     
<div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr class="info2">
                    <th class="sno">序號</td>
                    <th>表名</td>
                    <th>別人打的</td>
                    <th>我打的</td>
                    <th>用途備註</td>
           </tr>
        </thead>
        <tbody>
<?php
//列出所有表
$bn="\n";
$c1=$tablesB[ 'TABLE_NAME' ];
$c2=$tablesB[ 'TABLE_COMMENT1' ];
$c3=$tablesB[ 'TABLE_COMMENT2' ];//註解
for ($i=0; $i<count($c1); $i++) {
    echo "<tr>".$bn;
        echo "<td class=\"cc\">".($i+1)."</td>".$bn;
        echo "<td><a class=\"page-scroll\" href=\"#".$c1[$i]."\">".$c1[$i]."</a></td>".$bn;
        echo "<td class=\"c4\">"._lang($c1[$i], $lang_tablenames)."</td>".$bn;
        echo "<td>".$c2[$i]."</td>".$bn;
        echo "<td>".$c3[$i]."</td>".$bn;
    echo "</tr>".$bn;
}
?>  
        </tbody>
      </table>
</div></div>
<hr>

<div class="warp">
        <?php echo $html; ?>
</div>


</div></div><!--./row./col-md-12--> 
</div><!--./container--> 
</div><!--./home1--> 
<!--第1區END-->
<!------------------------------------------------------------------------------->
<!--第2區開始-->
<div role="tabpanel" class="tab-pane fade" id="home2">   
<div class="container">
<div class="row">
<div class="col-md-12">   
  
  
    <!--下拉跳資料表 S-->
    <div align="center">
    <h3><select name="goto_datasheet">
      <option value="" selected>選擇資料表</option>
        <?php
		$b2=$tablesB['TABLE_NAME'];
        foreach ($b2 as $k => $v) {
            $selected="";
            echo "<option value=\"".$prefix.$v."\" ".$selected." >".$v."</option>";
        }
        ?>
    </select></h3>
    </div>
    <!--下拉跳網址 END-->
    <hr>
    <div id="div_home2"></div>

  
</div></div><!--./row./col-md-12--> 
</div><!--./container--> 
</div><!--./home2-->
<!--第2區END-->
<!------------------------------------------------------------------------------->
<!--第3區開始-->
<div role="tabpanel" class="tab-pane fade" id="home3">   
<div class="container">
<div class="row">
<div class="col-md-12">
  <button id="zero">歸零</button>
  <button id="btn">顯示數據</button>
  <br/>
  <div id="svg123"></div>
</div></div><!--./row./col-md-12--> 
</div><!--./container--> 
</div><!--./home2-->
<!------------------------------------------------------------------------------->
</div><!--/tabContent1 DIV切換區 END-->


<div class="w100 height10"><!--間距--></div> 
<?php
require('_inc/inc_footer_s.php');   //載入表尾
?>
<script src="skin/js/jquery.cookie.min.js" type="text/javascript"></script>
<!--jqueryui-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <style>
    button{
      font-size:20px;
      margin:20px 0 20px 10px;
    }
  </style>
<script type="text/javascript">
//重整
function locationabc(){
 location.reload(true);
}
//把選項記憶一天
function cookie_intype($s){
 $.cookie('im_type_ad', $s, { path:'/', expires: 10}); 
}
function cookie_insale($s){
 $.cookie('sale', $s, { path:'/', expires: 10}); 
 locationabc(); 
}

$(function() {

 //連結捲過去有使用jquery-ui
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
// 綁定下拉式選項跳頁
// 如果jQuery版本是 < 1.7, 取代 on 使用 bind
    $('select[name="goto_url"]').on('change', function () {
    var url = $(this).val(); // get selected value
    if (url) {
        window.location = url; // redirect
    }
    return false;
    });	
// 下拉選單
    $('select[name="goto_datasheet"]').on('change', function () {
    var url = $(this).val(); // get selected value
    if (url) {
        //window.location = url; // redirect
		$("#div_home2").load("goto_datasheet.php?database=<?=$database?>&tablename="+url);
		

    }
    return false;
    });		
	
});
</script>  
</body>
</html>