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
    <!-- 公共样式 结束 -->

    <!--		<style>-->
    <!--			.layui-form{-->
    <!--				margin-right: 20%;-->
    <!--			}-->
    <!--		</style>-->
</head>

<body>
<div class="cBody">
    <div class="console">
        <form class="layui-form" action="">
            <!--					<div class="layui-form-item">-->
            <!--						<div class="layui-input-inline">-->
            <!--							<input type="text" name="name" required lay-verify="required" placeholder="输入博物馆名称" autocomplete="off" class="layui-input">-->
            <!--						</div>-->
            <!--						<button class="layui-btn" lay-submit lay-filter="formDemo">检索</button>-->
            <!--					</div>-->
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
                ,height: 800
                ,url: '../../application/comments/comment_data.php'//数据接口
                ,parseData: function(res){ //res 即为原始返回的数据
                    console.log(res)
                }
                ,limit:15
                ,method:'post'
                ,title: '用户表'
                ,page: true //开启分页
                //,toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
                ,totalRow: false //开启合计行
                ,cols: [[ //表头
                    {field: 'order', title: '序号', width:80, sort: true, fixed: 'left'}
                    ,{field: 'animeName', title: '动漫名称', width:150,  fixed: 'left'}
                    ,{field: 'nickName', title: '用户昵称', width: 300}
                    ,{field: 'likes', title: '点赞数', width: 200, totalRow: true}
                    ,{field: 'comment', title: '用户评论', width:200}
                    ,{field: 'time', title: '藏评论时间', width: 150}
                    ,{fixed: 'right', width: 200, align:'center', toolbar: '#barDemo'}
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
                    $.ajax({
                        url: '../../application/collection/collection_delete.php',    //这个是后台的路由地址
                        type: "POST",
                        data:{"collectionID":data.collectionID},//传给后台的值
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
                             <label class="layui-form-label">藏品编号</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="collectionID" lay-verify="title" value="'+datas.collectionID+'" autocomplete="off" placeholder="请输入藏品编号" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">博物馆编号</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="museumID" value="'+datas.museumID+'" lay-verify="title" autocomplete="off" placeholder="请输入博物馆编号" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">藏品介绍</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="collectionIntroduction" value="'+datas.collectionIntroduction+'" lay-verify="title" autocomplete="off" placeholder="请输入藏品介绍" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">藏品链接</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="collectionImageLink" value="'+datas.collectionImageLink+'" lay-verify="title" autocomplete="off" placeholder="请输入藏品链接" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">藏品名字</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="collectionName" value="'+datas.collectionName+'" lay-verify="title" autocomplete="off" placeholder="请输入藏品名字" class="layui-input">\
                             </div>\
                           </div>\
                           <div class="layui-form-item">\
                             <label class="layui-form-label">博物馆名字</label>\
                             <div class="layui-input-block">\
                               <input type="text" name="museumName" value="'+datas.museumName+'" lay-verify="title" autocomplete="off" placeholder="请输入博物馆名字" class="layui-input">\
                             </div>\
                           </div>\
                       </form>';

                    layer.open({
                        type: 1,
                        title: '编辑',
                        content: editHtml,
                        area: ['500px', '420px'],
                        btn: ['提交', '取消'],
                        yes: function (layIndex) {
                            $.ajax({
                                url: '../../application/collection/collection_edit.php',    //这个是后台的路由地址
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