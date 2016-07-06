<?php
/**
 * 构建上传文件信息
 * @return array
 */
function buildInfo(){
    if(!$_FILES){
        return;
    }
    $i=0;
    foreach ($_FILES as $v){
        //单文件
        if(is_string($v['name'])){//如des_big.jpg是字符串
            $files[$i]=$v;
            $i++;
        }else{//多文件这$v['name']时数组array，不是字符串
            //多文件
            foreach ($v['name'] as $key=>$val){
                $files[$i]['name']=$val;//$v['name'][$key];key=0,1,2...
                $files[$i]['size']=$v['size'][$key];
                $files[$i]['tmp_name']=$v['tmp_name'][$key];//临时文件名
                $files[$i]['error']=$v['error'][$key];
                $files[$i]['type']=$v['type'][$key];//mine类型
                $i++;
            }
        }
    }
    return $files;
}

function uploadFile($path="uploads",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true){
    if(!file_exists($path)){
        mkdir($path,0777,true);
    }
    $i=0;
    $files=buildInfo();
    if(!($files&&is_array($files))){
        //文件不存在或者文件不是数组
        return ;
    }
    foreach ($files as $file){
        //var_dump($file);
        if($file['error']===UPLOAD_ERR_OK){
            $ext=getExt($file['name']);
            //检测文件扩展名
            if(!in_array($ext,$allowExt)){
                exit("非法文件类型");
            }
            //校验是否是一个真正的图片类型,默认imgFlag=true,表示校验
            if($imgFlag){
                if(!getimagesize($file['tmp_name'])){
                    exit("不是真正的图片类型");
                }
            }
            //上传文件的大小,默认maxSize=2M
            if($file['size']>$maxSize){
                exit("上传文件过打");
            }
            if(!is_uploaded_file($file['tmp_name'])){
                exit("不是通过HTTP POST方式上传上来的");
            } 
            //取得唯一文件名
            $filename=getUniName().".".$ext;
            //目标路径
            $destination=$path."/".$filename;
            //移入目标路径
            if(move_uploaded_file($file['tmp_name'], $destination)){//这里要操作的是临时文件
                $file['name']=$filename;
                unset($file['tmp_name'],$file['size'],$file['type']);
                $uploadedFiles[$i]=$file;
                $i++;
            }
        }else{
            switch($file['error']){
                case 1:
                    $mes = "超过了配置文件上传文件的大小"; // UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes = "超过了表单设置上传文件的大小"; // UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes = "文件部分被上传"; // UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes = "没有文件被上传1111"; // UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes = "没有找到临时目录"; // UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes = "文件不可写"; // UPLOAD_ERR_CANT_WRITE;
                    break;
                case 8:
                    $mes = "由于PHP的扩展程序中断了文件上传"; // UPLOAD_ERR_EXTENSION
                    break;
            }
            echo $mes;
        }
    }
    return $uploadedFiles;
}

