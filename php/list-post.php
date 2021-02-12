<?php
//列出前10条帖子信息，并返回json

header('Content-Type:application/json; charset=utf-8');
session_start();
$ret_msg = array();
$pageNum = $_POST['pageNum'];
//只允许传入整数页码，并且1-10页
if(!(ctype_digit($pageNum) && $pageNum>=1 && $pageNum<=10))
{
    $ret_msg['errcode'] = '2';
    $ret_msg['msg'] = 'Sorry, our system encounted some error :(';
    echo(json_encode($ret_msg));
    die();
}


include "../inc/conn.php";
try
{
    $db->beginTransaction();
    //获取帖子最大id
    $stmt = $db->prepare("SELECT MAX(bbs_postid) FROM bbs_post");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxPostId = $row['MAX(bbs_postid)'];
    $post_id_min = ($pageNum-1)*10;


    //获取最新10条帖子
    $stmt_getpost = $db->prepare("SELECT * FROM bbs_post ORDER BY bbs_postid DESC LIMIT ?,10");
    $stmt_getpost->bindParam(1,$post_id_min,PDO::PARAM_INT);
    $stmt_getpost->execute();
    $rows_post = $stmt_getpost->fetchAll(PDO::FETCH_ASSOC);
    
    $ret_msg['errcode'] = 0;
    $ret_msg['postnum'] = count($rows_post);  //条数
    $ret_msg['postct'] = array(); //内容
    $ret_msg['msg'] = "";
    if(empty($_SESSION['user']))
    {
        $ret_msg['current_user'] = "";
    }
    else
    {
        $ret_msg['current_user'] = $_SESSION['user'];     //当前用户
    }


    for($i=0;$i<count($rows_post);$i++)
    {
        //获取发帖用户信息
        $stmt_getuser = $db->prepare("SELECT * FROM bbs_user WHERE bbs_userid=? LIMIT 1");
        $stmt_getuser->execute(array($rows_post[$i]['bbs_postuser']));
        $row_user = $stmt_getuser->fetch(PDO::FETCH_ASSOC);
        
        //帖子总体信息
        $ret_msg['postct'][$i] = array();
        $ret_msg['postct'][$i]['postid'] = $rows_post[$i]['bbs_postid'];
        $ret_msg['postct'][$i]['username'] = $row_user['bbs_username'];
        $ret_msg['postct'][$i]['title'] = $rows_post[$i]['bbs_posttitle'];
        $ret_msg['postct'][$i]['content'] = $rows_post[$i]['bbs_postcontent'];
        $ret_msg['postct'][$i]['time'] = substr($rows_post[$i]['bbs_posttime'],0,19);
        


    }

    $db->commit();
    echo(json_encode($ret_msg));

}
catch(PDOException $pdoerr)
{
    $db->rollBack();
    $ret_msg['errcode'] = '2';
    $ret_msg['msg'] = 'Sorry, our system encounted some error :(';
    echo(json_encode($ret_msg));

}



?>