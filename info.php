<?php
require('config.php');
date_default_timezone_set('Asia/Shanghai'); 
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ //连接成功errno应该为0
    die('Connect Error:'.$mysqli->connect_error);
}
$mysqli->set_charset('utf8');
$query = $mysqli->query("select * from psychology order by CreateTime DESC limit 0,10");
if($query == true){
	$list = $query->fetch_all(MYSQLI_ASSOC);
$total = count($list);
}else{
	echo $mysqli->error;
}

 $verify_request = '';
    if(@$_COOKIE["verify_request"] == true || @$_GET["verify_request"] == true){
      if(@$_COOKIE["verify_request"]){
        $verify_request = $_COOKIE["verify_request"];
      }
      if(@$_GET["verify_request"]){
        $verify_request = $_GET["verify_request"];
      }

  }
if($verify_request){
      $postStr = pack("H*", $verify_request);
      $postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, 'cd67615d613165d42f67401fe0342690', $postStr, MCRYPT_MODE_CBC, 'b19046a4baf4e76f');
      $postInfo = rtrim($postInfo);
      $postArr = json_decode($postInfo,true);
      /** 解密verify_request后取得用户数据
      echo $postArr['visit_user']['userid'];
      echo $postArr['visit_user']['username'];
      **/
      //成功获取登录信息后保存到COOKIE
    
      if($_COOKIE['verify_request'] == false && $postArr['visit_user']['username'] == true){
        setcookie("verify_request", $_GET["verify_request"], time()+3600);
        setcookie("uid", $postArr['visit_user']['userid'], time()+3600);
      }

}else{
    die("<script>alert('请先登录才能使用！');self.location='index.php?act=login'</script>");
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8"> 
	<title>会议室在线预约</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
	p{
		text-indent:2em;
	}
	td,th{
		text-align:center;
	}
	th{
		background-color:#fff;
	}
	.select{
		width:100%;
		margin-bottom:10px;
		text-align:center;
		font-weight:bold;
		font-size:1em;
		border: 1px solid #000;
		border-radius:8px;
		background-color:#fff;
		height:32px;
	}
	input[type=submit]{
		text-align:center;
		font-weight:bold;
		font-size:1em;
		border-width:2;
		border-color:#000;
		border-radius:8px;
		width:100%;
		background-color:#fff;
		height:32px;
		}
	.panel-primary>.panel-heading{
		color:#fff;
		background-color: #00a65a;
		border-color:#00a65a;
	}
	.navbar-inverse .navbar-nav >li>a:focus, .navbar-inverse .navbar-nav>li>a:hover{
		background-color:transparent;
		color: #fff;
	}
	.navbar-inverse{
		background-color:#3c8dbc;
		border-color:#3c8dbc;
		color: #fff;
	}
	.navbar-inverse .navbar-nav>li>a{
		color:#fff;
	}
	.navbar-inverse .navbar-toggle:focus, .navbar-inverse .navbar-toggle:hover{
		background-color: #3c8dbc;
	}
	.navbar-inverse .navbar-toggle {
    	border-color: #fff;
	}
	   .col-md-8,.col-md-4{
		padding-right:5px;
		padding-left:5px;
	}
	.navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus, .navbar-inverse .navbar-nav>.open>a:hover {
		color: #fff;
		background-color: rgba(40, 98, 130, 0.32);
	}
	.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
		color: #fff;
		background-color: rgba(40, 98, 130, 0.32);
	}
	.navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
		color: #c0dcd8;
	}

	*{
		font-family: 微软雅黑;
	}
	.panel{
		margin:0 auto; 
		max-width:700px;
	}
	.alert{
		margin:0 auto;
		margin-top:5px;
		max-width:700px;
		height:80px;
	}
	.div-img{
	    background-color: rgba(255, 255, 255, 0.3);
		display: block;
		padding: 10px;
	}
	.box-text {
		border: 1px solid white;
		color: blue;
		font-style: italic;
		width: 100%;
		height: 100%;
	}
	.title-text {
		font-size: 3.8em;
		padding-top: 20px;
		padding-bottom: 25px;
		text-align: center;
	}
	.btn_form{
		width:100%;
		margin-top:4px;
	}
	.alert {
		margin: 0 auto;
		margin-top: 5px;
		max-width: 700px;
		height: auto;
	}
     .panel-body>.div{
       text-align:center;
      }
	</style>
</head>
<body scrollTop="0">
<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a href="index.php" class="navbar-brand">
				心理
			</a>
			<button class="navbar-toggle collapsed" data-toggle="collapse"  data-target="#mynavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
		</div>
		<div id="mynavbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-calendar"></span>&nbsp;首页</a></li>

			</ul>
			<!-- 导航条中的下拉菜单 -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  &nbsp;<?php echo $postArr['visit_user']['username'].'(uid:'.$postArr['visit_user']['userid'].')';?></a>
				</li>
			</ul>
		</div>
</nav>
	<div class="container">	
	
     <div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
			<h6>通知信息</h6>
			</div>
		</div>
		<div class="panel-body">
			<p class="alert alert-warning">请先对照下表并确定所要预约的时间，避免与其他人预约的时间产生冲突，在审核时将按提交的先后顺序进行审核，时间冲突的将取消本次预约。<u>为了倡导实名登记，实名预约，现在需使用易班登录方可使用本系统！！</u></p>
			<div class="div"><label class="col-md-6"><a class="btn btn-warning btn_form" href='./'>立即申请预约</a></label>
			<label class="col-md-6"><a class="btn btn-info btn_form" href='#'>暂无</a></label></div>
		</div>
	</div>
      <br />
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					心理预约人员详状态细表
				</div>	
			</div>
			<table class="table table-striped table-hover table-bordered">
				<tr>
					<th>姓名</th>
					<th>类型</th>
					<th>时间</th>
					<th>校区</th>
					<th>状态</th>
				</tr>
				
				<?php 
				$i=0;
				while($i < $total){
					echo "<tr>";
					echo "<td>{$list[$i]['name']}</td>";
					echo "<td>{$list[$i]['type']}</td>";
					echo "<td>{$list[$i]['CreateTime']}</td>";
					if($list[$i]['campus'] == 1){
						echo "<td>新校区</td>";
					}else{
						echo "<td>老校区</td>";
					}
					if($list[$i]['state'] == -1){
						   		echo "<td><span class=\"label label-warning\">等待处理</span></td>";
					}elseif($list[$i]['status'] == 0){
					     	echo "<td><span class=\"label label-danger\">审核失败</span></td>";

					}else{
							echo "<td><span class=\"label label-success\">通过审核</span></td>";
					}
					echo "</tr>";
					$i++;
				}?>
				

		<!--		
				<tr>
					<td>001</td>
					<td>002</td>
					<td>003</td>
					<td><span class="label label-danger">审核失败</span></td>
				</tr>
				<tr>
					<td>001</td>
					<td>002</td>
					<td>003</td>
					<td><span class="label label-success">审核通过</span></td>
				</tr>
				<tr>
					<td>001</td>
					<td>002</td>
					<td>003</td>
					<td><span class="label label-success">审核通过</span></td>
				</tr>
				<tr>
					<td>001</td>
					<td>002</td>
					<td>003</td>
					<td><span class="label label-success">审核通过</span></td>
				</tr>
				-->
			</table>
		</div>
</div>
</body>
<script>
</script>
</html>