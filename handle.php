<?php
// 公共函数文件
$action = $_GET['action'];
switch ($action) {
    case 'getcode':
        # 获取验证码
        return code();
        break;
    case 'checkcode':
        # 验证验证码
        return checkcode();
        break;
    default:
        # code...
        break;
}
function checkcode(){
    session_start();
    $code=$_GET['code'];
	if($code!=$_SESSION['code']){
        // 验证码错误
        echo 0;
        exit;
    }
}

function code()
{
    session_start();
    $str = '0123456789';
    $num = '';
    for ($i = 0; $i < 4; $i++) {
        $num .= substr($str, rand(0, 9), 1);
    }
    $_SESSION['code'] = $num; //存入session,方便不同页面的比较

    $im = imagecreate(60, 20); //宽/高
    $write = imagecolorallocate($im, 255, 255, 255); //白色为底色
    $blue = imagecolorallocate($im, 0, 0, 255); //文本颜色
    //绘制干扰信息
    for ($i = 0; $i < 200; $i++) {
        $x = rand(0, 60);
        $y = rand(0, 20);
        $color = imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255));
        imagechar($im, 1, $x, $y, '*', $color);
    }
    //绘制文本
    $chrX = rand(3, 8);
    for ($i = 0; $i < 4; $i++) {
        $chrY = rand(1, 6);
        imagechar($im, 5, $chrX, $chrY, substr($num, $i, 1), $blue);
        $chrX += rand(8, 12);
    }


    header('content-type:image/gif'); //设置网页输出类型
    imagegif($im);
}
