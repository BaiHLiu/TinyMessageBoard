
document.write("<script language=javascript src='https://cdn.bootcdn.net/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>");

function logout()
{
    $.ajax({
        type: "post",
        url: "./php/logout.php",
        data: {},
        dataType: "json",
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