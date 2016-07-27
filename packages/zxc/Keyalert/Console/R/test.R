#!/usr/bin/Rscript
#包加载
library('methods')
library('DBI')
library('RMySQL')
#php赋予的变量(host,username,password,port,database)
#自行调试时，请使用Rscript命令，
#并依次给出上述括号中的5个参数值
#如：Rscript test.R 'localhost' 'root' '7511' '3306' 'homestead'
Args <- commandArgs()
#连接默认数据库
conn <- dbConnect(MySQL(),
    host=Args[6],
    username=Args[7],
    password=Args[8],
    port=as.numeric(Args[9]),
    dbname = Args[10])
###############################################
#以下为预警逻辑判断

#查询，结果为data.frame类型
da <- dbGetQuery(conn, "
SELECT key_value
FROM zxc__key_lib
where key_id=11
")
dd<-da[,'key_value']

#假设正常分布区间为[10%,20%]
if(dd<0.1)
{
    if(dd<0.05)
    {
        pro<-3
        alert<-"注意，留存大幅下滑"
    }
    else
    {
        pro<-1
        alert<-"注意，留存出现下滑迹象"
    }
}
if(dd>0.2)
{
    pro<-1
    alert<-"注意，留存出现异常"
}

###############################################
if(!dbDisconnect(conn)){print(0)}
#以下格式固定，为预警返回值
print(pro)#pro:严重程度，1普通，2严重，3紧急
#alert_desc：预警内容
print(alert)