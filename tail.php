<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.ico">

    <title>Raspberry Pi Controller for Zeusminer by Tyson</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link href="css/docs.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body role="document">

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">RPC for Zeusminer</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><i class="fa fa-star"></i> About</a></li>
                <li><a href="setting.php"><i class="fa fa-cog"></i> Setting</a></li>
                <li class="active"><a href="tail.php"><i class="fa fa-tachometer"></i> Status</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<div class="container theme-showcase" role="main" id="log_container">
    <script type="text/x-handlebars-template" id="log_tpl">
        {{#if port}}
        <!-- 设备导航切换 -->
        <ul class="nav nav-tabs">
            {{#port}}
            <li class="{{#unless @index}}active{{/unless}}"><a href="javascript:void(0)" class="tabs-link" nav-index="{{this}}">{{this}}</a>
            </li>
            {{/port}}
        </ul>
        <div class="log-output-container">
            {{#port}}
            <div class="log-output{{#unless @index}} log-output-current{{/unless}}" id="log_output_{{this}}"></div>
            {{/port}}
        </div>
        {{else}}
        <div class="alert alert-danger">
            <strong>Note：</strong>Can not detect miner.
        </div>
        {{/if}}
    </script>
</div>
<!-- /container -->

<?php include('footer.php'); ?>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/docs.min.js" type="text/javascript"></script>
<script src="js/handlebars-v1.3.0.js" type="text/javascript"></script>

<script type="text/javascript">
    //获取矿机列表
    (function get_miner_port() {
        $.ajax({
            type: "POST",
            url: "PHPCgminer.php?action=port",
            dataType: "text",
            success: function (data) {
                var port_arr = data.split(',');
                //var port_arr = ['ttyUSB0', 'ttyUSB1', 'ttyUSB2'];
                //去掉空值
                for (var i = 0; i < port_arr.length; i++) {
                    if (port_arr[i] == "" || typeof(port_arr[i]) == "undefined") {
                        port_arr.splice(i, 1);
                        i = i - 1;
                    }
                }
                var port_data = { port: port_arr};
                //渲染模板
                $('#log_container').handlebars($('#log_tpl'), port_data);

                //矿机切换
                $('.tabs-link').click(function () {
                    $('.nav-tabs>li').removeClass('active');
                    $(this).parent().addClass('active');

                    var nav_index = $(this).attr('nav-index');
                    $('.log-output').removeClass('log-output-current');
                    $('#log_output_' + nav_index).addClass('log-output-current');
                });

                //每两秒刷新一次log信息
                var last_lines = [];
                for(var i=0;i<port_arr.length;i++){
                    last_lines[i] = 0;
                }
                function log_refresh(port,last_line,index) {
                    $.ajax({
                        type: "POST",
                        url: "PHPCgminer.php?action=log",
                        data:{port:port,last_line:last_line},
                        dataType: "json",
                        success: function (data) {
                            //console.log(data);
                            if(data.output_content.length>0){
                                var output_content = '<br/>'+data.output_content.join('<br/>');

                                //添加log数据
                                $('#log_output_'+port).append(output_content);

                                //滚动到底部
                                var output_log_div = $('#log_output_'+port)[0];
                                output_log_div.scrollTop = output_log_div.scrollHeight;
                            }
                            // 保存当前行号
                            last_lines[index] = parseInt(data.output_line);
                        },
                        error: function () {
                            $('#log_output_'+port).append('Fail to get status..<br/>');

                            //滚动到底部
                            var output_log_div = $('#log_output_'+port)[0];
                            output_log_div.scrollTop = output_log_div.scrollHeight;
                        }
                    });
                }

                for(var i=0;i<port_arr.length;i++){
                    log_refresh(port_arr[i],last_lines[i],i);
                }
                window.setInterval(function(){
                    for(var i=0;i<port_arr.length;i++){
                        log_refresh(port_arr[i],last_lines[i],i);
                    }
                },2000);
            },
            error: function () {
                alert('Fail to get device port');
            }
        });
    })();
</script>
</body>
</html>
