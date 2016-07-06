<?php
/**
 * 添加校区
 * @return string
 */
function addCampus(){
    $arr=$_POST;
    if(insert("eLife_campus",$arr)){
        $mes="添加分类成功!<br/><a href='addCampus.php'>继续添加</a>|<a href='listCampus.php'>查看校区列表</a>";
    }else{
        $mes="添加分类失败!<br/><a href='addCampus.php'>重新添加</a>|<a href='listCampus.php'>查看校区列表</a>";
    }
    return $mes;
}

/**
 * 编辑校区
 * @param int $id
 * @return string
 */
function editCampus($where){
    $arr=$_POST;
    if(update("eLife_campus", $arr,$where)){
        $mes="编辑成功！<br/><a href='listCampus.php'>查看校区列表</a>|<a href='addCampus.php'>添加校区</a>";
    }else{
        $mes="编辑失败！<br/><a href='editCampus.php'>请重新编辑</a>|<a href='listCampus.php'>查看校区列表</a>";
    }
    return $mes;
}

/**
 * 删除校区
 * @param int $id
 * @return string
 */
function delCampus($id){
    $res=checkStoreExist($id);//判断该分类下是否有商品存在，有则要先删除改分类下的商品才能删除改分类
    if(!$res){
        $where="id=".$id;
        if(delete("eLife_campus",$where)){
            $mes="删除成功！<br/><a href='listCampus.php'>查看校区列表</a>";
        }else{
            $mes="删除失败！<br/><a href='listCampus.php'>请重新操作</a>";
        }
        return $mes;
    }else{
        alertMes("不能删除该分类，请先删除该校区下的商店","listStore.php");
    }
}
/**
 * 通过页码获得校区的数量
 * @param int $page
 * @param int $pageSize
 * @return multitype:
 */
function getCampusByPage($page,$pageSize=2){
    $sql="select id from eLife_campus";
    global $totalRows;
    $totalRows=getResultNum($sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select * from eLife_campus limit {$offset},{$pageSize}";
    $rows=fetchAll($sql);
    return $rows;
}

/**
 * 获得所有校区
 * @return multitype:
 */
function getAllCampus(){
    $sql="select id,cName from eLife_campus";
    $rows=fetchAll($sql);
    return $rows;
}