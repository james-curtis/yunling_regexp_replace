<?php

$table = DB::table('plugin_yunling_regexp_replace');

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$table}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `regex` text COLLATE utf8_unicode_ci NOT NULL,
  `replacement` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `available` (`available`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOF;


runquery($sql);
$finish = true;