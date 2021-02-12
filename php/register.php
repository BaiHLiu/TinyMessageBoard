<?php
header('Content-Type:application/json; charset=utf-8');
include "../inc/conn.php";
include "./filter.php";
$ret_msg = array();

// 检查用户是否在已登录的状态下注册，判断注册合法性并写入数据库
session_start();
if(!empty($_SESSION['user']))
{
    $ret_msg['errcode'] = 1;
    $ret_msg['msg'] = "You have already logged in!";
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
        return(htmlspecialchars(filter($str),ENT_QUOTES));
    }
}



$name = strhand($_POST['name']);
$email = strhand($_POST['email']);
$password = strhand($_POST['password']);
$vcode = strhand($_POST['vcode']);





function check_email($email)
{
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strstr($email,"@")) {
        return true;
    } else {
        return false;
    }
}


function check_passwd($pwd)
{
    if (strlen($pwd)>30 || strlen($pwd)<6)
	{
		return false;
    }
    else
    {
        return true;
    }
    

}


// if(!ctype_alnum($name) || strlen($name)>20 || strlen($name)<1)
if(strlen($name)>20 || strlen($name)<1)
{
    $ret_msg['errcode'] = 1;
    $ret_msg['msg'] = "Username must be number or letter,1-20 characters";
    echo(json_encode($ret_msg));
    die();
}

if(!check_email($email) || strlen($name)>30 || strlen($name)<1)
{
    $ret_msg['errcode'] = 1;
    $ret_msg['msg'] = "The email address is invalid,1-30 characters";
    echo(json_encode($ret_msg));
    die();
}

if(!check_passwd($password))
{
    $ret_msg['errcode'] = 1;
    $ret_msg['msg'] = "Password must be 6-30 characters";
    echo(json_encode($ret_msg));
    die();
}



try{
    $db->beginTransaction();
    //判断用户名是否被占用
    $stmt = $db->prepare("SELECT * FROM bbs_user WHERE bbs_username=? LIMIT 1");
    $stmt->execute(array($name));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['bbs_username']!="")
    {
        $ret_msg['errcode'] = 1;
        $ret_msg['msg'] = "Sorry,the username has already used";
        echo(json_encode($ret_msg));
        die();
    }
    //判断邮箱是否被占用
    $stmt = $db->prepare("SELECT * FROM bbs_user WHERE bbs_useremail=? LIMIT 1");
    $stmt->execute(array($email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['bbs_useremail']!="")
    {
        $ret_msg['errcode'] = 1;
        $ret_msg['msg'] = "The e-mail has already registered~";
        echo(json_encode($ret_msg));
        die();
    }


    $stmt = $db->prepare("INSERT INTO bbs_user (bbs_username,bbs_useremail,bbs_userpasswd,bbs_usertime) VALUES (?,?,?,?)");
    $password_md5 = md5($password);
    $stmt->execute(array($name,$email,$password_md5,date("Y-m-d H:i:s")));
 
    //提交事务
    $db->commit();
    $ret_msg['errcode'] = 0;
    $ret_msg['msg'] = "Successfully registered!";
    $_SESSION['user'] = $name;
    echo(json_encode($ret_msg));

}
//PDOException类
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
