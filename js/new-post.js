function newPost()
{
    var title = $("#newpost-title").val();
    var text = $("#newpost-text").val();

    $.ajax({
        type: "post",
        url: "./php/new-post.php",
        data: {"title":title,"text":text},
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