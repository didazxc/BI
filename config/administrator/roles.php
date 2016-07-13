<?php

/**
 * Users model config
 */

return array(

    'title' => '角色列表',

    'single' => 'role',

    'model' => 'App\Role',

    /**
     * The display columns
     */
    'columns' => array(
        'name'=>array(
            'title' => '角色名',
        ),
        'display_name' => array(
            'title' => '显示名',
        ),
        'users'=>array(
            'title' => '隶属用户',
            'relationship'=>'users',
            'select' => "GROUP_CONCAT((:table).name)",
        ),
        'perms'=>array(
            'title' => '拥有权限',
            'relationship'=>'perms',
            'select' => "GROUP_CONCAT((:table).display_name)",
        ),
        'description' => array(
            'title' => '描述',
        ),
        'created_at' => array(
            'title' => '创建日期',
        ),
        'updated_at' => array(
            'title' => '更新日期',
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'name'=>array(
            'title' => '角色名',
            'type' => 'text',
        ),
        'display_name' => array(
            'title' => '显示名',
            'type' => 'text',
        ),
        'created_at' => array(
            'title' => '创建日期',
            'type' => 'date',
        ),
        'updated_at' => array(
            'title' => '更新日期',
            'type' => 'date',
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'name'=>array(
            'title' => '角色名',
            'type' => 'text',
        ),
        'display_name' => array(
            'title' => '显示名',
            'type' => 'text',
        ),
        'users'=>array(
            'title' => '隶属用户',
            'type'=>'relationship',
            'name_field'=>'name',
        ),
        'perms'=>array(
            'title' => '拥有权限',
            'type'=>'relationship',
            'name_field'=>'display_name',
        ),
        'description' => array(
            'title' => '描述',
            'type' => 'text',
        ),
    ),

    /**
     * The validation rules for the form, based on the Laravel validation class
     *
     * @type array
     */
    'rules' => array(
        'name' => 'required|max:255',
        'display_name' => 'max:255',
        'description' => 'max:255',
    ),

);