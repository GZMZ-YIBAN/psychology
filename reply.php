<?php
/*
foreach($_POST as $k=>$v){
	file_put_contents('data.txt',$k.'=>'.$v."\r\n",FILE_APPEND | LOCK_EX);
}
*/
require('config.php');
require 'app_config.php';    
require_once('SUBMAILAutoload.php');
date_default_timezone_set('Asia/Shanghai'); 
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ //连接成功errno应该为0
    die('Connect Error:'.$mysqli->connect_error);
}
$mysqli->set_charset('utf8');
$events = $_POST['events'];
$phone = $_POST['address'];
$message = $_POST['content'];
$timestamp = $_POST['timestamp'];
$token = $_POST['token'];
$signature = $_POST['signature'];
$very = md5($token.'0265649ecafe8812cee1427c1af93870');
if($very == $signature){
  	//上行短信处理
    if($events == 'mo' && $message != false){
    	$stats = explode('#',$message);
		$id = $stats[0];
		$query = $mysqli->query('select tel from boardroom where id='.$id);
		if($query == true){
			$row = $query->fetch_assoc();
		}
		$tel = $row[tel];
      	if($stats[1] == "同意"){
			$update = $mysqli->query('UPDATE boardroom SET status = 1 WHERE id ='.$id);
			if($update == true){
				$submail=new MESSAGEXsend($message_configs);    
				$submail->setTo($tel);
				$submail->SetProject('ZRoPy3');
				$submail->AddVar('id',$stats[0]);
				$xsend=$submail->xsend();   
			}
        }elseif($stats[1] == "拒绝"){
			$update = $mysqli->query('UPDATE boardroom SET status = 0 WHERE id ='.$id);
			if($update == true){
				$submail=new MESSAGEXsend($message_configs);    
				$submail->setTo($tel);
				$submail->SetProject('I2izW4');
				$submail->AddVar('status',$stats[2]);
				$xsend=$submail->xsend();
			}
		}else{
        }
	}
}else{
	echo '签名验证失败';
}
?>