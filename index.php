<?php

if (!empty($_GET['lib'])) {

  include('config.php');
  $config = get_config($_GET['lib']);
  include('include/setup.php');

  $smarty->assign('config', $config);
  $smarty->assign('libraries', get_lib());

  if (!empty($_GET['q'])) {

	  $smarty->display('search.tmpl');

  } elseif(!empty($_GET['page'])) {

	  // Get the page from somewhere (RSS, HTML from database), based on $_GET['page']
	  $smarty->display('page.tmpl');
	  
  } else {

	  $smarty->display('index.tmpl');
	  
  }

} else {

  // Display library choice
  

}

?>