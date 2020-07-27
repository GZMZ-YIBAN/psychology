<?php
/*****************************
***　短信上行接收处理文件　***
*****************************/
//心理咨询接收处理文件
file_put_contents('1.txt',var_export($_POST,true));
require_once('config.php');  
require_once('submail/app_config.php');    
require_once('submail/SUBMAILAutoload.php');
date_default_timezone_set('Asia/Shanghai'); 
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ 
    die('Connect Error:'.$mysqli->connect_error);
}
$mysqli->set_charset('utf8');
$events = $_REQUEST['events'];
$phone = $_REQUEST['address'];
$message = $_REQUEST['content'];
$timestamp = $_REQUEST['timestamp'];
$token = $_REQUEST['token'];
$signature = $_REQUEST['signature'];
$very = md5($token.'fcc99b933f4eb7b35a63d55336b127a4');
if($very == $signature){
  	//上行短信处理
    if($events == 'mo' && $message != false){
    	$stats = explode('#',$message);
		$id = $stats[0];
		$query = $mysqli->query('select `phone`,`name`,`type` from `psychology` where sid='.$id);
		if($query == true){
			$row = $query->fetch_assoc();
		}
		$phone = $row['phone'];
        $name = $row['name'];
        $type = $row['type'];
      	if($stats[1] == "通过"){
			$update = $mysqli->query('UPDATE psychology SET state = 1 WHERE sid ='.$id);
			if($update == true){
				$submail=new MESSAGEXsend($message_configs);    
				$submail->setTo($phone);
				$submail->SetProject('NAZwE2');
				$submail->AddVar('name',$name);
                $submail->AddVar('type',$type);
                $submail->AddVar('date',$stats[2]);
				$xsend=$submail->xsend();
				
			}
        }elseif($stats[1] == "失败"){
			$update = $mysqli->query('UPDATE psychology SET state  = 0 WHERE sid ='.$id);
			if($update == true){
				$submail=new MESSAGEXsend($message_configs);    
				$submail->setTo($phone);
				$submail->SetProject('7m1pS1');
				$submail->AddVar('name',$name);
    $submail->AddVar('reason',$stats[2]);
				$xsend=$submail->xsend();
			}
		}else{
        }
	}
}else{
	echo '签名验证失败';
}
?>