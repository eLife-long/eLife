<?php
require_once '../include.php';
$username=$_POST['username'];
$username=addslashes($username);//字符转义
$password=md5($_POST['password']);
$verify=$_POST['verify'];
$verify1=$_SESSION['verify'];
@$autoFlag=$_POST['autoFlag'];//这里没选中记住密码为什么报错？？？//复选框初始默认没有post??吗，只好加上@屏蔽警告
if($verify==$verify1){
    $sql="select * from eLife_admin where username='{$username}' and password='{$password}'";
    $row=checkAdmin($sql);
    if($row){
        //荣国选了一周内自动登录
        if($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*60*60);    
            setcookie("adminName",$row['username'],time()+7*24*60*60);    
        }
        $_SESSION['adminName']=$row['username'];
        $_SESSION['adminId']=$row['id'];
        alertMes("登录成功", "index.php");
    }else{
        alertMes("登录失败", "login.php");
    }
}else{
    alertMes("验证码错误", "login.php");
}
