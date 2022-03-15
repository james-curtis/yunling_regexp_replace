<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/yunling_regexp_replace/lang.php';
require_once DISCUZ_ROOT.'./source/plugin/yunling_regexp_replace/func.php';

class plugin_yunling_regexp_replace {

    public function common()
    {
        global $_G;
        $config = $_G['cache']['plugin']['yunling_regexp_replace'];

        $data = yunling_regexp_replace_fetch_data();

        foreach ($data as $datum)
        {
            //注入正则表达式替换列表
            $key = 'yunling_regexp_replace_data_'.$datum['id'];

            $_G['setting']['output']['preg']['search'][$key] = base64_decode($datum['regex']);
            $_G['setting']['output']['preg']['replace'][$key] = 'yunling_regexp_replace_main($matches,'.$datum['id'].')';
        }
    }

//    public function global_footer()
//    {
//        return '"'.getforumimg('1').'"';
//    }
}

