<?php
session_start();
include "../inc/conn.php";

function ret_exit($errcode,$msg)
{
    //返回json数据并退出脚本
    $ret_msg['errcode'] = "$errcode";
    $ret_msg['msg'] = "$msg";
    echo(json_encode($ret_msg));
    die();

}

if(empty($_SESSION['user']))
{
    ret_exit(1,"Please login first.");
}

if(!is_numeric($_POST['id']) || strlen($_POST['id']<0 || strlen($_POST['id'])>5 ))
{
    ret_exit(1,"Post id invalid");
}

$username = $_SESSION['user'];
$postid = $_POST['id'];


try
{
    $db->beginTransaction();
    $stmt = $db->prepare("SELECT bbs_userid FROM bbs_user WHERE bbs_username=?");
    $stmt->execute(array($username));
    $userid_1 = $stmt->fetch(PDO::FETCH_ASSOC)['bbs_userid'];

    $stmt = $db->prepare("SELECT bbs_postuser FROM bbs_post WHERE bbs_postid=?");
    $stmt->execute(array($postid));
    $userid_2 = $stmt->fetch(PDO::FETCH_ASSOC)['bbs_postuser'];

    if($userid_1===$userid_2)
    {
        $stmt = $db->prepare("DELETE FROM bbs_post WHERE bbs_postid=? LIMIT 1");
        $stmt->execute(array($postid));
    }
    else
    {
        $db->rollBack();
        ret_exit(1,"Invalid post id");
    }

    $db->commit();
    ret_exit(0,"Delete successfully!");

}
catch(PDOException $pdoerr)
{
    $db->rollBack();
    ret_exit(2,"Sorry, some errors occured on our system :(");
}





?>