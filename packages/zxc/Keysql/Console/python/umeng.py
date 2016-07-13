#!/usr/bin/env python
#-*- coding:utf-8 -*-
import urllib.request
import http.cookiejar 
import urllib.parse
#import pyquery
import json
import datetime
import pymysql

import sys

class Umeng:
    def __init__(self,cookie=''): 
        #连接数据库
        self.conn=pymysql.connect(host=sys.argv[1],user=sys.argv[2], passwd=sys.argv[3],port=int(sys.argv[4]), db=sys.argv[5])
        self.cur = self.conn.cursor()
        self.cur.execute('CREATE TABLE IF NOT EXISTS umeng ( \
                logtime date not null,  \
                term varchar(8) not null, \
                key_tag varchar(64) not null, \
                key_value double not null default 0, \
                primary key(logtime,term,key_tag)) ')
        self.sql = "replace into umeng(logtime,term, key_tag, key_value) values(%s,%s, %s, %s)"
        #构造抓取所需参数
        self.stats={'new':'installations','ret':'retentions'} 
        self.appkeys={'ad':'5d2f30f8ccb04265d30e3b35','ios':'4b86b089ccb0426578bd4b35'} 
        self.cookie=cookie 
        webCookie = http.cookiejar.CookieJar() # 初始化一个CookieJar来处理Cookie 
        self.openner = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(webCookie)) 
        self.start_date = (datetime.date.today() - datetime.timedelta(days=7)).strftime("%Y-%m-%d") 
        self.end_date = (datetime.date.today() - datetime.timedelta(days=1)).strftime("%Y-%m-%d") 

    def getData(self,appkey,stat):
        url= 'http://www.umeng.com/apps/' + self.appkeys[appkey] \
        + '/reports/load_table_data?page=1&per_page=1000&start_date=' + self.start_date \
        + '&end_date=' + self.end_date \
        + '&versions%5B%5D=&channels%5B%5D=&segments%5B%5D=&time_unit=daily&stats=' + self.stats[stat]
        headers={
            'Accept':'application/json, text/javascript, */*; q=0.01',
            'Accept-Language':'zh-CN,zh;q=0.8',
            'Connection':'keep-alive',
            'Cookie':self.cookie,
            'Host':'mobile.umeng.com',
            'Referer':'http://mobile.umeng.com/apps/5d2f30f8ccb04265d30e3b35/reports/installation',
            'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36'
            }
        req=urllib.request.Request(url=url,headers=headers)#创建请求对象
        response=self.openner.open(req)
        page=response.read().decode()#获取页面源代码
        data=json.loads(page)
        logtime=self.end_date
        term=appkey
        value=0
        if(data.get('result')=='success'):
            tag=stat
            if(stat=='new'):
                value=data.get('stats')[0]['data']
            elif(stat=='ret'):
                value=data.get('stats')[-1]['retention_rate'][0]/100
        return (logtime,term,tag,value)
        
    def insertdatas(self,needprint=False):
        insdata=[]
        for appkey in self.appkeys:
            for stat in self.stats:
                data=self.getData(appkey,stat)
                insdata.append(data)
                if needprint:
                    print(data)
        self.cur.executemany(self.sql,insdata)
        self.conn.commit()
                
    def getdatas(self):
        for appkey in self.appkeys:
            for stat in self.stats:
                data=self.getData(appkey,stat)
                print(data)

cookie='cna=yyOND/rozlUCAdOdjIPLe8h9; um_lang=zh; umengplus_name=qiqimobile%4017guagua.com; umplusuuid=14c19f1d2f5843d01ede711a6b1d7dc5; umlid_53b3de6dfd98c5e92c000a4c=20160418; l=ApaWPh6xE-fOAX1NyRRlfQimZkaZYNpx; __utmt=1; __utma=151771813.2102787174.1460710874.1460710874.1460948119.2; __utmb=151771813.5.8.1460948139367; __utmc=151771813; __utmz=151771813.1460710874.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); ummo_ss=BAh7CUkiGXdhcmRlbi51c2VyLnVzZXIua2V5BjoGRVRbCEkiCVVzZXIGOwBGWwZvOhNCU09OOjpPYmplY3RJZAY6CkBkYXRhWxFpWGkBs2kB3mlyaQH9aQGYaQHFaQHpaTFpAGkPaVFJIhlnRTJQSXFPMjkxV3FCRXlidUd3TAY7AFRJIg91bXBsdXN1dWlkBjsARiIlMTRjMTlmMWQyZjU4NDNkMDFlZGU3MTFhNmIxZDdkYzVJIg9zZXNzaW9uX2lkBjsAVEkiJWE5YTJjZjU2OWUzOTU1NWI2MTM1YjJmYjMxZDM5ZTEyBjsARkkiEF9jc3JmX3Rva2VuBjsARkkiMVBVaFBiSTc5Tm5MVGhuN0RBbGpHNm03Y3YwYVRvUUJwR0s4N0RJZzU2TU09BjsARg%3D%3D--44d711ec7d7d9c217fccfa48aae35f629a9412e0'

u=Umeng(cookie)
u.insertdatas()
#u.getdatas()

#qiqimobile@17guagua.com
#QJkj2016fhiier