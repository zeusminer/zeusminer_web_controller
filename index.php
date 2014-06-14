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
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

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
                  <li class="active"><a href="index.php"><i class="fa fa-star"></i> About</a></li>
                  <li><a href="setting.php"><i class="fa fa-cog"></i> Setting</a></li>
                  <li><a href="tail.php"><i class="fa fa-tachometer"></i> Status</a></li>
                  <li><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><i class="fa fa-bitcoin"></i> Donate</a></li>
              </ul>
          </div><!--/.nav-collapse -->
      </div>
    </div>
    
	<!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Donate</h4>
                </div>
                <div class="modal-body">
                    <p>If you like the controller,welcome to donate.</p>
                    <p>BTC: <a href="bitcoin:1jWGYEcj8zdVekvtTFKUC6hfzEKUuq4z3?amount=0.01&label=Tyson">1jWGYEcj8zdVekvtTFKUC6hfzEKUuq4z3</a></p>
                    <p>LTC: <a href="litecoin:LLWfdDAfcwS1oW3Mnv1tzzQrER1oZTs1GY?amount=0.5&label=Tyson">LLWfdDAfcwS1oW3Mnv1tzzQrER1oZTs1GY</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 class="intro_title">Welcome to the Raspberry Pi Controller for Zeusminer</h1>
        <p>Here you can set the pool address,worker name,password,frequency,clock for the miner and monitor its status.This controller is production of Zeus Team and bases on Raspberry Pi.If you meet any problems or you have any suggestions during use of the controller,please feedback to <a href="mailto:cs@zeusminer.com">cs@zeusminer.com</a>.</p>
        <!--<p>在这里，你可以设置宙斯矿机工作的矿池地址、矿工名、密码、挖矿频率等参数，并监控所有挖矿进程的状态。该控制器基于树莓派设计，宙斯团队出品，如在使用过程中，有任何意见和建议，欢迎反馈至cs@zeusminer.com。</p>-->
        <p><a href="setting.php" class="btn btn-primary btn-lg" role="button"><i class="fa fa-magic"></i> Go setting &raquo;</a></p>
      </div>

    </div> <!-- /container -->

    <?php include('footer.php'); ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
  </body>
</html>
