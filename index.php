<?php
require_once('config.php');  
require_once('submail/app_config.php');    
require_once('submail/SUBMAILAutoload.php');
date_default_timezone_set('Asia/Shanghai');  //设置时区为上海
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ //连接成功errno应该为0
    die('Connect Error:'.$mysqli->connect_error);
}
$mysqli->set_charset('utf8'); //设置数据库编码为utf8
if($_GET['act'] == 'login'){
   	header('location:https://oauth.yiban.cn/code/html?client_id=0393752b3531233e&redirect_uri=http://f.yiban.cn/iapp197005&state=rains');
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
      $postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '51056bb8d4f68733795ead3be969cc68', $postStr, MCRYPT_MODE_CBC, '0393752b3531233e');
      $postInfo = rtrim($postInfo);
      $postArr = json_decode($postInfo,true);
      /** 解密verify_request后取得用户数据
      echo $postArr['visit_user']['userid'];
      echo $postArr['visit_user']['username'];
      **/
      //成功获取登录信息后保存到COOKIE
    
      if($_COOKIE['verify_request'] == false && $postArr['visit_user']['username'] == true){
        setcookie("verify_request", $_GET["verify_request"], time()+3600);
      }else{
        //die("<script>self.location='index.php?act=login'</script>");
      }

}else{
    die("<script>self.location='index.php?act=login'</script>");
}
?>
<!doctype html>
<html>
<head>
<title>心理咨询预约系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- font files -->
<!--
 <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
-->
<!-- /font files -->
<!-- css files -->
<link href="css/style.css" rel='stylesheet' type='text/css' media="all" />
<!-- /css files -->
</head>
<body>
<h1>心理咨询 预约系统</h1>
<div class="form-w3ls">
    <ul class="tab-group cl-effect-4">
		<li class="tab active"><a href="#signup-agile">填写信息 - 【<?php echo $postArr['visit_user']['username'];?>】</a></li>  
		<li class="tab active"><a href="info.php">申请对照表</a></li>
    </ul>
    <div class="content">
		<div id="signup-agile">   
			<form action="" method="post">
              
				<p class="header">校区</p>
				<select name="campus">
                  <option value="1" selected>大学城党武校区</option>
                  <option value="2">花溪十里河滩校区</option>
                </select>
              
				<p class="header">姓名</p>
				<input type="text" name="name" placeholder="Your Full Name" required>
				
				<p class="header">电话</p>
				<input type="tel" name="phone" placeholder="Your Phone Number" required>
              
                <p class="header">专业班级</p>
				<input type="text" name="class" placeholder="Your major and class" required>
              
				<p class="header">咨询类型？</p>
				<select name="type">
                  <option value="学习压力">学习压力</option>
                  <option value="睡眠质量">睡眠质量</option>
                  <option value="情感受挫">情感受挫</option>
                  <option value="家庭矛盾">家庭矛盾</option>
                  <option value="交际困难">交际困难</option>
                  <option value="其他">其他</option>
                  <!--<option value="1">选项七</option>-->
                </select>
              <!--注释取消表单-->
				<!--<p class="header">几号咨询？</p>
				<select name="date">
                  <?php for($i=0;$i<7;$i++){ ?>
                  <option value="<?php echo date("Y-m-d",strtotime("+$i day"));?>"><?php echo date("Y-m-d",strtotime("+$i day"));?></option>
                  <?php } ?>
                </select>

                <p class="header">几点咨询？</p>
                  <select name="time">
                    <option value="7:00">清晨七点</option>
                    <option value="7:30">清晨七点半</option>
                    <option value="8:00">早上八点</option>
                    <option value="8:30">早上八点半</option>
                    <option value="9:00">早上九点</option>
                    <option value="9:30">早上九点半</option>
                    <option value="10:00">早上十点</option>
                    <option value="10:30">早上十点半</option>
                    <option value="11:00">中午十一点</option>
                    <option value="11:30">中午十一点半</option>
                    <option value="14:00">中午两点</option>
                    <option value="14:30">中午两点半</option>
                    <option value="15:00">下午三点</option>
                    <option value="15:30">下午三点半</option>
                    <option value="16:00">下午四点</option>
                    <option value="16:30">下午四点半</option>
                    <option value="17:00">下午五点</option>
                    <option value="17:30">下午五点半</option>
                    <option value="18:00">傍晚六点</option>
                    <option value="18:30">傍晚六点半</option>
                    <option value="19:00">傍晚七点</option>
                  </select>
				-->
				<input type="submit" name="submit" class="register" value="立即预约">
			</form>
		</div> 
    </div><!-- tab-content -->
</div> <!-- /form  -->	  
<p class="copyright"> Copyright © 2018 Powered By Rains</p>
<!-- js files -->
<script src='js/jquery.min.js'></script>
<!-- /js files -->
<?php
  if(@$_POST['submit'] == '立即预约'){
	$sql = "insert into `psychology` (`uid`,`name`,`phone`,`class`,`type`,`CreateTime`,`campus`)values(?,?,?,?,?,?,?)";
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('isssssi',$postArr['visit_user']['userid'],$_POST['name'],$_POST['phone'],$_POST['class'],$_POST['type'],date('Y-m-d H:i:s'),$_POST['campus']);
    if($mysqli_stmt->execute()){
      	echo "<script>alert('已经登记了你的信息，请留意稍候预约成功的短信');</script>";
      	$submail=new MESSAGEXsend($message_configs); 
		if($_POST['campus'] == 1){
			$submail->setTo($tel_new);
		}else{
			$submail->setTo($tel_old);
		}
		$submail->SetProject('VMEMy1');
		$submail->AddVar('name',$_POST['name']);
        $submail->AddVar('class',$_POST['class']);
        $submail->AddVar('tel',$_POST['phone']);
        $submail->AddVar('type',$_POST['type']);
        $submail->AddVar('id',$mysqli_stmt->insert_id);
		$xsend=$submail->xsend(); 
      // var_dump($xsend);
    }else{
      echo "<script>alert('预约信息登记失败，请重新填写');</script>";
    }
  }
 ?>
</body>
</html>
