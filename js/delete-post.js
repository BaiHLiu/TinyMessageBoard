function delete_post(id)
{
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this post!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            delete_post_ok(id);
        } else {
          
        }
      });

}



function delete_post_ok(id)
{
    swal(
        {

        }
    )
    
    $.ajax({
        type: "post",
        url: "./php/delete-post.php",
        data: {"id":id},
        dataType: "json",
        success: function(msg){
            
            var json_errcode = msg['errcode'];
            var json_msg = msg['msg'];

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