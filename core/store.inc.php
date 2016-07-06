<?php
require_once '../include.php';
/**
 * 添加商品
 * @return string
 */
function addStore(){
    $arr=$_POST;
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['sImg']=$uploadFile[0]['name'];
    }else{
        return "添加失败<a href='addStore.php'>重新添加</a>";
    }
    if(insert("eLife_store", $arr)){
        $mes="添加成功!<br/><a href='addStore.php'>继续添加</a>|<a href='listStore.php'>查看列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes="添加失败!<br/><a href='addStore.php'>重新添加</a>|<a href='listStore.php'>查看列表</a>";
    }
    return $mes;
}

/**
 * 编辑商品
 * @param int $id
 * @return string
 */
function editStore($where){
    $arr=$_POST;
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['sImg']=$uploadFile[0]['name'];
    }else{
        return "编辑失败<a href='editStore.php'>重新编辑</a>";
    }
    if(update("eLife_store",$arr,$where)){
        $mes="编辑成功!<br/><a href='listStore.php'>查看列表</a>";
    }else{
        $mes="添加失败!<br/><a href='editStore.php'>重新编辑</a>|<a href='listStore.php'>查看列表</a>";
    }
    return $mes;
}

/**
 * 删除商品
 * @param int $id
 * @return string
 */
function delStore($id){
    $sql="select sImg from eLife_store where id=".$id;
    $row=fetchOne($sql);
    $sImg=$row['sImg'];
    if(file_exists("../uploads/".$sImg)){
        unlink("../uploads/".$sImg);
    }
    if(delete("eLife_store","id={$id}")){
        $mes="删除成功!<br/><a href='listStore.php'>查看用户列表</a>";
    }else{
        $mes="删除失败!<br/><a href='listStore.php'>请重新删除</a>";
    }
    return $mes;
}
/**
 * 通过分页得到所有商品
 * @param int $page
 * @param int $pageSize
 * @return multitype:
 */
function getStoreByPage($page,$pageSize,$where=null){
    $sql="select s.id from eLife_store as s {$where}";
    global $totalRows;
    $totalRows=getResultNum($sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select s.id,s.sName,s.sDesc,c.cName from eLife_store as s join eLife_campus c on s.cId=c.id {$where} limit {$offset},{$pageSize}";
    @$rows=fetchAll($sql);
    return $rows;
}

// function getAllStoreByAdmin(){
//     $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from eLife_store as p join imooc_cate c on p.cId=c.id";
//     $rows=fetchAll($sql);
//     return $rows;
// }

/**
 * 通过商品id得到商品的所有图片
 * @param int $id
 * @return multitype:
 */
function getAllImagByStoreId($id){
	$sql="select a.albumPath from imooc_album a where pid={$id}";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 * 通过商品id得到商品（关联商品分类）
 * @param unknown $id
 * @return //多类型？？？[]
 */
function getStoreById($id){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from eLife_store as p join imooc_cate c on p.cId=c.id where p.id={$id}";
    $row=fetchOne($sql);
    return $row;
}

/**
 * 检查分类下是否有商品
 * @param int $cId
 * @return array
 */
function checkStoreExist($cId){
    $sql="select * from eLife_store where cId={$cId}";
    $rows=fetchAll($sql);
    return $rows;
}

/**
 * 根据cid得到4条商品
 * @param int $cid
 * @return array
 */
function getStoresByCid($cid){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from eLife_store as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4";
    $rows=fetchAll($sql);
    return $rows;
}

/**根据cid得到下四条商品
 * @param int $cid
 * @return array
 */
function getSmallStoresByCid($cid){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from eLife_store as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
    $rows=fetchAll($sql);
    return $rows;
}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getAllStore(){
    $sql="select id,sName from eLife_store";
    $rows=fetchAll($sql);
    return $rows;
}