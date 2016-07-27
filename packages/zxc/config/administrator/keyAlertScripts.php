<?php

return array(

    'title' => '预警脚本管理',

    'single' => 'script',

    'model' => 'Zxc\Keyalert\Models\KeyAlertScripts',

    /**
     * The display columns
     */
    'columns' => array(
        'id'=>array(
            'title' => 'ID',
        ),
        'name'=>array(
            'title' => '预警名称',
        ),
        'file' => array(
            'title' => '脚本文件',
        ),
        'username' => array(
            'title' => '创建人',
        ),
        'faicon' => array(
            'title' => '图标',
        ),
        'cron' => array(
            'title' => '运行周期',
        ),
        'script_desc' => array(
            'title' => '描述',
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'id'=>array(
            'title' => 'ID',
            'type' => 'text'
        ),
        'name'=>array(
            'title' => '预警名称',
            'type' => 'text'
        ),
        'file' => array(
            'title' => '脚本文件',
            'type' => 'text'
        ),
        'user' => array(
            'title' => '创建人',
            'type'=>'relationship',
            'name_field'=>'name',
        ),
        'faicon' => array(
            'title' => '图标',
            'type' => 'text'
        ),
        'cron' => array(
            'title' => '运行周期',
            'type'=>'enum',
            'options' => array('0','1','2','4','3','5','6','7','8','16'),
        ),
        'script_desc' => array(
            'title' => '描述',
            'type' => 'text'
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'name'=>array(
            'title' => '预警名称',
            'type' => 'text'
        ),
        'file' => array(
            'title' => '脚本文件',
            'type' => 'file',
            'location' => storage_path('app/keyalert/'),
            'naming' => 'random',
            'length' => 32,
            'size_limit' => 20,
            'display_raw_value' => false,
        ),
        'faicon' => array(
            'title' => '图标',
            'type' => 'text'
        ),
        'cron' => array(
            'title' => '运行周期',
            'type'=>'enum',
            'options' => array('0','1','2','4','3','5','6','7','8','16'),
        ),
        'script_desc' => array(
            'title' => '描述',
            'type' => 'text'
        ),
    ),

    'rules' => array(
        'file' => 'required|unique:zxc__key_alert_scripts',
    ),
    
    
);