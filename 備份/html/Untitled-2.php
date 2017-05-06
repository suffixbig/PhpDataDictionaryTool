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
$thisDir = "."; //config.inc.php檔的相對路徑
$_file = basename(__FILE__); //自行取得本程式名稱
require($thisDir . "/config.inc.php"); // 載入主參數設定檔
require($thisDir . "/config.inc.mysql.php"); //載入資料庫帳號
if(background_switch){
require(INCLUDE_PATH . "/inc_password.php"); // 載入密碼登入系統
} else {
}
require_once INCLUDE_PATH . "/mysql.inc.php"; // 載入資料庫函式
require_once INCLUDE_PATH . "/global_suffix.php"; // 載入資料庫函式
/***********************************************************************************************/
require(INCLUDE_PATH . '/inc_head.php'); //載入表頭
?>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="skin/js/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- 可選的Bootstrap主題文件（一般不用引入） 
<link rel="stylesheet" href="/skin/js/bootstrap/3.3.7/css/bootstrap-theme.min.css">-->
<!-- 本頁專用 -->
<link href="skin/css/admin.css" rel="stylesheet">
<style>
		body {
			
		}
	.l_scroll{
		position: relative;
		position: fixed;
		z-index: 90;
		background: #96FCEE;
	}
		.l_scroll ul.nav-pills {
		}
		div.col-sm-9 div {
			height: 250px;
			font-size: 28px;
		}
		#section1 {color: #fff; background-color: #1E88E5;}
		#section2 {color: #fff; background-color: #673ab7;}
		#section3 {color: #fff; background-color: #ff9800;}
		#section41 {color: #fff; background-color: #00bcd4;}
		#section42 {color: #fff; background-color: #009688;}

		@media screen and (max-width: 810px) {
			#section1, #section2, #section3, #section41, #section42  {
				margin-left: 150px;
			}
		}
	</style>
</head>
<!--滾動監聽-->
<body data-spy="scroll" data-target="#navbar-fixed-top" data-offset="20">


<div class="l_scroll">

		<nav id="navbar-fixed-top">
			<div class="container-fluid"> 
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#section1">Section 1</a></li>
				<li><a href="#section2">Section 2</a></li>
				<li><a href="#section3">Section 3</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Section 4 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#section41">Section 4-1</a></li>
						<li><a href="#section42">Section 4-2</a></li>                     
					</ul>
				</li>
			</ul>
			</div>		
		</nav>

</div>

		
<div class="container">
	<div class="row">
		<div class="col-sm-9">
		<h1>滾動監聽</h1>
			<div id="section1">    
				<h1>Section 1</h1>
				<p>Try to scroll this section and look at the navigation list while scrolling!</p>
			</div>
			<div id="section2"> 
				<h1>Section 2</h1>
				<p>Try to scroll this section and look at the navigation list while scrolling!</p>
			</div>        
			<div id="section3">         
				<h1>Section 3</h1>
				<p>Try to scroll this section and look at the navigation list while scrolling!</p>
			</div>
			<div id="section41">         
				<h1>Section 4-1</h1>
				<p>Try to scroll this section and look at the navigation list while scrolling!</p>
			</div>      
			<div id="section42">         
				<h1>Section 4-2</h1>
				<p>Try to scroll this section and look at the navigation list while scrolling!</p>
			</div>
		</div>
	</div>
</div>


<?php
require('_inc/inc_footer_s.php'); //載入表尾
?>
<script src="skin/js/jquery.cookie.min.js" type="text/javascript"></script>
<!--jqueryui-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
</body>
</html>
