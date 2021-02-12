//ajax提交登录并获取结果
document.write("<script language=javascript src='https://cdn.bootcdn.net/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>");
function login() 
{
    var email = $("#login_email").val();
    var password = $("#login_password").val();
    var vcode = $("#login_vcode").val();

    $.ajax({
        type: "post",
        url: "./php/login.php",
        data: {"email":email,"password":password,"vcode":vcode},
        dataType: "json",//后端返回json数据
        success: function(msg){
            var json_errcode = msg['errcode'];
            var json_msg = msg['msg'];
            // console.log(msg['msg']);
            if(json_errcode==0)
            {
                swal({
                icon: "success",
                text: json_msg,
                }).then(function () {
                    window.location.href = "./index.php";
                    
                })
            }
            else
            {
                swal({
                    icon: "error",
                    text: json_msg,
                })
            }

        }
    });
}