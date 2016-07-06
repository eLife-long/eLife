<?php
/**
 * 添加活动
 * @return string
 */
function addActive(){
    $arr=$_POST;
    $arr['aPubtime']=time();
    if(insert("eLife_active",$arr)){
        $mes="添加活动成功!<br/><a href='addActive.php'>继续添加</a>|<a href='listActive.php'>查看活动列表</a>";
    }else{
        $mes="添加活动失败!<br/><a href='addActive.php'>重新添加</a>|<a href='listActive.php'>查看活动列表</a>";
    }
    return $mes;
}

/**
 * 编辑活动
 * @param int $id
 * @return string
 */
function editActive($where){
    $arr=$_POST;
    if(update("eLife_active", $arr,$where)){
        $mes="编辑成功！<br/><a href='listActive.php'>查看活动列表</a>|<a href='addActive.php'>添加活动</a>";
    }else{
        $mes="编辑失败！<br/><a href='editActive.php'>请重新编辑</a>|<a href='listActive.php'>查看活动列表</a>";
    }
    return $mes;
}

/**
 * 删除活动
 * @param int $id
 * @return string
 */
function delActive($id){
    $where = "id=" . $id;
    if (delete("eLife_active", $where)) {
        $mes = "删除成功！<br/><a href='listActive.php'>查看校区列表</a>";
    } else {
        $mes = "删除失败！<br/><a href='listActive.php'>请重新操作</a>";
    }
    return $mes;
}
/**
 * 通过页码获得校区的数量
 * @param int $page
 * @param int $pageSize
 * @return multitype:
 */
function getActiveByPage($page,$pageSize=2,$where=null){
    $sql="select a.id from eLife_active as a join eLife_store s on a.sId=s.id {$where}";
    global $totalRows;
    $totalRows=getResultNum($sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select a.id,a.aName,a.aTimes,a.aPubtime,a.aDesc,s.sName from eLife_active as a join eLife_store s on a.sId=s.id {$where} limit {$offset},{$pageSize}";
    @$rows=fetchAll($sql);
    return $rows;
}

/**
 * 获得所有活动
 * @return multitype:
 */
function getAllActive(){
    $sql="select id,aName from eLife_active";
    $rows=fetchAll($sql);
    return $rows;
}