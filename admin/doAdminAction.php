<?php
require_once '../include.php';
$act=$_REQUEST['act'];
@$id=$_REQUEST['id'];
if($act=="logout"){
    logout();
}elseif($act=="addAdmin"){
   $mes=addAdmin();
}elseif($act=="editAdmin"){
    $where="id={$id}";
    $mes=editAdmin($where);
}elseif($act=="delAdmin"){
    $where="id={$id}";
    $mes=delAdmin($where);
}elseif($act=="addCampus"){
    $mes=addCampus();
}elseif($act=="editCampus"){
    $where="id={$id}";
    $mes=editCampus($where);
}elseif($act=="delCampus"){
    $mes=delCampus($id);
}elseif($act=="addStore"){
    $mes=addStore();
}elseif($act=="editStore"){
    $where="id={$id}";
    $mes=editStore($where);
}elseif($act=="delStore"){
    $mes=delStore($id);
}elseif($act=="addActive"){
    $mes=addActive();
}elseif($act=="editActive"){
    $where="id={$id}";
    $mes=editActive($where);
}elseif($act=="delActive"){
    $mes=delActive($id);
}elseif($act=="addUser"){
	$mes=addUser();
}elseif($act=="delUser"){
		$mes=delUser($id);
}elseif($act=="editUser"){
	$mes=editUser($id);	
}elseif($act=="addProImag"){
    $mes=addProImag($id);
}elseif($act=="waterText"){
	$mes=doWaterText($id);
}elseif($act=="waterPic"){
	$mes=doWaterPic($id);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php 
	if($mes){
		echo $mes;
	}
?>
</body>
</html>