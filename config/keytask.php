<?php

return array(
    //全平台名称
    'sysname'=>'齐齐互动数据平台v2.0',
    'brand'=>'BI',
    //访问权限
    'permission_keytask'=>'guest',
    //分析师组
    'permission_task_role'=>'admin',
    //访问链接前缀
    'route_prefix'=>'keytask',
    
    //keytask表名字
    'keytask_table'=>'zxc__key_task',
    'keytaskhour_table'=>'zxc__key_task_hour',
    //导航
    'nav_array'=>[
        '首页'=>['url'=>'/'],
        '运营日志'=>[
            'children'=>[
                '事件列表'=>['fa'=>'fa-list','url'=>'/keyact/list','permission'=>''],
            ],
        ],
        '数据需求'=>[
            'fa'=>'fa-wrench',
            'children'=>[
                '需求列表'=>['fa'=>'fa-list','url'=>'/keytask/dlist','permission'=>''],
                '任务列表'=>['fa'=>'fa-list','url'=>'/keytask/tlist','permission'=>'admin'],
            ],
        ],
    ],
);