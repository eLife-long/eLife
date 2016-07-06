<?php 
function reg(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile();
	
	//print_r($uploadFile);
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
//	print_r($arr);exit;
	if(insert("imooc_user", $arr)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}
function login(){
	$username=$_POST['username'];
	//addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	$username=mysqli_escape_string(connect(),$username);
	$password=md5($_POST['password']);
	$sql="select * from imooc_user where username='{$username}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['username']=$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}

function userOut(){//这里退出之后后台管理的也退出了，给session_name()参数??
	//$_SESSION=array();//这里设置为空数组会导致后台也一起跟着退出
	$_SESSION['username']=null;
	$_SESSION['loginFlag']=null;
	if(isset($_COOKIE[session_name("username")])){
		setcookie(session_name("username"),"",time()-1);
	}
	//session_destroy();//这里关闭session会导致后台也一起跟着退出
	unset($_SESSION['username']);
	unset($_SESSION['loginFlag']);
	header("location:index.php");
}


