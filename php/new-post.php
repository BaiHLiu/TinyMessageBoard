<?php
header('Content-Type:application/json; charset=utf-8');
session_start();
include "../inc/conn.php";
include "./filter.php";
$ret_msg = array();

function ret_exit($errcode,$msg)
{
    //返回json数据并退出脚本
    $ret_msg['errcode'] = "$errcode";
    $ret_msg['msg'] = "$msg";
    echo(json_encode($ret_msg));
    die();

}

function strhand($str)
{
    //通用基本过滤
    $str = urldecode(trim($str));
    if(strstr($str," ") || strstr($str,"=") || strstr($str,"%") || strstr($str,"'") || strstr($str,'"') || strstr($str,"\\") || strstr($str,"/"))
    {
        ret_exit(1,"Invalid string, please check your input!");
    }
    else
    {
        return($str);
    }
}

if(empty($_SESSION['user']))
{
    ret_exit(1,"Please login in first~");
}


$post_user = $_SESSION['user'];
#$post_title = filter($_POST['title']);
$post_title = $_POST['title'];
#$post_text = filter($_POST['text']);
$post_text = $_POST['text'];
$post_time = date("Y-m-d H:i:s");

if(empty($post_title) || empty($post_text))
{
    ret_exit(1,"Input some text and try again~");
}

if(strlen($post_title)>=80 || strlen($post_text)>=380)
{
    ret_exit(1,"The number of words in the title or text exceeds the limit!");
}

try
{
    $db->beginTransaction();
    $stmt = $db->prepare("SELECT bbs_userid FROM bbs_user WHERE bbs_username=? LIMIT 1");
    $stmt->execute(array($post_user));
    $userid = $stmt->fetch(PDO::FETCH_ASSOC)['bbs_userid'];

    $stmt = $db->prepare("INSERT INTO bbs_post(bbs_postuser,bbs_posttitle,bbs_postcontent,bbs_posttime) VALUES (?,?,?,?)");
    $stmt->execute(array($userid,$post_title,$post_text,$post_time));
    

    $db->commit();
    ret_exit(0,"Success!");
}
catch(PDOException $pdoerr)
{
    ret_exit(2,"Sorry, some errors occured on our system :(");
}


?>