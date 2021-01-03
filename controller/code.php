<?php
// 这个文件算是图片链接
require './codeController.php';
$captcha = new Captcha();
$captcha->createCode();
echo "sa";