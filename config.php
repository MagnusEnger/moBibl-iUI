<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/lib/pear/PEAR');

// TODO: This should be replaced by calls to a database! 

function get_config($lib) {

	$c = array();

	$c['debug'] = true;
	
	$c['max_records'] = 11;
	$c['per_page'] = 4;

	// Library independent settings
	$c['smarty_path'] = '/home/lib/Smarty-2.6.26/libs/Smarty.class.php';
	
	//Libraries
	$l = array();
	$l['hig'] = array(
		'name'  => 'HiG', 
		'records_max' => 11, 
		'records_per_page' => 4, 
		'system' => 'bibsys',
		'z3950'  => 'z3950.bibsys.no:2100/HIG'
	);
	$l['deich'] = array(
		'name'  => 'Deichmanske',
		'records_max' => 11, 
		'records_per_page' => 4, 
		'system' => 'bibliofil',  
		'z3950'  => 'z3950.deich.folkebibl.no:210/data'
	);
	$l['pode'] = array(
		'name'    => 'Pode', 
		'records_max' => 11, 
		'records_per_page' => 4, 
		'system'   => 'koha', 
		'sru'      => 'http://torfeus.deich.folkebibl.no:9999/biblios', 
		'item_url' => 'http://dev.bibpode.no/cgi-bin/koha/opac-detail.pl?biblionumber='
	);
	
	$c['lib'] = $l[$lib];
	
	return $c;
	
}

?>