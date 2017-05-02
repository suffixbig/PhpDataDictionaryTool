<?php
$thisDir = ".";						//config.inc.php檔的相對路徑
$_file = basename(__FILE__);		//自行取得本程式名稱
require($thisDir."/config.php");	// 載入主參數設定檔
require_once INCLUDE_PATH."/mysql.inc.php";	// 載入資料庫函式
require_once INCLUDE_PATH."/global_suffix.php";	// 載入資料庫函式
/***********************************************************************************************/
$i_my='登入';
/***********************************************************************************************/
/***********************************************************************************************/		
?>
<?php
require('_inc/inc_head.php');   //載入表頭
?>
<!-- 本頁專用 -->
<!-- 英文字體 -->
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine|Rancho|Source+Sans+Pro:900&effect=3d|3d-float|anaglyph|brick-sign|canvas-print|crackle|decaying|destruction|distressed|distressed-wood|emboss|fire|fire-animation|fragile|grass|ice|mitosis|neon|outline|putting-green|scuffed-steel|shadow-multiple|splintered|static|stonewash|vintage|wallpaper" />
<!-- 動態字體一套 -->
<link href="/css?type=5" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
html{font-size:120%;}
/*預設字體 字距不使用%換自動換行時會出問題*/
*{font-size:1.2rem;line-height:120%;}
body {
    height:100%;
	width:100%
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;	
}
table, th, td {
	border: 1px solid #D4E0EE;
	border-collapse: collapse;
	font-family: "Trebuchet MS", Arial, sans-serif;
	color: #555;
}
caption {
	font-size: 150%;
	font-weight: bold;
	margin: 5px;
}
td, th {
	padding: 4px;
}
thead th {
	text-align: center;
	background: #E6EDF5;
	color: #4F76A3;
	font-size: 100% !important;
}
tbody th {
	font-weight: bold;
}
tbody tr {
	background: #FCFDFE;
}
tbody tr.odd {
	background: #F7F9FC;
}
table a:link {
	color: #718ABE;
	text-decoration: none;
}
table a:visited {
	color: #718ABE;
	text-decoration: none;
}
table a:hover {
	color: #718ABE;
	text-decoration: underline !important;
}
tfoot th, tfoot td {
	font-size: 85%;
}
.background01{
    background-color: #ebebeb; padding: 20px}
.e01{font-size: 40px;
    font-weight: 900;
    line-height: 56px;
    }
/*標題字字體修改*/
h1, h2, h3, h4, h5, h6{}
h1, .h1{font-size:2.8rem}
h2, .h2{font-size:2.3rem}
h3, .h3{font-size:2rem}
h4, .h4{font-size:1.5rem}
/*與H1大小相同但CSS H1標題置中*/
h11{font-size:2.8rem;display:block;width:100%;text-align:center;}
h14{font-size:1.5rem;display:block;width:100%;text-align:center;}
.fontssize1rem{font-size:1rem}
.fontssize2rem{font-size:2rem}
.fontssize3rem{font-size:3rem}
</style>
</head><body>

<br>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-12" align="center">
<div class="background01">
<H2>公司人員後台</H2>
<H1 class="font-effect-3d e01">Show the file to the customer to see the system</H1>
</div>
<br>	
<form name="form1" method="post" action="loginok2.php">
    <table border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td><img src="skin/img/min_logo.png" width="168" height="169"></td>
          <td >
            <p>&nbsp;&nbsp;密碼&nbsp;
              <input type="password" name="pass" id="pass" style="width:200px">
            </p>
            <p align="center">
              <input type="submit" name="button" id="button" value="     登 入     ">
            </p>
            
<p>(密碼輸入正確COOKIE會記憶到本月底)</p>
            </td>
        </tr>
      </tbody>
    </table>
    <div align="center"></div>
</form>
    </div>
  </div><!--./row./col-md-12--> 
</div><!--./container-->
<?php
require('_inc/inc_footer_s.php');   //載入表尾
?>
</body>
</html>