<?php

if (!isset($_GET['feed'])){
  exit;
}

list($lib, $feed_id) = explode('_', $_GET['feed']);
include_once('../config.php');
$config = get_config('hig');

// Are we in debug mode?
if ($config['debug_feeds']) {

  echo($config['lib']['feeds'][$feed_id]['url']);
  exit;

}

// Make sure SimplePie is included. You may need to change this to match the location of simplepie.inc.
require_once('SimplePie-1.2/simplepie.inc');

// We'll process this feed with all of the default options.
$feed = new SimplePie();

$feed->set_cache_location('feedcache/');
 
// Set which feed to process.
$feed->set_feed_url($config['lib']['feeds'][$feed_id]['url']);

// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

echo('<ul class="edgetoedge">');

$i = 0;
$items = '';

foreach ($feed->get_items() as $item) {
 
	$permalink = $item->get_permalink();
	$title = $item->get_title();
	$description = $item->get_description();
	$date = $item->get_date('j F Y, H.i');
	
	echo('<li class="arrow feeditem"><a href="#item_' . $i . '">' . "$title ($date)" . '</a></li>');
	
	$items .= "<div id=\"item_$i\" style=\"display: none;\">
            <div>
                <h2>$title</h2>  
                $description          
            </div>
            <a style=\"margin:0 10px;color:rgba(0,0,0,.9)\" href=\"#\" class=\"whiteButton goback\">Tilbake</a>
        </div>";
	
	$i++;
	 
}

echo('</ul>');

echo($items);

?>