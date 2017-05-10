<?php
//20170322
/*
 * 試用PHP7.0
 */
//開資料庫-預設開啟資料庫
function _mysql_open($table_db = '')
{
    global $cfg;
    $i = $cfg['servers']['y'];
    $dbusername = $cfg['servers'][$i]['user'];
    $dbpassword = $cfg['servers'][$i]['password'];
    $database = $cfg['servers'][$i]['database'];

    //Mysql_db;//預設連接到的資料表
    $error_level = error_reporting(0); //修改錯誤訊息等級
    $mysqli = new mysqli($dbserver, $dbusername, $dbpassword, $database, $cfg['servers'][$i]['port']);
    error_reporting($error_level);

    $mysqli->query("SET NAMES 'utf8'"); //以下資料用utf8碼與資料庫連線 必須有此行
    $mysqli->query("set time_zone = '+8:00'"); //時區指定
    //$mysqli->query("USE ".$database);//切換資料庫

    if (mysqli_connect_errno($mysqli)) {
        echo "連接 MySQL 失敗: ",mysqli_connect_error();
    }
    return $mysqli;
}

//關資料庫
function _mysql_close($dblink = '')
{
    mysqli_close($dblink);
}

//執行SQL
function _sql($dblink, $sql)
{
    $ok = mysqli_query($dblink, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
}

//切換資料庫
function mysqluse($dblink, $db)
{
    _sql($dblink, "USE `" . $db . "`");
}


//以IN查資料 給陣列變為要入SQL的字-----這段不一樣注意注意
function idgroup($array = array())
{
    if (empty($array)) {
        return "IN(0)"; //沒資料不查
    }

    if (is_array($array)) {
        $IDGroup = " IN (";
        for ($ii = 0; $ii < count($array); $ii++) {
            if (!$ii) {
                $IDGroup = $IDGroup . "'" . $array[$ii] . "'";
            } else {
                $IDGroup .= ",'" . $array[$ii] . "'";
            }
        }
        $IDGroup .= ")";
        return $IDGroup;
    } else {
        return "IN(0)";
    }
}


//不連結資料庫-以欄名建立二維陣列
function assoc_sql($sql, $dblink)
{
	$array=array();
    $result = mysqli_query($dblink, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
//查詢結果抓出一筆存入array[]陣列
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    $result->close(); //釋放記憶體
    return $array;
}

//不連結資料庫-以攔名建立一維陣列(單行)
function assoc_sql1p($sql, $dblinkID = "")
{
    if ($dblinkID) {
        $str = mysqli_query($dblinkID, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
    } else {
        $str = mysqli_query($sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
    }
    $row = mysqli_fetch_assoc($str); //抄下符合名稱那一排的資料
    return $row; //結果參數存回主程式 若找無資料會返回""
}

//不連結資料庫--以數字建立二維陣列
function row_sql($sql, $dblinkID = "")
{
    if ($dblinkID) {
        $result = mysqli_query($dblinkID, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
    } else {
        $result = mysqli_query($sql) or die("error - 1 : " . $sql); //帶入查詢語法
    }
//查詢結果抓出一筆存入array[]陣列
    while ($row = mysqli_fetch_row($result)) {
        $array[] = $row;
    }
    $result->close(); //釋放記憶體
    return $array;
}

//不連結資料庫--以數字建立1維陣列-只取該列第1欄
function row_sql_a($sql, $dblinkID = "")
{
    if ($dblinkID) {
        $result = mysqli_query($dblinkID, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
    } else {
        $result = mysqli_query($sql) or die("error - 1 : " . $sql); //帶入查詢語法
    }
//查詢結果抓出一筆存入array[]陣列
    while ($row = mysqli_fetch_row($result)) {
        $array[] = $row[0];
    }
    $result->close(); //釋放記憶體
    return $array;
}

//不連結資料庫-只取一個答案 注意用法3個參數都要
function row_sql1p($sql, $s = 0, $dblinkID = "")
{
    $str = mysqli_query($dblinkID, $sql) or die("error 單行查詢錯誤: " . $sql); //帶入查詢語法;
    $row = mysqli_fetch_row($str); //抄下符合名稱那一排的資料
    return $row[$s]; //結果參數存回主程式 若找無資料會返回""
}

//修改資料
function mysql_up($sql, $dblinkID)
{
    $str = mysqli_query($dblinkID, $sql) or die("error -1: " . $sql); //帶入查詢語法;
    return $str;
}

//新增資料
function mysql_insert($sql, $dblinkID)
{
    $str = mysqli_query($dblinkID, $sql); //帶入查詢語法;
    return $str; //成功會是1 失敗會返回空
}
