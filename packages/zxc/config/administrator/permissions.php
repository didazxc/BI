<?php

/**
 * Users model config
 */

return array(

    'title' => '权限列表',

    'single' => 'permission',

    'model' => 'App\Permission',

    /**
     * The display columns
     */
    'columns' => array(
        'name'=>array(
            'title' => '权限名',
        ),
        'display_name' => array(
            'title' => '显示名',
        ),
        'roles'=>array(
            'title' => '有权角色',
            'relationship'=>'roles',
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
            'title' => '权限名',
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
            'title' => '权限名',
            'type' => 'text',
        ),
        'display_name' => array(
            'title' => '显示名',
            'type' => 'text',
        ),
        'roles'=>array(
            'title' => '有权角色',
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