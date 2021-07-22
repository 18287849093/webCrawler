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
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 1600px;height:800px;"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    import

    import ecStat from 'echarts-stat';

    echarts.registerTransform(ecStat.transform.clustering);
    var myChart = echarts.init(document.getElementById('main'));

    var data = [
        [2.196,9.8],
        [2.284,9.3],
        [1.273,6.3],
        [2.158,9.6],
        [2.714,9.9],
        [2.165,9.2],
        [2.152,9.3],
        [2.822,9.7],
        [2.048,9],
        [2.423,9.8],
        [2.425,9.5],
        [2.406,9.2],
        [2.664,9.6],
        [2.256,9.7],
        [2.232,9.7],
        [1.992,9.4],
        [2.978,9.8],
        [2.946,9.9],
        [1.876,8.5],
        [3.497,9.9],
        [2.131,9.1],
        [1.832,8.7],
        [2.818,9.7],
        [2.933,9.8],
        [1.704,8.7],
        [2.216,9.8],
        [1.553,8.2],
        [1.254,9.6],
        [2.769,9.7],
        [2.481,9.1],
        [2.048,9.2],
        [2.911,9.8],
        [2.176,9.4],
        [2.702,9.8],
        [1.338,7.3],
        [2.008,9.3],
        [2.251,9.9],
        [1.206,8.6],
        [2.052,9.8],
        [2.762,9.7],
        [2.701,7.7],
        [1.792,8.2],
        [2.307,9.6],
        [2.26,9.1],
        [1.827,8.8],
        [2.717,9.9],
        [1.328,7.2],
        [2.328,9.2],
        [2.072,8.8],
        [2.065,8.9],
        [2.476,9.5],
        [2.32,9.6],
        [1.716,8.3],
        [1.252,8.6],
        [2.149,9.4],
        [2.404,9.8],
        [0.946,6.6],
        [1.871,8.9],
        [2.957,9.7],
        [1.133,9.4],
        [2.806,8.7],
        [2.753,9.6],
        [2.754,9.6],
        [2.368,9.8],
        [1.035,7.8],
        [2.131,9.7],
        [2.177,9.7],
        [1.891,8.9],
        [1.55,8],
        [1.482,9.8],
        [1.974,8.7],
        [1.83,8.8],
        [1.662,9.6],
        [1.085,9.4],
        [1.621,8.2],
        [2.282,9.4],
        [2.749,8.7],
        [1.775,9.8],
        [2.499,9.7],
        [1.598,8.7],
        [1.652,6],
        [0.814,4.9],
        [0.796,4.7],
        [2.376,9.7],
        [2.436,9],
        [2.679,9.2],
        [2.946,9],
        [2.631,9.7],
        [2.387,9.6],
        [2.143,9.2],
        [2.037,9],
        [2.337,9.8],
        [2.656,9.8],
        [2.247,9.7],
        [2.458,9.6],
        [2.611,9.6],
        [1.589,7],
        [1.929,8.9],
        [2.198,9.2],
        [2.23,9.7],


    ];

    var CLUSTER_COUNT = 6;
    var DIENSIION_CLUSTER_INDEX = 2;
    var COLOR_ALL = [
        '#37A2DA', '#e06343', '#37a354', '#b55dba', '#b5bd48', '#8378EA', '#96BFFF'
    ];
    var pieces = [];
    for (var i = 0; i < CLUSTER_COUNT; i++) {
        pieces.push({
            value: i,
            label: 'cluster ' + i,
            color: COLOR_ALL[i]
        });
    }

    option = {
        dataset: [{
            source: data
        }, {
            transform: {
                type: 'ecStat:clustering',
                // print: true,
                config: {
                    clusterCount: CLUSTER_COUNT,
                    outputType: 'single',
                    outputClusterIndexDimension: DIENSIION_CLUSTER_INDEX
                }
            }
        }],
        tooltip: {
            position: 'top'
        },
        visualMap: {
            type: 'piecewise',
            top: 'middle',
            min: 0,
            max: CLUSTER_COUNT,
            left: 10,
            splitNumber: CLUSTER_COUNT,
            dimension: DIENSIION_CLUSTER_INDEX,
            pieces: pieces
        },
        grid: {
            left: 120
        },
        xAxis: {
        },
        yAxis: {
        },
        series: {
            type: 'scatter',
            encode: { tooltip: [0, 1] },
            symbolSize: 15,
            itemStyle: {
                borderColor: '#555'
            },
            datasetIndex: 1
        }
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
</body>

</html>