<div class="w100 height10"><!--間距--></div> 

<!--頁尾S-->
<footer class="text-center footer">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p>Copyright © 2016 &nbsp;<a href="mailto:jasonkkk@kimo.com" ><i class="icon-envelope"></i></a> &nbsp;&nbsp;&nbsp;&nbsp; 作者:台灣碼農suffixbig &nbsp;&nbsp;免費開源歡迎下載使用 <a href="https://github.com/suffixbig/PhpDataDictionaryTool" target="_blank">github下載說明</a> </p>
      </div>
    </div>
  </div>
</footer>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
//載入完後就執行 S
$(function(){
 
//到頂端浮動按鈕
 $("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;' title='回到頂端'/>");
 var img = "skin/css/go_top.png",
  locatioin = 1/2,  // 按鈕出現在螢幕的高度
  right = 10,  // 距離右邊 px 值
  opacity = 0.3,  // 透明度
  speed = 500,  // 捲動速度
  $button = $("#goTopButton"),
  $body = $(document),
  $win = $(window);
 
 $button.attr("src", img);
 $button.on({
  mouseover: function() {$button.css("opacity", 1);},
  mouseout: function() {$button.css("opacity", opacity);},
  click: function() {$("body").animate({scrollTop: 0}, speed);}
 });
 
 window.goTopMove = function () {
  var scrollH = $body.scrollTop(),
   winH = $win.height(),
   css = {"top": winH * locatioin + "px", "position": "fixed", "right": right, "opacity": opacity};
  if(scrollH > 20) {
   $button.css(css);
   $button.fadeIn("slow");
  } else {
   $button.fadeOut("slow");
  }
 };
 
 $win.on({
  scroll: function() {goTopMove();},
  resize: function() {goTopMove();}
 });

});//載入完後就執行END

//跳到錨點
function go_top(s){
 var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
 var top="#"+s;
 var $sss=$(top).offset().top;
 var $sss2=$sss-20
 $body.animate({
 scrollTop:$sss2+ "px"
 }, {
 duration: 500,
 easing: "swing"
 });
 }
</script>