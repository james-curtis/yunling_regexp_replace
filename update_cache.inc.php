<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/plugin/yunling_regexp_replace/lang.php';
$r = memory('rm','yunling_regexp_replace_data');

if ($r)
    cpmsg(get_lang('update_cache_success'),'','succeed');
else
    cpmsg(get_lang('update_cache_failed'),'','error');

?>