<?php

/**
 * Session model config
 */

return array(

    'title' => '连接列表',

    'single' => 'session',

    'model' => 'App\Session',

    /**
     * The display columns
     */
    'columns' => array(
        'user_id'=>array(
            'title'=>'用户ID',
            'type'=>'text'
        ),
        'username'=>array(
            'title' => '用户名',
            'relationship'=>'user',
            'select'=>'name'
        ),
        'ip_address'=>array(
            'title'=>'IP',
            'type'=>'text'
        ),
        'user_agent'=>array(
            'title'=>'浏览器',
            'type'=>'text'
        ),
        'last_time'=>array(
            'title'=>'最近活跃时刻',
            'type'=>'datetime'
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'user_id'=>array(
            'title'=>'用户ID',
            'type'=>'text'
        ),
        'user'=>array(
            'title' => '用户名',
            'type' => 'relationship',
            'name_field' => 'name'
        ),
        'ip_address'=>array(
            'title'=>'IP',
            'type'=>'text'
        ),
        'user_agent'=>array(
            'title'=>'浏览器',
            'type'=>'text'
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'user_id'=>array(
            'title'=>'用户ID',
            'type'=>'text'
        ),
        'user'=>array(
            'title' => '用户名',
            'type' => 'relationship',
            'name_field' => 'name'
        ),
        'ip_address'=>array(
            'title'=>'IP',
            'type'=>'text'
        ),
        'user_agent'=>array(
            'title'=>'浏览器',
            'type'=>'text'
        ),
    ),

    /**
     * The action_permissions option lets you define permissions on the four primary actions: 'create', 'update', 'delete', and 'view'.
     * It also provides a secondary place to define permissions for your custom actions.
     *
     * @type array
     */
    'action_permissions'=> array(
        'create' => function($model)
        {
            return 0;
        },
        'update' => function($model)
        {
            return 0;
        }
    ),

    
    
);