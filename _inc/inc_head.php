<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<title><?php
if(isset($i_my))
echo $CT_CONFIG['html_title']."-".$i_my;
else
echo $CT_CONFIG['html_title'];
?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--ico-->
<!-- favorite icon starts -->
<link rel="shortcut icon" href="/favicon.ico" />
<!--<link rel="shortcut icon" href="/icon.png" type="image/x-icon" />-->
<link rel="apple-touch-icon" href="/AppIcon.png" />
<!-- favorite icon ends -->
<meta name="keywords" lang="zh-TW" content="">
<meta name="description" content="">
<!-- jQuery文件。務必在bootstrap.min.js 之前引入 -->
<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>