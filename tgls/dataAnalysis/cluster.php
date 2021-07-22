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
    <script src="../../echarts/ecStat.js"></script>
</head>

<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 1600px;height:800px;"></div>
<script type="text/javascript">

    var chartDom = document.getElementById('main');
    var myChart = echarts.init(chartDom);
    var option;

    var originalData = [
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


    var DIM_CLUSTER_INDEX = 2;
    var DATA_DIM_IDX = [0, 1];
    var CENTER_DIM_IDX = [3, 4];

    // See https://github.com/ecomfe/echarts-stat
    var step = ecStat.clustering.hierarchicalKMeans(originalData, {
        clusterCount: 6,
        outputType: 'single',
        outputClusterIndexDimension: DIM_CLUSTER_INDEX,
        outputCentroidDimensions: CENTER_DIM_IDX,
        stepByStep: true
    });

    var colorAll = [
        '#bbb', '#37A2DA', '#e06343', '#37a354', '#b55dba', '#b5bd48', '#8378EA', '#96BFFF'
    ];
    var ANIMATION_DURATION_UPDATE = 1500;

    function renderItemPoint(params, api) {
        var coord = api.coord([api.value(0), api.value(1)]);
        var clusterIdx = api.value(2);
        if (clusterIdx == null || isNaN(clusterIdx)) {
            clusterIdx = 0;
        }
        var isNewCluster = clusterIdx === api.value(3);

        var extra = {
            transition: []
        };
        var contentColor = colorAll[clusterIdx];

        return {
            type: 'circle',
            x: coord[0],
            y: coord[1],
            shape: {
                cx: 0,
                cy: 0,
                r: 10
            },
            extra: extra,
            style: {
                fill: contentColor,
                stroke: '#333',
                lineWidth: 1,
                shadowColor: contentColor,
                shadowBlur: isNewCluster ? 12 : 0,
                transition: ['shadowBlur', 'fill']
            }
        };
    }

    function renderBoundary(params, api) {
        var xVal = api.value(0);
        var yVal = api.value(1);
        var maxDist = api.value(2);
        var center = api.coord([xVal, yVal]);
        var size = api.size([maxDist, maxDist]);

        return {
            type: 'ellipse',
            shape: {
                cx: isNaN(center[0]) ? 0 : center[0],
                cy: isNaN(center[1]) ? 0 : center[1],
                rx: isNaN(size[0]) ? 0 : size[0] + 15,
                ry: isNaN(size[1]) ? 0 : size[1] + 15
            },
            extra: {
                renderProgress: ++targetRenderProgress,
                enterFrom: {
                    renderProgress: 0
                },
                transition: 'renderProgress'
            },
            style: {
                fill: null,
                stroke: 'rgba(0,0,0,0.2)',
                lineDash: [4, 4],
                lineWidth: 4
            }
        };
    }

    function makeStepOption(option, data, centroids) {
        var newCluIdx = centroids ? centroids.length - 1 : -1;
        var maxDist = 0;
        for (var i = 0; i < data.length; i++) {
            var line = data[i];
            if (line[DIM_CLUSTER_INDEX] === newCluIdx) {
                var dist0 = Math.pow(line[DATA_DIM_IDX[0]] - line[CENTER_DIM_IDX[0]], 2);
                var dist1 = Math.pow(line[DATA_DIM_IDX[1]] - line[CENTER_DIM_IDX[1]], 2);
                maxDist = Math.max(maxDist, dist0 + dist1);
            }
        }
        var boundaryData = centroids
            ? [
                [
                    centroids[newCluIdx][0],
                    centroids[newCluIdx][1],
                    Math.sqrt(maxDist)
                ]
            ]
            : [];

        option.options.push({
            series: [{
                type: 'custom',
                encode: {
                    tooltip: [0, 1]
                },
                renderItem: renderItemPoint,
                data: data
            }, {
                type: 'custom',
                renderItem: renderBoundary,
                animationDuration: 3000,
                silent: true,
                data: boundaryData
            }]
        });
    }

    var targetRenderProgress = 0;

    option = {
        timeline: {
            top: 'center',
            right: 50,
            height: 300,
            width: 10,
            inverse: true,
            autoPlay: false,
            playInterval: 2500,
            symbol: 'none',
            orient: 'vertical',
            axisType: 'category',
            label: {
                formatter: 'step {value}',
                position: 10
            },
            checkpointStyle: {
                animationDuration: ANIMATION_DURATION_UPDATE
            },
            data: []
        },
        baseOption: {
            animationDurationUpdate: ANIMATION_DURATION_UPDATE,
            transition: ['shape'],
            tooltip: {
            },
            xAxis: {
                type: 'value'
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                type: 'scatter'
            }]
        },
        options: []
    };

    makeStepOption(option, originalData);
    option.timeline.data.push('0');
    for (var i = 1, stepResult; !(stepResult = step.next()).isEnd; i++) {
        makeStepOption(
            option,
            echarts.util.clone(stepResult.data),
            echarts.util.clone(stepResult.centroids)
        );
        option.timeline.data.push(i + '');
    }

    option && myChart.setOption(option);



</script>
</body>

</html>