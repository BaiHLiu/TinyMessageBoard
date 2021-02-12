<?php
header('Content-Type:application/json; charset=utf-8');
session_start();
$ret_msg = array();

if($_SESSION['user'] == "")
{
    $ret_msg['errcode'] = 1;
    $ret_msg['msg'] = "You haven't logged in yet~";
    echo(json_encode($ret_msg));
}
else
{
    $_SESSION['user'] = "";
    $ret_msg['errcode'] = 0;
    $ret_msg['msg'] = "Bye!";
    echo(json_encode($ret_msg));
}

?>