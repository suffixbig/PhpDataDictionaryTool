<?php
/*******************************************************************************************************/
/*陣列字串代換函式   A陣列為主 B陣列為轉換目標 2者數目要相同  若B陣列比數目較小也是會建立 預設的值為無****************/
function GetIndexName( $aryIndex, $aryName ) {
	if ( count( $aryIndex ) != count( $aryName ) ) {
		echo "A欄位" . count( $aryIndex ) . "筆B欄位" . count( $aryName ) . "筆，有資料欄位數目不相同，無法轉換";
		exit;
	}
	for ( $i = 0; $i < count( $aryIndex ); $i++ ) {
		$sBuf[ $aryIndex[ $i ] ] = $aryName[ $i ];
	}
	return $sBuf;
}
/*******************************************************************************************************/


class Abc{
	public $mData;
	public function show() 
	{

//字體資料庫 除了思源黑體 其他英文全有問題 所以搞個Noto Mono
$idx_font_type0 = array( "0", "1", "2", "3", "4", "5" , "6");
$idx_font_type1 = array( "系統預設", "思源黑體", "黑體", "仿宋體", "明體", "圓體","楷體");
$idx_font_type2 = array(
	"",
	"//fonts.googleapis.com/earlyaccess/notosanstc.css",
	"//fonts.googleapis.com/earlyaccess/cwtexhei.css",
	"//fonts.googleapis.com/earlyaccess/cwtexfangsong.css",
	"//fonts.googleapis.com/earlyaccess/cwtexming.css",
	"//fonts.googleapis.com/earlyaccess/cwtexyen.css",
	"//fonts.googleapis.com/earlyaccess/cwtexkai.css",
);            
            
$idx_font_type3 = array( "Helvetica,微軟正黑體,'Microsoft JhengHei',sans-serif", "'Noto Sans TC'", "'Noto Sans',cwTeXHei, sans-serif;", "'Noto Sans',cwTeXFangSong, serif", "'Noto Sans',cwtexming, serif;", "'Noto Sans',cwTeXYen, sans-serif;" ,"'Noto Sans',cwTeXKai, serif;",);
$idx_font_type4 = array( "font_zh-tw00", "font_zh-tw01", "font_zh-tw02", "font_zh-tw03", "font_zh-tw04", "font_zh-tw05", "font_zh-tw06" );
$this->mData[ 'font' ][ '1' ] = GetIndexName( $idx_font_type0, $idx_font_type1 ); //字體種類中文
$this->mData[ 'font' ][ 'css_importurl' ] = GetIndexName( $idx_font_type0, $idx_font_type2 ); //字體CSS
$this->mData[ 'font' ][ 'font-family' ] = GetIndexName( $idx_font_type0, $idx_font_type3 ); //字體CSS
$this->mData[ 'font' ][ 'css' ] = GetIndexName( $idx_font_type0, $idx_font_type4 ); //字體CSS 
           
	}	
}
$this2 = new Abc;//建立物件
$this2->show();//使用方法1次
//$lang=$this2->mData;//取質



		$i = 0;
		$i2 = trim( $_GET['type']); //
		if ( $i2 ) {
			$i = $i2;
		}
		$nr = "\n";
		$f = $this2->mData[ 'font' ];
		$f1 = $f[ 1 ]; //自中文名
		header( 'Content-Type: text/css' );
		echo "@charset \"utf-8\";" . $nr;


		if ( isset( $f1[ $i ] ) ) {
			if ( $i > 0 ) {
				//======================================================
				if ( $i == 1 ) {
					/*
					==================================================================================
					cwTeXYen font (Chinese: 思源黑體)
					==================================================================================
					*/
					echo "@font-face {
  font-family: 'Noto Sans TC';
  font-style: normal;
  font-weight: 100;
  src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Thin.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Thin.woff) format('woff'),
       url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Thin.otf) format('opentype');
}
@font-face {
  font-family: 'Noto Sans TC';
  font-style: normal;
  font-weight: 300;
  src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Light.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Light.woff) format('woff'),
       url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Light.otf) format('opentype');
}
@font-face {
   font-family: 'Noto Sans TC';
   font-style: normal;
   font-weight: 400;
   src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Regular.woff2) format('woff2'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Regular.woff) format('woff'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Regular.otf) format('opentype');
 }
@font-face {
   font-family: 'Noto Sans TC';
   font-style: normal;
   font-weight: 500;
   src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Medium.woff2) format('woff2'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Medium.woff) format('woff'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Medium.otf) format('opentype');
 }
@font-face {
   font-family: 'Noto Sans TC';
   font-style: normal;
   font-weight: 700;
   src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Bold.woff2) format('woff2'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Bold.woff) format('woff'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Bold.otf) format('opentype');
 }
@font-face {
   font-family: 'Noto Sans TC';
   font-style: normal;
   font-weight: 900;
   src: url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Black.woff2) format('woff2'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Black.woff) format('woff'),
        url(//fonts.gstatic.com/ea/notosanstc/v1/NotoSansTC-Black.otf) format('opentype');
 }";
				} elseif ( $i == 2 ) {
					/*				
					==================================================================================
					cwTeXHei font (Chinese: 黑體)
					==================================================================================
					*/
					echo "@font-face {
  font-family: 'cwTeXHei';
  font-style: normal;
  font-weight: 500;
  src: url(//fonts.gstatic.com/ea/cwtexhei/v3/cwTeXHei-zhonly.eot);
  src: url(//fonts.gstatic.com/ea/cwtexhei/v3/cwTeXHei-zhonly.eot?#iefix) format('embedded-opentype'),
       url(//fonts.gstatic.com/ea/cwtexhei/v3/cwTeXHei-zhonly.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/cwtexhei/v3/cwTeXHei-zhonly.woff) format('woff'),
       url(//fonts.gstatic.com/ea/cwtexhei/v3/cwTeXHei-zhonly.ttf) format('truetype');
}";
				} elseif ( $i == 3 ) {
					/*				
					==================================================================================	
					cwTeXFangSong font (Chinese: 仿宋體)
					==================================================================================
					*/
					echo "@font-face {
  font-family: 'cwTeXFangSong';
  font-style: normal;
  font-weight: 500;
  src: url(//fonts.gstatic.com/ea/cwtexfangsong/v3/cwTeXFangSong-zhonly.eot);
  src: url(//fonts.gstatic.com/ea/cwtexfangsong/v3/cwTeXFangSong-zhonly.eot?#iefix) format('embedded-opentype'),
       url(//fonts.gstatic.com/ea/cwtexfangsong/v3/cwTeXFangSong-zhonly.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/cwtexfangsong/v3/cwTeXFangSong-zhonly.woff) format('woff'),
       url(//fonts.gstatic.com/ea/cwtexfangsong/v3/cwTeXFangSong-zhonly.ttf) format('truetype');
}";
				} elseif ( $i == 4 ) {
					/*
					 * 明體
					 */
					echo "@font-face {
  font-family: 'cwTeXMing';
  font-style: normal;
  font-weight: 500;
  src: url(//fonts.gstatic.com/ea/cwtexming/v3/cwTeXMing-zhonly.eot);
  src: url(//fonts.gstatic.com/ea/cwtexming/v3/cwTeXMing-zhonly.eot?#iefix) format('embedded-opentype'),
       url(//fonts.gstatic.com/ea/cwtexming/v3/cwTeXMing-zhonly.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/cwtexming/v3/cwTeXMing-zhonly.woff) format('woff'),
       url(//fonts.gstatic.com/ea/cwtexming/v3/cwTeXMing-zhonly.ttf) format('truetype');
}";
				} elseif ( $i == 5 ) {
					/*
					==================================================================================
					cwTeXYen font (Chinese: 圓體)
					@import url(//fonts.googleapis.com/earlyaccess/cwtexyen.css);
					font-family: 'cwTeXYen', sans-serif;
					==================================================================================
					*/
					echo "@font-face {
  font-family: 'cwTeXYen';
  font-style: normal;
  font-weight: 500;
  src: url(//fonts.gstatic.com/ea/cwtexyen/v3/cwTeXYen-zhonly.eot);
  src: url(//fonts.gstatic.com/ea/cwtexyen/v3/cwTeXYen-zhonly.eot?#iefix) format('embedded-opentype'),
       url(//fonts.gstatic.com/ea/cwtexyen/v3/cwTeXYen-zhonly.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/cwtexyen/v3/cwTeXYen-zhonly.woff) format('woff'),
       url(//fonts.gstatic.com/ea/cwtexyen/v3/cwTeXYen-zhonly.ttf) format('truetype');
}";
				} elseif ( $i == 6 ) {
					/*	
					==================================================================================
					cwTeXKai font (Chinese: 楷體) 
					@import url(//fonts.googleapis.com/earlyaccess/cwtexkai.css);
					font-family: 'cwTeXKai', serif;
					==================================================================================
					*/
					echo "@font-face {
  font-family: 'cwTeXKai';
  font-style: normal;
  font-weight: 500;
  src: url(//fonts.gstatic.com/ea/cwtexkai/v3/cwTeXKai-zhonly.eot);
  src: url(//fonts.gstatic.com/ea/cwtexkai/v3/cwTeXKai-zhonly.eot?#iefix) format('embedded-opentype'),
       url(//fonts.gstatic.com/ea/cwtexkai/v3/cwTeXKai-zhonly.woff2) format('woff2'),
       url(//fonts.gstatic.com/ea/cwtexkai/v3/cwTeXKai-zhonly.woff) format('woff'),
       url(//fonts.gstatic.com/ea/cwtexkai/v3/cwTeXKai-zhonly.ttf) format('truetype');
}";
				}

			}
			echo $nr;
			echo "*{font-family:" . $f[ 'font-family' ][ $i ] . "}" . $nr;
			//======================================================
		}
	/***********************************************************************************************************/
