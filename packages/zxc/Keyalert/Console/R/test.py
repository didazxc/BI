#!/usr/bin/python3
import time


#以下格式固定，为预警返回值
print(time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time())))#logtime
print('我的\'预\'警')#name
print('zxc')#user
print('单指标：充值')#alert_type
print('daily')#cycle
print('5%')#threshold
print(123)#data
#alert_desc
print('注意')