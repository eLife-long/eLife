<?php
require_once '../include.php';
/**
 * 链接数据库
 * @return resource
 */
function connect(){
//      $link=mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error:".mysql_errno().":".mysql_error());
//      mysql_set_charset(DB_CHARSET);
//      mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
//      return $link;
//在新版本的php中用旧版本mysql_connect链接数据库的方式用引起验证码出不来，为什么？还会引起其他的错误吗
     $link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_DBNAME,DB_PORT,DB_CHARSET) or die("数据库连接失败Error:".mysqli_errno().":".mysqli_error());
//      var_dump($link);
     return $link;
}
/**
 * 完成记录插入操作
 * @param string $talbe
 * @param array $array
 * @return number
 */
function insert($table,$array){
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table}($keys) values({$vals})";
    $link=mysqli_query(connect(),$sql);
    return $link;
}

//update imooc_admin set username='king',username2='king2' where id=1;
/**
 * 完成更新操作
 * @param string $table
 * @param array $array
 * @param string $where
 * @return number
 */
function update($table,$array,$where=null){
    $str=null;
    foreach ($array as $key=>$val){
        if($str==null){
            $sep="";
        }else{
            $sep=",";
        }
        $str.=$sep.$key."='".$val."'";
    }
    $sql="update {$table} set {$str} ".($where==null?null:" where ".$where);
    $link=mysqli_query(connect(),$sql);
    return $link;
}

/**
 * 完成删除操作
 * @param string $table
 * @param string $where
 * @return number
 */
function delete($table,$where=null){
    $where=$where==null?null:" where ".$where;
    $sql="delete from {$table} {$where}";
    $link=mysqli_query(connect(),$sql);
    return $link;
}

//MYSQL_ASSOC关联数组
/**
 * 得到指定一条记录
 * @param string $sql
 * @param string $result_type
 * @return multitype://多类型？？？
 */
function fetchOne($sql,$result_type=MYSQLI_ASSOC){
    $result=mysqli_query(connect(),$sql);
    @$row=mysqli_fetch_array($result,$result_type);
    return $row;
}

/**
 * 得到结果集中所有记录...
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchAll($sql,$result_type=MYSQLI_ASSOC){
    $result=mysqli_query(connect(),$sql);
    while(@$row=mysqli_fetch_array($result,$result_type)){//前面的@加上后不弹出错误信息
        $rows[]=$row;
    }
    return @$rows;
}

// $sql="select * from imooc_admin";
// $rows=fetchAll($sql);
// var_dump($rows);
// exit;

/**
 * 得到结果集中记录的条数
 * @param string $sql
 * @return number
 */
function getResultNum($sql){
    $result=mysqli_query(connect(),$sql);
    return mysqli_num_rows($result);
}

// /**
//  * 得到上一步插入记录的id号
//  * @return number
//  */
// function getInsertId(){
//     return mysqli_insert_id(connect());
// }
//mysqli_insert_id这个函数再该版本的php中已经弃用了















