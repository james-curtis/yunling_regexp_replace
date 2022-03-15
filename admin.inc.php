<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/plugin/yunling_regexp_replace/lang.php';
global $_G,$plugin;

$url_prefix = "admin.php?action=plugins&operation=config&do=" . $pluginid . "&identifier=" . $plugin["identifier"] . "&pmod=admin";

$act_prefix = "plugins&operation=config&do=" . $pluginid . "&identifier=" . $plugin["identifier"] . "&pmod=admin";


if (getgpc('act') == 'add')
{
    if (!submitcheck('submit'))
    {
        showformheader($act_prefix.'&act=add');
        showtips(get_lang('add_tips'));
        showtableheader();

        showtitle(get_lang('add_rule'));
        showsetting(get_lang('name'),'name','','text','','',get_lang('name_comment'));

        showsetting(get_lang('regex'),'regex','','textarea','','',get_lang('regex_comment'));

        showsetting(get_lang('result_func'),'replacement','','textarea','','',get_lang('result_func_comment'));

        showsubmit('submit');

        showtablefooter();

        showformfooter();
        exit();
    }
    else
    {
        //处理数据，全部base64加密
        $name = getgpc('name');
        $regex = base64_encode(getgpc('regex'));
        $replacement = base64_encode(getgpc('replacement'));

        $r = DB::insert('plugin_yunling_regexp_replace',[
            'name' => $name,
            'regex' => $regex,
            'replacement' => $replacement,

        ]);

        if ($r)
        {
            cpmsg(get_lang('add_success'),$_G['setting']['siteurl'] . $url_prefix,'succeed');
        }
        else
        {
            cpmsg(get_lang('add_failed'),'','error');
        }
    }
}
elseif (!empty(getgpc('edit')))
{
    if (!submitcheck('submit'))
    {
        $id = intval(getgpc('edit'));
        $data = DB::fetch_first('SELECT * FROM `' . DB::table('plugin_yunling_regexp_replace') . '` WHERE `id`='.$id);
        if (empty($data))
            cpmsg(get_lang('rule_not_found'),$_G['setting']['sitename'].$url_prefix,'error');

        showformheader($act_prefix.'&edit='.$id);
        showtips(get_lang('edit_tips'));
        showtableheader();

        showtitle(get_lang('edit_rule'));

        showsetting('ID','id',$data['id'],'number',1);

        showsetting(get_lang('name'),'name',$data['name'],'text','','',get_lang('name_comment'));

        showsetting(get_lang('regex'),'regex',base64_decode($data['regex']),'textarea','','',get_lang('regex_comment'));

        showsetting(get_lang('result_func'),'replacement',base64_decode($data['replacement']),'textarea','','',get_lang('result_func_comment'));

        showsubmit('submit');

        showtablefooter();

        showformfooter();
        exit();
    }
    else
    {
        //处理数据，全部base64加密
        $name = getgpc('name');
        $id = intval(getgpc('edit'));
        $regex = base64_encode(getgpc('regex'));
        $replacement = base64_encode(getgpc('replacement'));

        $r = DB::update('plugin_yunling_regexp_replace',[
            'name' => $name,
            'regex' => $regex,
            'replacement' => $replacement,
        ],'`id`='.$id);

        if ($r)
        {
            cpmsg(get_lang('edit_success'),$_G['setting']['siteurl'] . $url_prefix,'succeed');
        }
        else
        {
            cpmsg(get_lang('edit_failed'),'','error');
        }
    }
}


if (!submitcheck('submit'))
{
    //取数据
    $data = DB::fetch_all('SELECT * FROM `' . DB::table('plugin_yunling_regexp_replace') . '` WHERE 1=1');

//    var_dump($data);

    //显示表单
    showformheader($act_prefix);
    showtips(get_lang('home_tips'));
    showtableheader();

    showtitle(get_lang('diy_regex_list'));

    showsubtitle([
        '',
        get_lang('name'),
        get_lang('available'),
        get_lang('action'),
    ]);

    //循环显示
    if (is_array($data))
    {
        foreach ($data as $datum) {
//            echo 1;
            showtablerow('',[
                '',
                '',
                "class=\"td25\"",
                "width=\"100\"",
            ],
            [
                "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"" . $datum["id"] . "\">",
                $datum['name'],
                "<input class=\"checkbox\" type=\"checkbox\" name=\"show[" . $datum["id"] . "]\" value=\"1\" " . ($datum["available"] > 0 ? "checked" : '') . ">".
                "<input type=\"hidden\" name=\"ids[" . $datum["id"] . "]\" value=\"" . $datum["id"] . "\">",
                '<a href="'.$url_prefix . '&edit=' . $datum['id'] .'" >' . get_lang('edit') . '</a>'
            ]);
        }
    }

    //添加按钮
    echo "<tr><td colspan=\"1\"></td><td colspan=\"7\"><div><a href=\"" .$url_prefix . '&act=add' . "\" class=\"addtr\">" . get_lang('add') . "</a></div></td></tr>";

    showsubmit('submit','submit','del');

    showtablefooter();

    showformfooter();

    exit();
}
else
{
    $show = array_keys(getgpc('show'));
    $ids = getgpc('ids');
    $delete = getgpc('delete');

    $available_1 = [];
    $available_0 = [];
    foreach ($ids as $id) {
        if (in_array($id,$show))
            $available_1[] = $id;
        else
            $available_0[] = $id;
    }

    if (!empty($available_1))
    DB::update('plugin_yunling_regexp_replace',[
        'available' => 1
    ],'`id` IN ('. implode(',',$available_1) .')');

    if (!empty($available_0))
    DB::update('plugin_yunling_regexp_replace',[
        'available' => 0
    ],'`id` IN ('. implode(',',$available_0) .')');

    if (!empty($delete))
    DB::delete('plugin_yunling_regexp_replace','`id` IN (' . implode(',',$delete) . ')');

    cpmsg('修改成功',$_G['setting']['siteurl'].$url_prefix,'succeed');
    exit();

}

?>