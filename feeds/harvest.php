<?php

/*
This is a script intended to harvest feed items on a regular basis. 
It is meant to be run from the command line or cron, not over HTTP. 
*/

// Make sure SimplePie is included. You may need to change this to match the location of simplepie.inc.
require_once('SimplePie-1.2/simplepie.inc');
require_once('../config.php');
require_once('../inc.db.php');
$config = get_lib();
$dbconfig = get_db_config();
$db = db_open($dbconfig['hostname'], $dbconfig['user'], $dbconfig['database'], $dbconfig['password']);

// We'll process this feed with all of the default options.
$feed = new SimplePie();
$feed->set_cache_location('feedcache');

foreach ($config as $libkey => $lib) {

  // echo("$key\n");

  if($lib['nav']) {

    foreach ($lib['nav'] as $navkey => $nav) {

      if ($nav['type'] == 'feed') {

	$feedkey = $libkey . '_' . $navkey;

	echo($feedkey . ': ' . $nav['url'] . "\n");

	// Set which feed to process.
	$feed->set_feed_url($nav['url']);

	// Run SimplePie.
	$feed->init();
	
	// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();

	$i = 0;
	$items = '';

	foreach ($feed->get_items() as $item) {
	
	  $permalink = $item->get_permalink();
	  // Turn the permalink into a unique id
	  $id = md5($permalink);
	  $title = strip_tags($item->get_title());
	  $description = strip_tags($item->get_description());
	  $date = $item->get_date('Y-m-d, H:i');
	  
	  // echo("$id\n$date\n$permalink\n$title\n$description\n\n");

	  $sql = "INSERT IGNORE INTO feeditems SET 
	      feed_key    = '" . $feedkey . "', 
		  title       = '" . prepare_string($title) . "',  
		  permalink   = '" . $permalink . "',
		  hash_id     = '" . $id . "', 
		  date        = '" . prepare_string($date) . "',
		  description = '" . prepare_string($description) . "';"; 

	  db_execute_query($sql, $db);
	  
	  // Was this a new item?
	  if (mysql_affected_rows() > 0) {
	    echo('+');
	  } else {
	    echo('-');
	  }
		
	}
        echo("\n");

      }

    }

  }	

}

function prepare_string($s) {

  return mysql_real_escape_string(trim(strip_tags($s)));

}

?>