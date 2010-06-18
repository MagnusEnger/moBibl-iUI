<?php

require_once($config['smarty_path']);
$smarty = new Smarty();

$smarty->template_dir = 'tmpl/templates/';
$smarty->compile_dir  = 'tmpl/templates_c/';
$smarty->config_dir   = 'tmpl/configs/';
$smarty->cache_dir    = 'tmpl/cache/';

?>