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


    <table class="layui-hide" id="demo" lay-filter="test"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="delete">删除</a>
        <a class="layui-btn layui-btn-sm" lay-event="edit">修改</a>
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
                    , url: '../../application/dataAnalysis/ranking_list.php'//数据接口
                    , parseData: function (res) { //res 即为原始返回的数据
                        console.log(res)
                    }
                    , limit: 15
                    , method: 'post'
                    , title: '用户表'
                    , page: true //开启分页
                    //,toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
                    , totalRow: false //开启合计行
                    , cols: [[ //表头
                        {field: 'rank', title: '序号', width: 80, sort: true, fixed: 'left'}
                        , {field: 'name', title: '动漫名称', width: 130, fixed: 'left'}
                        , {field: 'view', title: '播放量', width: 80}
                        , {field: 'followAnime', title: '追番人数', width: 100, totalRow: true}
                        , {field: 'bullet', title: '弹幕数量', width: 100}
                        , {field: 'animeType', title: '动漫类型', width: 100}
                        , {field: 'comments', title: '评论数量', width: 80}
                        , {field: 'collection', title: '收藏数量', width: 150}
                        , {field: 'score', title: '评分', width: 150}
                        ,{field: 'url', title: '介绍链接', width: 150,templet:
                                '<div><a href="{{d.url}}" class="layui-table-link" target="_blank">{{d.url}}</a></div>'}
                , {field: 'updateTime', title: '动漫更新时间', width: 150}
                , {fixed: 'right', width: 200, align: 'center', toolbar: '#barDemo'}
        ]]
        });

            table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data//获得当前行数据
                    ,layEvent = obj.event;//获得 lay-event 对应的值

                if(layEvent === 'delete'){
                    layer.confirm('真的删除行么', function(index){
                        deluser(data,index,obj);
                        table.reload();
                    });
                }else if(layEvent === 'edit'){
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
                             <label class="layui-form-label">序号</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="rank" lay-verify="title" value="'+datas.rank+'" autocomplete="off" placeholder="请输入编号" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">动漫名称</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="name" lay-verify="title" value="'+datas.name+'" autocomplete="off" placeholder="请输入编号" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">播放量</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="view" lay-verify="title" value="'+datas.view+'" autocomplete="off" placeholder="请输入编号" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">追番人数</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="followAnime" lay-verify="title" value="'+datas.followAnime+'" autocomplete="off" placeholder="请输入编号" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">弹幕数量</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="bullet" value="'+datas.bullet+'" lay-verify="title" autocomplete="off" placeholder="请输入名称" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">动漫类型</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="animeType" value="'+datas.animeType+'" lay-verify="title" autocomplete="off" placeholder="请输入角色" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">评论数量</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="comments" value="'+datas.comments+'" lay-verify="title" autocomplete="off" placeholder="请输入角色" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">收藏数量</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="collection" value="'+datas.collection+'" lay-verify="title" autocomplete="off" placeholder="请输入角色" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">评分</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="score" value="'+datas.score+'" lay-verify="title" autocomplete="off" placeholder="请输入描述" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">介绍链接</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="url" value="'+datas.url+'" lay-verify="title" autocomplete="off" placeholder="请输入描述" class="layui-input">\
                             </div>\
                           </div>\
                           \<div class="layui-form-item">\
                             <label class="layui-form-label">介绍链接</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="updateTime" value="'+datas.updateTime+'" lay-verify="title" autocomplete="off" placeholder="请输入描述" class="layui-input">\
                             </div>\
                           </div>\
                       </form>';


                    layer.open({
                        type: 1,
                        title: '编辑',
                        content: editHtml,
                        area: ['1200px', '800px'],
                        btn: ['提交', '取消'],
                        yes: function (layIndex) {
                            $.ajax({
                                url: '../../application/dataAnalysis/rankingEdit.php',    //这个是后台的路由地址
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


            });

        });
    </script>
</div>
</body>
</html>