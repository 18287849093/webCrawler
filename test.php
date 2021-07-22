<?php
session_start();//启用session
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理系统</title>

    <!-- 公共样式 开始 -->
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <!--	<script type="text/javascript" src="framework/jquery-1.11.3.min.js" ></script>-->
    <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="layui/css/layui.css">
    <script type="text/javascript" src="layui/layui.js"></script>
    <!-- 滚动条插件 -->
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
    <script src="framework/jquery-ui-1.10.4.min.js"></script>
    <script src="framework/jquery.mousewheel.min.js"></script>
    <script src="framework/jquery.mCustomScrollbar.min.js"></script>
    <script src="framework/cframe.js"></script><!-- 仅供所有子页面使用 -->

    <!-- 公共样式 结束 -->

    <link rel="stylesheet" type="text/css" href="css/frameStyle.css">
    <script type="text/javascript" src="framework/frame.js" ></script>
    <script src="echarts/echarts.min.js"></script>
    <script src="echarts/ecStat.js"></script>
</head>

<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 1200px;height:400px;"></div>


</body>

</html>