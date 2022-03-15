<?php
function yunling_regexp_replace_main($matches,$id)
{
    $data = yunling_regexp_replace_fetch_data();
    foreach ($data as $datum) {
        if ($datum['id'] == $id)
        {
            global $_G;
            $_G['yunling_regexp_replace']['matches'] = $matches;
            return eval(base64_decode($datum['replacement']));
            // return $return;
            // var_dump($return);exit;
            // if (function_exists('yunling_regexp_replace_callback'))
            // {
            // $return = call_user_func('yunling_regexp_replace_callback');
            // var_dump($return);exit;
            // return $return;
            // }
        }
    }
    // var_dump($matches);
    return $matches[0];
}

function yunling_regexp_replace_fetch_data()
{
    global $_G;
    $config = $_G['cache']['plugin']['yunling_regexp_replace'];
    $ttl = intval($config['ttl']);//缓存时间
    //查看缓存
    $data = memory('get','yunling_regexp_replace_data');
    if (empty($data))
    {
        $data = DB::fetch_all('SELECT * FROM `' . DB::table('plugin_yunling_regexp_replace') . '` WHERE `available`=1');
        //设置缓存
        if (memory('check'))
        {
            memory('set','yunling_regexp_replace_data',serialize($data),$ttl);
        }
    }
    else
    {
        $data = unserialize($data);
    }
    return $data;
}