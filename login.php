<?php
$thisDir = "."; //config.inc.php檔的相對路徑
$_file = basename( __FILE__ ); //自行取得本程式名稱
require( $thisDir . "/config.inc.php" ); // 載入主參數設定檔
require_once INCLUDE_PATH . "/mysql.inc.php"; // 載入資料庫函式
require_once INCLUDE_PATH . "/global_suffix.php"; // 載入資料庫函式
/***********************************************************************************************/
$i_my = '後台登入';
/***********************************************************************************************/
require( '_inc/inc_head.php' ); //載入表頭
?>
<!-- 新 Bootstrap 核心 CSS 文件 
<link rel="stylesheet" href="skin/js/bootstrap/3.3.5/css/bootstrap.min.css">-->
<!-- 本頁專用 -->
<style type="text/css">
	body {
		height: 100%;
		width: 100%
	}
	
	body,
	td,
	th {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	
	table,
	th,
	td {
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
	
	td,
	th {
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
	
	tfoot th,
	tfoot td {
		font-size: 85%;
	}
</style>
</head>
<body>

	<br>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-12" align="center">

				<form name="form1" method="post" action="loginok.php">
					<p>
						<img src="skin/img/t_title.png" width="301" height="50"><br>
					</p>
					<table width="495" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td width="205"><img src="skin/img/min_logo.png" width="168" height="169">
								</td>
								<td width="288">
									<p>&nbsp;&nbsp;密碼&nbsp;
										<input type="password" name="pass" id="pass" style="width:200px">
									</p>
									<p align="center">
										<input type="submit" name="button" id="button" value="     登 入     ">
									</p>

									<p>(密碼輸入正確記憶到月底)..<a href="loginok.php?type=del">登出</a>
									</p>
									
								</td>
							</tr>
						</tbody>
					</table><h3> 密碼提示:9個字全小寫無空格<br>
(B.C. & Lowy: 美國實況主在遊戲中大喊的一句話taiwan?)</h3>
					<div align="center"></div>
				</form>
			</div>
		</div>
		<!--./row./col-md-12-->
	</div>
	<!--./container-->
	<?php
	require( '_inc/inc_footer_s.php' ); //載入表尾
	?>
</body>
</html>