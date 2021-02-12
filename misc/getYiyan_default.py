#coding:utf-8
#给数据库增加若干一言记录，方便调试

import pymysql
import requests
import time
import json

conn = pymysql.connect(host='localhost',user = "",passwd = "",db = "")
print(conn)


for i in range(1,200):
    cursor=conn.cursor()
    res = requests.get("https://v1.hitokoto.cn/")
    res_dict = json.loads(res.text)
    print(res_dict)
    content = res_dict['hitokoto']
    title = res_dict['from']
    create_time = res_dict['created_at']
    timeArray = time.localtime(int(create_time))
    create_time = time.strftime("%Y-%m-%d %H:%M:%S", timeArray)
    author = 'Spider'
    try:
        cursor.execute(f"INSERT INTO bbs_post(bbs_postuser,bbs_posttitle,bbs_postcontent,bbs_posttime) VALUES ('{author}','{title}','{content}','{create_time}')")
        cursor.close()
        conn.commit()
    except:
        continue

    time.sleep(1)
