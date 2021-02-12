function change_dom(dom_title,dom_author,dom_time,dom_content,dom_id,current_user)  //增加dom节点
{
    var post = document.getElementsByClassName("panel panel-info")[0];
    post.hidden = true;
    var newpost = post.cloneNode(true);
    newpost.hidden = false;  //新节点不设置隐藏
    post.parentNode.appendChild(newpost);
    newpost.getElementsByTagName("a")[0].innerText = dom_title; // 标题
    newpost.getElementsByClassName("panel-body")[0].innerText = dom_content; //内容
    newpost.getElementsByClassName("post-author")[0].innerText = dom_author;  //作者
    newpost.getElementsByClassName("post-time")[0].innerText = dom_time;   //时间
    newpost.getElementsByClassName("post-id")[0].innerText = dom_id;    //帖子id
    if(dom_author == current_user)
    {
        newpost.getElementsByClassName("post-edit")[0].hidden = false;  //显示编辑图标
    }

}


function list_posts(pageNum)   // ajax拉取指定页码的帖子
{
    // 页码按钮改激活状态
    var pageButton = document.getElementsByClassName("pagination")[0].children;
    console.log(pageButton);
    for(var i=0;i<pageButton.length;i++)
    {
        pageButton[i].className="";
    }
    var newPage = document.getElementById(pageNum);
    newPage.className = "active";

    
    
    //先隐藏已有帖子
    var posts = document.getElementsByClassName("panel panel-info");
    for(var i=0;i<posts.length;i++)
    {
        posts[i].hidden = true;
    }

    $.ajax({
        type: "post",
        url: "./php/list-post.php",
        data: {"pageNum":pageNum},
        dataType: "json",
        success: function(msg){
            
            var json_errcode = msg['errcode'];
            var json_msg = msg['msg'];
            var postnum = msg['postnum'];
            var postct = msg['postct'];
            var current_user = msg['current_user'];


            if(json_errcode==0)
            {
                console.log(postct);
                for(var i=0;i<postnum;i++)
                {
                    change_dom(postct[i]['title'],postct[i]['username'],postct[i]['time'],postct[i]['content'],postct[i]['postid'],current_user);
                }
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


