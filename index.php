<?php
session_start();
if($_SESSION['user']=="")
{
    $login_status = "0";
    //用户未登录
}
else
{
    if($_SESSION['user'] == "admin")
    {
        $login_status="admin";
        //管理员登录
    }
    else
    {
        $login_status = $_SESSION['user'];
        //普通登录则状态码为用户名
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Catop's BBS</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/stevenjoezhang/live2d-widget/autoload.js"></script>
	<script src="./js/check_logout.js"></script>
	<script src="./js/posts.js"></script>
	<script src="./js/new-post.js"></script>
	<script src="./js/delete-post.js"></script>



	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid"> 
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target="#example-navbar-collapse">
			<span class="sr-only"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		
		<a class="navbar-brand" href="#">Catop's BBS</a>
		<!-- 发新帖开始 -->
		<button data-target="#myModal" data-toggle="modal" type="button" class="btn btn-primary glyphicon glyphicon-plus" style="position: relative; top:8px;right:5px;float:right;"></button>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel">
						Say something...
					</h4>
				</div>
				<div class="modal-body">
					<form class="bs-example bs-example-form" role="form">	
					<div class="input-group">
						<input type="text" id="newpost-title" class="form-control" placeholder="Title">
						<span class="input-group-addon glyphicon glyphicon-ok" ></span>
					</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-edit"></span>
							<textarea class="form-control" id="newpost-text" rows="6" placeholder="Some interesting...(up to 350 words)"></textarea>
						</div><br>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="newPost();">Submit</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>
	
	<!-- 发新帖结束 -->
	</div>
	
	<div class="collapse navbar-collapse" id="example-navbar-collapse">
		<!-- 搜索栏开始 -->
		<form class="navbar-form navbar-left" role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary">GO</button>
		</form>
		<!-- 搜索栏结束 -->
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<!-- 显示用户名或未登录 -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                    if($login_status=="0")
                    {
                        echo "Welcome";
                    }
                    else
                    {
                        echo "$login_status";
                    }
                ?>
                    
                     <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<!-- 用户管理下拉菜单 -->
                    <?php
                        if($login_status=="0")
                        {
							echo '<li><a href="./login.html">Login</a></li>
							<li><a href="./register.html">Register</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="#">Profile</a></li>
                            <li><a href="javascript:void(0);" onclick="logout();">Logout</a></li>';
                        }
                    ?>
				</ul>
			</li>
		</ul>
	</div>
	</div>
</nav>

<div class="container">
	<!-- 单个帖子开始 -->
	<div hidden="true" class="panel panel-info">

		
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#collapseThree"><!-- 标题 --></a>
					&nbsp;&nbsp;&nbsp;
					<span hidden="true" class="post-id"></span>
					<!-- span.post_id存放帖子id -->
					<span class="post-edit" hidden="true"><a href="javascript:void(0);" onclick="delete_post(this.parentNode.parentNode.children[1].innerText);" class="glyphicon glyphicon-trash"></a></span>
					<!-- 删除按钮 -->
					<span class="post-author" style="color: gray; font-weight:200;font-size:90%;float:right"><!-- 作者 --></span> 
					
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse in">  <!-- 加in属性表示默认展开 -->

				<div class="panel-body">

					<!-- 正文 -->
				</div>
				<div class="panel-body-plus" style="padding-right:10px;padding-bottom:10px;position:relative;bottom:10px">
					<span  class="post-time" style="color: gray; font-weight:200;font-size:80%;float:right;line-height:140%"><!-- 时间 --></span>
				</div>	
			</div>
		</div>
	</div>
	<!-- 单个帖子结束 -->


	<!-- 底栏 -->
	<div class="navbar-fixed-bottom">
		<div class="col-md-8 column">
			<!-- <button onclick="list_posts();" value="test">test</button> -->
		</div>
		<div class="col-md-4 column" style="float: right;">
			<ul class="pagination">
			<li><a href="#">&laquo;</a></li>
			<li id="1" class="active" ><a href="#" onclick='list_posts(1);' >1</a></li>
			<!-- 打开页面后默认加载第一页 -->
			<script>list_posts(1);</script>
			<li id="2"><a href="#" onclick='list_posts(2);' >2</a></li>
			<li id="3"><a href="#" onclick='list_posts(3);'>3</a></li>
			<li id="4"><a href="#" onclick='list_posts(4);'>4</a></li>
			<li id="5"><a href="#" onclick='list_posts(5);'>5</a></li>
			<li id="6"><a href="#">&raquo;</a></li>
			</ul>
		</div>
	</div>
</div>

</body>
</html>