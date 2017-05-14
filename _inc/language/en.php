<?
//陣列字串代換函式   A陣列為主 B陣列為轉換目標 2者數目要相同  若B陣列比數目較小也是會建立 預設的值為無
  function GetIndexName($aryIndex,$aryName)
  {
    if(count($aryIndex)!= count($aryName)){echo "A欄位".count($aryIndex)."筆B欄位".count($aryName)."筆，有資料欄位數目不相同，無法轉換"; exit;}
     for($i=0; $i < count($aryIndex); $i++)
    {
        $sBuf[$aryIndex[$i]]=$aryName[$i];
	 }		
     return $sBuf;
  }
$db['coop-landru']=array("name","date","gametype","cp","maxcp","vs","maxvs","lan","r","sse");//資料要顯示的欄位順序

//翻譯
  $idx_data_cooplanr0  = array("name","date","gametype","cp","maxcp","vs","maxvs","lan","r","sse");
  $idx_data_cooplanr1  = array("遊戲名","日期","類型","CP","MAXCP","VS","MAXVS","LAN","R","sse");
  $name_data_cooplanr =GetIndexName($idx_data_cooplanr0,$idx_data_cooplanr1);//
  
 /*
    [name] => zSilencer
    [web_cooplandru] => http://coop-land.ru/rookovodstva/6933-zsilencer-online-platformer-1998.html
    [gametype] => Arcade
    [cp] => x
    [maxcp] => 0
    [vs] => &#10003;
    [maxvs] => 24
    [lan] => x
    [r] => 0
    [date] => 2014-00-00
    [add_date] => 2017-01-12 17:45:50
    [steamid] => 
    [steamid_scanning] => 0
*/
?>