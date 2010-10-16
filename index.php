<?php

if (!empty($_GET['lib'])) {

  include('config.php');
  $config = get_config($_GET['lib']);
  include('include/setup.php');

  $smarty->assign('config', $config);
  $smarty->assign('libraries', get_lib());

  $smarty->display('library.tmpl');

} else {

  // Display library choice
  include('config.php');
  $config = get_config();
  include('include/setup.php');

  $smarty->assign('config', $config);
  $smarty->assign('libraries', get_lib());
  
  $smarty->display('default.tmpl');

}

?>