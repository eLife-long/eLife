<?php
require_once '../include.php';
@$id=$_REQUEST['id'];
$sql="select aName,aDesc,aTimes from eLife_active where id='{$id}'";
$row1=fetchOne($sql);
$rows=getAllStore();
if(!$rows){
    alertMes("没有校区，请先添加校区!!", "addCampus.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
</script>
</head>
<body>
<h3>添加商品</h3>
<form action="doAdminAction.php?act=editActive&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
<table width="100%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">活动名称</td>
		<td><input type="text" name="aName"  placeholder="<?php echo $row1['aName'];?>"/></td>
	</tr>
	<tr>
		<td align="right">所属商店</td>
		<td>
		<select name="sId">
			<?php foreach($rows as $row):?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['sName'];?></option>
			<?php endforeach;?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="right">活动次数</td>
		<td><input type="text" name="aTimes"  placeholder="<?php echo $row1['aTimes'];?>"/></td>
	</tr>
	<tr>
		<td align="right">商品描述</td>
		<td>
			<textarea name="aDesc" id="editor_id" style="width:100%;height:150px;"><?php echo $row1['aDesc'];?></textarea>
		</td>
	</tr>
<table width="100%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td colspan="2"><input type="submit"  value="编辑活动"/></td>
	</tr>
</table>
</form>
</body>
</html>