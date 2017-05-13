測試位置
http://test.com/github_cloud/PhpDataDictionaryTool/	
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

	20170505 除錯紀錄 接收tablename值有加上字尾
http://test.com/github_cloud/PhpDataDictionaryTool/index.php?DATANAME=credit
http://test.com/github_cloud/PhpDataDictionaryTool/ajax/goto_datasheet.php?database=credit&tablename=text


#測試
view-source:http://test.com/github_cloud/PhpDataDictionaryTool/ajax/goto_datasheetb1.php?database=credit&etitokdiv=1