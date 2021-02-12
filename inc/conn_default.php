<?php

$dbms='mysql';             //数据库类型
$host='localhost';         //数据库主机名
$dbName='';            //数据库名
$user='';              //数据库连接用户名
$pass='';                  //密码
$dsn="$dbms:host=$host;dbname=$dbName";


$db = new PDO($dsn,$user,$pass);
//关闭pdo自动提交
$db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
//设置EXCEPTION异常处理模式
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

?> 

