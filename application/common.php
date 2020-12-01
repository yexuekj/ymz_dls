<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function getStrNum($str)
{
    $times = 0;
    for($i=0;$i < strlen($str);$i++){
        if(is_numeric($str[$i])){
            $times++;
        }
    }
    return $times;
}

function setToken($userId)
{
    $token = md5(date('YmdHis',time()).rand(100,999));
    $times = getStrNum($token);
    return $token. ($times + $userId);
}

/**
 * 合成图片
 * @param  array   $pic_list  [图片列表数组]
 * @param  boolean $is_save   [是否保存，true保存，false输出到浏览器]
 * @param  string  $save_path [保存路径]
 * @return boolean|string
 */
function getGroupAvatar($pic_list = [],$is_save = true,$save_path = 'static/group_head/'){

    $img_name = date('Ymd',time()).'/'.date('YmdHis',time()).rand(1000,9999).'.png';
    $save_path.= $img_name;
    //验证参数
    if(empty($pic_list) || empty($save_path)){
        return false;
    }
    if($is_save){
        //如果需要保存，需要传保存地址
        if(empty($save_path)){
            return false;
        }
    }
    // 只操作前9个图片
    $pic_list = array_slice($pic_list, 0, 9);
    //设置背景图片宽高
    $bg_w = 150; // 背景图片宽度
    $bg_h = 150; // 背景图片高度
    //新建一个真彩色图像作为背景
    $background = imagecreatetruecolor($bg_w,$bg_h);
    //为真彩色画布创建白灰色背景，再设置为透明
    $color = imagecolorallocate($background, 202, 201, 201);
    imagefill($background, 0, 0, $color);
    imageColorTransparent($background, $color);
    //根据图片个数设置图片位置
    $pic_count = count($pic_list);
    $lineArr = array();//需要换行的位置
    $space_x = 3;
    $space_y = 3;
    $line_x = 0;
    switch($pic_count) {
        case 1: // 正中间
            $start_x = intval($bg_w/4); // 开始位置X
            $start_y = intval($bg_h/4); // 开始位置Y
            $pic_w = intval($bg_w/2); // 宽度
            $pic_h = intval($bg_h/2); // 高度
            break;
        case 2: // 中间位置并排
            $start_x = 2;
            $start_y = intval($bg_h/4) + 3;
            $pic_w = intval($bg_w/2) - 5;
            $pic_h = intval($bg_h/2) - 5;
            $space_x = 5;
            break;
        case 3:
            $start_x = 40; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w/2) - 5; // 宽度
            $pic_h = intval($bg_h/2) - 5; // 高度
            $lineArr = array(2);
            $line_x = 4;
            break;
        case 4:
            $start_x = 4; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w/2) - 5; // 宽度
            $pic_h = intval($bg_h/2) - 5; // 高度
            $lineArr = array(3);
            $line_x = 4;
            break;
        case 5:
            $start_x = 30; // 开始位置X
            $start_y = 30; // 开始位置Y
            $pic_w = intval($bg_w/3) - 5; // 宽度
            $pic_h = intval($bg_h/3) - 5; // 高度
            $lineArr = array(3);
            $line_x = 5;
            break;
        case 6:
            $start_x = 5; // 开始位置X
            $start_y = 30; // 开始位置Y
            $pic_w = intval($bg_w/3) - 5; // 宽度
            $pic_h = intval($bg_h/3) - 5; // 高度
            $lineArr = array(4);
            $line_x = 5;
            break;
        case 7:
            $start_x = 53; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w/3) - 5; // 宽度
            $pic_h = intval($bg_h/3) - 5; // 高度
            $lineArr = array(2,5);
            $line_x = 5;
            break;
        case 8:
            $start_x = 30; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w/3) - 5; // 宽度
            $pic_h = intval($bg_h/3) - 5; // 高度
            $lineArr = array(3,6);
            $line_x = 5;
            break;
        case 9:
            $start_x = 5; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w/3) - 5; // 宽度
            $pic_h = intval($bg_h/3) - 5; // 高度
            $lineArr = array(4,7);
            $line_x = 5;
            break;
    }
    foreach( $pic_list as $k=>$pic_path ) {
        $kk = $k + 1;
        if ( in_array($kk, $lineArr) ) {
            $start_x = $line_x;
            $start_y = $start_y + $pic_h + $space_y;
        }
        //获取图片文件扩展类型和mime类型，判断是否是正常图片文件
        //非正常图片文件，相应位置空着，跳过处理
        $image_mime_info = @getimagesize($pic_path);
        if($image_mime_info && !empty($image_mime_info['mime'])){
            $mime_arr = explode('/',$image_mime_info['mime']);
            if(is_array($mime_arr) && $mime_arr[0] == 'image' && !empty($mime_arr[1])){
                switch($mime_arr[1]) {
                    case 'jpg':
                    case 'jpeg':
                        $imagecreatefromjpeg = 'imagecreatefromjpeg';
                        break;
                    case 'png':
                        $imagecreatefromjpeg = 'imagecreatefrompng';
                        break;
                    case 'gif':
                    default:
                        $imagecreatefromjpeg = 'imagecreatefromstring';
                        $pic_path = file_get_contents($pic_path);
                        break;
                }
                //创建一个新图像
                $resource = $imagecreatefromjpeg($pic_path);
                //将图像中的一块矩形区域拷贝到另一个背景图像中
                // $start_x,$start_y 放置在背景中的起始位置
                // 0,0 裁剪的源头像的起点位置
                // $pic_w,$pic_h copy后的高度和宽度
                imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource));
            }
        }
        // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
        $start_x = $start_x + $pic_w + $space_x;
    }
    if($is_save){
        $dir = pathinfo($save_path,PATHINFO_DIRNAME);
        if(!is_dir($dir)){
            $file_create_res = mkdir($dir,0777,true);
            if(!$file_create_res){
                return false;//没有创建成功
            }
        }
        $res = imagejpeg($background,$save_path);
        imagedestroy($background);
        if($res){
            return $save_path;
        }else{
            return false;
        }
    }else{
        //直接输出
        header("Content-type: image/jpg");
        imagejpeg($background);
        imagedestroy($background);
    }
}



/**
 * 获取视频第一帧
 * @param $file
 * @param $time
 * @param $name
 */
function getVideoCover($file,$name,$time = 1) {
    //默认截取第一秒第一帧
    $strlen = strlen($file);
    // $videoCover = substr($file,0,$strlen-4);
    // $videoCoverName = $videoCover.'.jpg';//缩略图命名
    //exec("ffmpeg -i ".$file." -y -f mjpeg -ss ".$time." -t 0.001 -s 320x240 ".$name."",$out,$status);
    $str = "ffmpeg -i ".$file." -y -f mjpeg -ss 3 -t ".$time." -s 200x80 ".$name;
    //echo $str."</br>";
    $result = system($str);
    return $result;
}


/**
 * 获取视频长度
 * @param $file
 * @return float|int
 */
function getTime($file){
    $time = exec("ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");//总长度
    $duration = explode(":",$time);
    $duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);//转化为秒
    return $duration_in_seconds;
}


/**
 * 请求发送
 * @param $url
 * @param $params
 * @param string $body
 * @param bool $isPost
 * @param bool $isImage
 * @return mixed
 */
function http_request($url, $params, $body="", $isPost=false, $isImage=false ) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url."?".http_build_query($params));
    if($isPost){
        if($isImage){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: multipart/form-data;',
                    "Content-Length: ".strlen($body)
                )
            );
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: text/plain'
                )
            );
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


/**
 * @param $data
 * @return mixed
 */
function setDataTime($data)
{
    foreach ($data as $v){
        if(!empty($v['created_at'])){
            $v['created_at'] = date('Y-m-d H:i:s',$v['created_at']);
        }
        if(!empty($v['updated_at'])){
            $v['updated_at'] = date('Y-m-d H:i:s',$v['updated_at']);
        }
    }
    return $data;
}




/*
 * 经典的概率算法，
 * $proArr是一个预先设置的数组，
 * 假设数组为：array(100,200,300，400)，
 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
 * 这样 筛选到最终，总会有一个数满足要求。
 * 就相当于去一个箱子里摸东西，
 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
 * 这个算法简单，而且效率非常高，
 * 这个算法在大数据量的项目中效率非常棒。
 */
function get_rand($proArr) {
    $result = '';
    //概率数组的总概率精度
    $proSum = array_sum($proArr);
    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);
    return $result;
}


// 返回信息 ajax
function returnAjax($code=0,$msg='success',$data=array(),$url=''){
    $result['code'] = $code;
    $result['msg']  = $msg;
    $result['data'] = $data;
    $result['url']  = $url;
    return json_encode($result,256);
}



