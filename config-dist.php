<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/lib/pear/PEAR');

// TODO: This should be replaced by calls to a database! 

function get_config($lib) {

  $c = array();

  $c['debug'] = true;
  $c['debug_feeds'] = true;

  $c['max_records'] = 11;
  $c['per_page'] = 4;

  // Library independent settings
  // $c['smarty_path'] = '/home/lib/Smarty-2.6.26/libs/Smarty.class.php';
  $c['smarty_path'] = '/usr/share/php/smarty/Smarty.class.php';

  //Libraries
  $l = array();
  $l['hig'] = array(
    'name'  => 'HiG', 
    'records_max' => 11, 
    'records_per_page' => 4, 
    'system' => 'bibsys',
    'z3950'  => 'z3950.bibsys.no:2100/HIG',
    'theme' => 'jqt', 
    'frontpage' => '<ul>
	<li>Åpningstider:
	<li>Man. - tor.: 08.30-18.00</li>
	<li>Fre.: 08:30-15.30</li>
	<li>Tlf: <a href="tel:+4761135131">+47 61 13 51 31</a></li>
	<li>E-post: <a href="mailto:bibliotek@hig.no">bibliotek@hig.no</a></li>
	</ul>',  
    'nav' => array(
      'nytt' => array(
	'type' => 'feed', 
	'title' => 'Nytt fra biblioteket', 
	'url' => 'http://blog.hig.no/endnote/feed/'
      ), 
      /*
      'lenker' => array(
	'type' => 'feed', 
	'title' => 'Lenker', 
	'url' => 'http://blog.hig.no/lenker/feed/'
      )
      */
    )
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
  // Save the short form of the chosen library
  $c['lib']['lib'] = $lib;

  return $c;

}

?>
