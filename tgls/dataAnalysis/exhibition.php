<?php
session_start();//启用session
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>后台管理系统</title>

    <!-- 公共样式 开始 -->
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/iconfont.css">
    <!--		<script type="text/javascript" src="../../framework/jquery-1.11.3.min.js"></script>-->
    <script type="text/javascript" src="../../framework/jquery.form.min.js.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../layui/css/layui.css">
    <script type="text/javascript" src="../../layui/layui.js"></script>
    <!-- 滚动条插件 -->
    <link rel="stylesheet" type="text/css" href="../../css/jquery.mCustomScrollbar.css">
    <script src="../../framework/jquery-ui-1.10.4.min.js"></script>
    <script src="../../framework/jquery.mousewheel.min.js"></script>
    <script src="../../framework/jquery.mCustomScrollbar.min.js"></script>
    <script src="../../framework/cframe.js"></script><!-- 仅供所有子页面使用 -->
    <script src="../../echarts/echarts.min.js"></script>

</head>

<body>
<div class="cBody">
    <div class="console">
        <form class="layui-form" action="">
        </form>
    </div>
    <div id="main" style="width:1200px;height:600px;">
        <div id="left" style="width:500px;height:600px;float:left;">

    <table class="layui-hide" id="demo" lay-filter="test"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="showData">展示数据</a>
    </script>
        </div>
        <div id="right" style="width:700px;height:800px;float:right;"> </div>
        <script type="text/javascript">
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById("right"));
            // 指定图表的配置项和数据
            option = {
                title: {
                    text: 'b站动国漫排行榜漫风格分布',
                    subtext: 'bilibili',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            {value: 29, name: '原创'},
                            {value: 43, name: '搞笑'},
                            {value: 17, name: '奇幻'},
                            {value: 8, name: '科幻'},
                            {value: 42, name: '改编'},
                            {value: 35, name: '战斗'},
                            {value: 6, name: '校园'},
                            {value: 5, name: '历史'},
                            {value: 18, name: '动态漫'},
                            {value: 16, name: '神魔 玄幻'},
                            {value: 37, name: '热血 励志'},
                            {value: 10, name: '少女 恋爱'},
                            {value: 23, name: '治愈 萌系'},
                            {value: 6, name: '悬疑 推理'},
                            {value: 12, name: '古风 武侠'},
                            {value: 4, name: '催泪 时泪'},
                            {value: 34, name: '日常 泡面'},
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        </script>

    <script>
        layui.use(['laypage', 'layer'], function() {
            var laypage = layui.laypage,
                layer = layui.layer,
                table = layui.table,
                element = layui.element;

            //总页数大于页码总数
            laypage.render({
                elem: 'pages'
                ,count: 100
                ,layout: ['count', 'prev', 'page', 'next', 'limit', 'skip']
                ,jump: function(obj){
                    console.log(obj)
                }
            });


            table.render({
                elem: '#demo'
                , height: 800
                , url: '../../application/dataAnalysis/showPicture.php'//数据接口
                , parseData: function (res) { //res 即为原始返回的数据
                    console.log(res)
                }
                , limit: 30
                , method: 'post'
                , title: '用户表'
                , page: true //开启分页
                //,toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
                , totalRow: false //开启合计行
                , cols: [[ //表头
                    {field: 'name', title: '动漫名称', width: 150, sort: true, fixed: 'left'}
                    , {fixed: 'right', width: 80, align: 'center', toolbar: '#barDemo'}
                ]]
            });

            table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data//获得当前行数据
                    ,layEvent = obj.event;//获得 lay-event 对应的值

                if(layEvent === 'showData'){
                    showEdit(data);
                }

                //删除数据的函数
                function deluser(data,index,obj){
                    //layer.msg("ok")
                    $.ajax({
                        url: '../../application/dataAnalysis/rankingDelete.php',    //这个是后台的路由地址
                        type: "POST",
                        data:{"rank":data.rank},//传给后台的值
                        dataType: "json",
                        success: function(data){

                            if(data['status']=="success"){   //从前台取回的状态值
                                layer.close(index);
                                //同步更新表格和缓存对应的值
                                obj.del();
                                layer.msg("删除成功", {icon: 6});
                            }else{
                                layer.msg("删除失败 ", {icon: 5});
                            }

                        }
                    });
                }

                //修改数据的函数
                function showEdit(datas) {

                    var editHtml = '<form id="form1" class="layui-form" method="post" action="../../application/museumData/sys_data_edit.php" style="width:460px; margin-top: 20px;">\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">评论情绪折线图</label>\
                             <div class="layui-input-block">\
                               <div id="chartOne" style="width: 600px;height:400px;"></div>\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">雷达图</label>\
                             <div class="layui-input-block">\
                              <div id="chartTwo" style="width: 600px;height:400px;"></div>\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">评论词云图</label>\
                             <div class="layui-input-block">\
                               <img id="img" src="../../application/dataAnalysis/WordCloud/'+datas.imageSrc+'">\
                             </div>\
                           </div>\
                       </form>';


                    layer.open({
                        type: 1,
                        title: '数据展示',
                        content: editHtml,
                        area: ['1200px', '600px'],
                        yes: function (layIndex) {
                            // var params ={"museumID",}
                            $.ajax({
                                url: '../../application/museumData/sys_data_edit.php',    //这个是后台的路由地址
                                type: "POST",
                                data:$('#form1').serialize(),//传给后台的值
                                dataType: "json",
                                success: function(data){
                                    layer.close(layIndex);
                                    if(data['status']=="success"){
                                        table.reload();   //从前台取回的状态值
                                        layer.msg("成功", {icon: 6});
                                    }else{
                                        table.reload();
                                        layer.msg("删除失败 ", {icon: 5});
                                    }
                                    window.location.reload();
                                }
                            });

                        }
                    });
                }


                var myChart = echarts.init(document.getElementById('chartOne'));

                // 指定图表的配置项和数据
                var option = {
                    title: {
                        text: data.name+'情绪分布图'
                    },
                    tooltip: {},
                    legend: {
                        data:['情绪值']
                    },
                    xAxis: {
                        data: data.position[1]
                    },
                    yAxis: {},
                    series: [{
                        name: '销量',
                        type: 'bar',
                        data: data.position[0]
                    }]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);

                var myChart = echarts.init(document.getElementById('chartTwo'));

                // 指定图表的配置项和数据
                var option1 = {
                    title: {
                        text: '动漫数据雷达图'
                    },
                    legend: {
                        data: ['动漫数据']
                    },
                    radar: {
                        // shape: 'circle',
                        indicator: [
                            { name: '播放量（万）', max: 49000},
                            { name: '系列追番人数（万）', max: 856},
                            { name: '总弹幕数量（万）', max: 549},
                            { name: '评论数（万）', max: 600},
                            { name: '收藏数（万）', max: 1000},
                            { name: '综合评分', max: 4161482}
                        ]
                    },
                    series: [{
                        name: '预算 vs 开销（Budget vs spending）',
                        type: 'radar',
                        data: [
                            {
                                value: data.radar,
                                name: '实际开销（Actual Spending）'
                            }
                        ]
                    }]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option1);

            });

        });
    </script>

    <script type="text/javascript">

    </script>
</div>
</body>
</html>