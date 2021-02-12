document.write("<script language=javascript src='https://cdn.bootcdn.net/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>");

function register() 
{
    var name = $("#register_name").val();
    var email = $("#register_email").val();
    var password = $("#register_password").val();
    var vcode = $("#register_vcode").val();

    $.ajax({
        type: "post",
        url: "./php/register.php",
        data: {"name":name,"email":email,"password":password,"vcode":vcode},
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
                    window.location.href = "./index.php"
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

