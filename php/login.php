<?php
header('Content-Type:application/json; charset=utf-8');
include "../inc/conn.php";
include "./filter.php";
$ret_msg = array();

// 检查用户是否在已登录的状态下重复登录
session_start();
if(!empty($_SESSION['user']))
{
    $username = $_SESSION['user'];
    $ret_msg['errcode'] = 0;
    $ret_msg['msg'] = "You have already logged as $username!";
    echo(json_encode($ret_msg));
    die();
}

function strhand($str)
{
    //通用基本过滤
    $str = urldecode(trim($str));
    if(strstr($str," ") || strstr($str,"=") || strstr($str,"%") || strstr($str,"'") || strstr($str,'"') || strstr($str,"\\") || strstr($str,"/"))
    {
        $ret_msg['errcode'] = 1;
        $ret_msg['msg'] = "Invalid string, please check your input!"; 
        echo(json_encode($ret_msg));
        die();
    }
    else
    {
        return(htmlspecialchars(filter($str)));
    }
}


$email = strhand($_POST['email']);
$password = strhand($_POST['password']);
$vcode = strhand($_POST['vcode']);

try{
    $db->beginTransaction();
    $stmt = $db->prepare("SELECT * FROM bbs_user WHERE bbs_useremail=? LIMIT 1");
    $stmt->execute(array($email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['bbs_userpasswd'] == md5($password))
    {
        $ret_msg['errcode'] = 0;
        $username = $row['bbs_username'];
        $ret_msg['msg'] = "Welcome,$username!";
        echo(json_encode($ret_msg));

        $_SESSION['user'] = "$username";
    }
    else
    {
        $db->commit();
        $ret_msg['errcode'] = 1;
        $ret_msg['msg'] = "UserName or Passwd Invalid";
        echo(json_encode($ret_msg));
    }
}

catch(PDOException $pdoerr)
{
    //回滚事务
    $db->rollBack();
    //echo($password_md5);
    $ret_msg['errcode'] = 2;
    $ret_msg['msg'] = "Sorry, some errors occured on our system :(";
    echo(json_encode($ret_msg));
    //die($pdoerr);
    die();
}


?>