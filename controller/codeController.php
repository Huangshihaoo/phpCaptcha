<?php
// 验证码所有功能全在这个类里面
class Captcha
{
    // 验证码
    private $code = '';
    // 验证码长度
    private $codeLength = 4;
    // 验证码字符集
    private $seeds = '0123456789abcdefghijklnmopqrstuvwxyz';

    // 公开方法 生成随机验证码
    public function createCode()
    {
        $this->code = '';

        for ($i = 0; $i < $this->codeLength; $i++) {
            // 随机取codeLength个字符生成验证码
            $this->code .= $this->seeds[rand(0, strlen($this->seeds) - 1)];
        }
        // 保存验证码
        $this->saveCode($this->code);
        // 生成验证图片
        $this->createimage($this->code, 150, 50);
    }

    // 私有方法 保存验证码 $code 传入要保存的验证码
    private function saveCode($code)
    {
        session_start();
        $_SESSION['code'] = $code;
        $_SESSION['codeTime'] = time();
        session_commit();
    }

    // 私有方法 生成验证码图片 $code验证码， $width 验证码图片宽， $height验证码图片高
    private function createimage($code, $width, $height)
    {
        // 创建画布
        $image = @imagecreate($width, $height) or die("画布创建失败");
        // 生成半透明画布
        $translucence = imagecolorallocatealpha($image, 255, 255, 255, 0);
        // 随机文字颜色
        $rundColor = imagecolorallocate($image, rand(150, 200), rand(150, 200), rand(150, 200));
        // 绘制文字
        // $str = 'a3h5';
        // 字体路径
        $font = "font/AbelBecker-Light-Italic.ttf";
        // GD库环境变量 这个东西要非常注意
        putenv('GDFONTPATH=' . realpath('..'));
        // 写字
        imagettftext($image, 30, 0, 30, 40, $rundColor, $font, $code);

        // 创建几条线
        $num = 8;

        for ($i = 0; $i < $num; $i++) {
            // 随机颜色
            $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            // 随机像素点
            // imagesetpixel($image, rand(0, 150), rand(0, 50), $color);
            // 随机线段
            imageline($image, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $color);
        }
        // 输出png格式图片
        header('Content-type:image/png');
        // 保存到文件夹
        // imagepng($image,'img/code.png');
        // 我即链接
        imagepng($image);
        // 释放图片资源
        imagedestroy($image);
    }

    // 公开方法 验证图片验证码
    public function checkCode($code)
    {
        // 最主要验证码不为空
        if (!empty($code)) {
            // 1.Session中的验证码为空判定过期
            if (empty($_SESSION['code'])) {
                echo "验证码已过期";
                return false;
            }
            // 有时间存在
            if (!empty($_SESSION['codeTime'])) {
                // 转成数字
                $codeTime = (int) $_SESSION['codeTime'];
                // 生成此刻时间，以作比较
                $currentTimr = time();
                //2. 验证码生成时间超过1分钟 判定验证码过期并清掉验证码
                if ($currentTimr - $codeTime > 60) {
                    unset($_SESSION['code']);
                    unset($_SESSION['codeTime']);
                    echo '验证码已过期';
                    return false;
                }
            }
            // 3.全小写后验证码与Session中的不匹配 判定验证码不匹配 strtolower() 转全小写
            if (strtolower($code) != $_SESSION['code']) {
                echo "验证码不匹配";
                return false;
            }
            // 以上三种全通过 清掉验证码 返回true
            unset($_SESSION['code']);
            unset($_SESSION['codeTime']);
            echo "验证通过";
            return true;
        }
        return false;
    }
}
