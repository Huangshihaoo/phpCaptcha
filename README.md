# 验证码系统

写在前面：这是一个php验证码系统，基于**GD库加Session**实现，难点不多，在下文项目总结中集中说，这个项目极好的练习了php面向对象编程（php功能大体全靠一个类）。

> GD库是一个开源的用于创建图形图像的函数库，该函数库由C语言编写，可以在 Perl，PHP 等多种语言中使用。GD 库中提供了一系列用来处理图片的 API（接口），使用 GD 库可以处理图片、生成图片，也可以给图片加水印等。

## 文件描述

|-- README.md  // 描述文件

|-- controller

|   |-- check.php // 检查验证码是否正确

|   |-- code.php // 验证码路径

|   |-- codeController.php // 一系列验证码功能类

|-- font

|   |-- AbelBecker-Light-Italic.ttf // 字体文件

|-- index.html // 显示页面

## 项目总结

1. 第一点练的是gd库操作生成验证码，gd库的操作不难，看文档能很快实现想要的效果，有一点要注意的是**gd库的环境变量**`putenv('GDFONTPATH=' . realpath('..'));` 我是加了一层文件夹这边写了两个点，当这个文件和font文件夹在同级目录时只要一个点，
2. 第二点要熟悉的是Session的应用**存session**时一套操作，以及**取Session**时最前面`session_start();`要注意。

	```php
	session_start();
	$_SESSION['code'] = $code;
	$_SESSION['codeTime'] = time();
	session_commit();
	```


3. 第三点是类中公开方法和私有方法的使用，整个Captcha类中有四个方法，生成验证码和检查验证码公开，保存验证码和生成验证码图片私有。

   

4. 还有一些php自带函数的使用就不详细展开了，常用的随机数方法`[rand(0, 10)`、字符串长度统计`strlen($str)`、变量是否为空`empty($code)`、获取session销毁session`$_SESSION['code']; unset($_SESSION['code']);`类中属性的调用`*$this*->code;`等等等等

   

5. 前端js中一个获取新图片的奇技淫巧，也不是第一次用了`img.src = './controller/code.php?t=' + new Date().getTime();`挺实用的。

   

6. 最后一点原生post请求中容易忽略的请求头的设置，这个是前后端联合的一个小坑，可能是我不常用，踩到这个坑了。

   

7. 以上总结可能有错

​	