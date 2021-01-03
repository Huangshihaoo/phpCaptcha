<?php
// 请求接收检查验证码是否正确
session_start();
require './codeController.php';
// 判断post参数是否为空
if (!empty($_POST['code'])) {
    $controller = new Captcha();
    // 这个return很重要，发送请求后将结果返回
    // return不是重要因素 请求头必须设置
    return $controller->checkCode($_POST['code']);
}
