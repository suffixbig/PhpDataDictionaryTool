//重整
function locationabc() {
    location.reload(true);
}
//把選項記憶一天
function cookie_intype($s) {
    $.cookie('im_type_ad', $s, {
        path: '/',
        expires: 10
    });
}

function cookie_insale($s) {
    $.cookie('sale', $s, {
        path: '/',
        expires: 10
    });
    locationabc();
}



//載入完就啟用 開始*****************************/
$(function() {

    // 綁定下拉式選項跳頁
    // 如果jQuery版本是 < 1.7, 取代 on 使用 bind
    $('select[name="goto_url"]').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) {
            window.location = url; // redirect
        }
        return false;
    });

    //--滾動監聽使用內建功能-->

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        // 獲取已激活的標籤頁的名稱
        var activeTab = $(e.target).text();
        // 獲取前一個激活的標籤頁的名稱
        var previousTab = $(e.relatedTarget).text();
        if (activeTab == '全表列出')
            $('.l_scroll').animate({ "left": 0 }, 500);
        else
            $('.l_scroll').animate({ "left": -200 }, 500);
    });
    //關閉按鈕
    $("#upper_right_close").click(function() {
        $('.l_scroll').animate({ "left": -200 }, 500);
    });

    //JQUARYUI訊息提示
    $('#replace_editingid').tooltip({
        //跟隨滑鼠爆炸效果
        track: true,
        hide: {
            effect: "explode",
            delay: 250
        }
    });




    /*手機拖曳放置 Start*/

    // 獲取相冊ul的id轉換為jquery對像
    var $mBox1 = $("#mBox1"),
        // 獲取垃圾箱的id轉換為jquery對像
        $mBox2 = $("#mBox2"),
        $mBox3 = $("#mBox3");

    //設定拖曳物
    $("div", $mBox1).draggable({
        //點擊圖片不能被觸發
        //cancel: "a.ui-icon", 
        //當不被拖拽時圖片會自動的返回到原來的位置，（除非到了垃圾箱中則不會被返回）
        revert: "invalid",
        //設置相冊可被拖拽到的區域，可以是指定某個元素內，也可以是document,parent
        containment: $("#demo-frame").length ? "#demo-frame" : "document",
        //設置圖片可以被克隆
        helper: "clone",
        //當鼠標放上去的時候鼠標變為移動的樣式
        cursor: "move",
        //設置相冊被拖拽時的透明度
        opacity: 0.6
    });

    //設置可放置的區域，用來接收
    $mBox2.droppable({
        //設置允許接收的內容為指定的內容
        accept: "#mBox1 > div",
        //當接收的對象在被拖拽時，設置該垃圾箱的css樣式
        hoverClass: "box-state-highlight",
        //當被拖拽目標完全進入指定的容器內內部時觸發的函數（經過測試該完全進入是指被拖拽目標的1/2進入指定區域即可）
        drop: function(event, td) {
            //調用刪除事件，刪除被拖拽對像原始位置的圖像
            deleteImage(td.draggable, $mBox2); //呼叫涵式
        }
    });

    //設置可放置的區域，用來接收
    $mBox3.droppable({
        //設置允許接收的內容為指定的內容
        accept: "#mBox1 > div",
        //當接收的對象在被拖拽時，設置該垃圾箱的css樣式
        hoverClass: "box-state-highlight",
        //當被拖拽目標完全進入指定的容器內內部時觸發的函數（經過測試該完全進入是指被拖拽目標的1/2進入指定區域即可）
        drop: function(event, td) {
            //調用刪除事件，刪除被拖拽對像原始位置的圖像
            deleteImage(td.draggable, $mBox3); //呼叫涵式
        }
    });

    //設置相冊也為為一個可放置的區域，用來接收相冊垃圾箱中的被回收的相冊（可直接拖拽）
    $mBox1.droppable({
        hoverClass: "box-state-highlight",
        //當被拖拽目標完全進入指定的容器內內部時觸發的函數（經過測試該完全進入是指被拖拽目標的1/2進入指定區域即可）
        drop: function(event, td) {
            //當相冊從垃圾箱被拖出到指定區域時調用該函數，把被拖拽元素的對象傳過去
            recycleImage(td.draggable, $mBox1);
        }
    });
    //設置區完畢***************************************************************************
    /*手機拖曳放置 END*/
}); //載入完就啟用 END  


//拖曳*******************************************

var $width = 100;
//創建一個還原圖標
//刪除相冊的函數，接收一個被刪除的元素（li）對像
function deleteImage($item, $list) {
    $width = $('#mBox2').width(); //重測寬度
    //給該圖片加上淡出效果//原圖只是淡出不是真的不見
    $item.fadeOut(function() {
        //剪下貼上
        $item.appendTo($list).fadeIn(function() {
            $item.animate({ width: $width });
        });
    });
}

function recycleImage($item, $list) {
    //給該圖片加上淡出效果//原圖只是淡出不是真的不見
    $item.fadeOut(function() {
        //剪下貼上
        $item.appendTo($list).fadeIn(function() {
            $item.removeAttr("style");
        });
    });
}
//按鈕
function sub() {
    var idall = []; //建一個空陣列
    //遍歷
    $("#mBox2>div").each(function() {
        idall.push($(this).attr('id')); //把該DIV下的ID都加到陣列
    });

    console.log(idall); //測試用
    event.preventDefault(); //避免 <a> 原先應該做的動作。
}
//全部到右邊
function Totheright() {
    //遍歷
    $("#mBox1>div").each(function() {
        deleteImage($(this), $("#mBox2")); //移到2區
    });
}
//全部到左邊
function Totheleft() {
    $("#mBox2>div").each(function(e) {
        recycleImage($(this), $("#mBox1")); //移到1區
    });
}
//拖曳END*******************************************