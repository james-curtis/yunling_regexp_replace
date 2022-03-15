<?php

function get_lang($id)
{
    $lang = [
        'result_func_comment' => '此处为PHP代码，执行内容不能function (){}中，处理完毕之后return即可。捕获到的匹配储存在 全局变量$_G[\'yunling_regexp_replace\'][\'matches\']中',
        'regex_comment' => 'PHP正则表达式，需要加上"限定符"，例如：/或者#',
        'name_comment' => '用于分区各个规则',
        'add_tips' => '<li>测试</li>',
        'edit_tips' => '<li>测试</li>',
        'home_tips' => '<li>测试</li>',
        'add_rule' => '添加规则',
        'edit_rule' => '修改规则',
        'name' => '名称',
        'regex' => '正则表达式',
        'result_func' => '结果处理函数',
        'add_success' => '添加成功',
        'add_failed' => '添加失败',
        'edit_success' => '修改成功',
        'edit_failed' => '修改失败',
        'rule_not_found' => '没有找到这条规则',
        'diy_regex_list' => '自定义正则表达式列表',
        'available' => '可用',
        'action' => '操作',
        'edit' => '编辑',
        'add' => '添加',
        'update_cache_success' => '更新缓存成功',
        'update_cache_failed' => '更新缓存失败',



    ];
    return $lang[$id];
}