<?php

if (!isset($_GET['feed'])){
  exit;
}

list($lib, $feed_id) = explode('_', $_GET['feed']);
include_once('../config.php');
$config = get_config($lib);

// Are we in debug mode?
if ($config['debug_feeds']) {

  if (!empty($_GET['part'])) {

    echo('<div id="hignewsitem1"><div class="toolbar"><h1>Nyhet 1</h1><a class="button back" href="#">Tilbake</a></div><div class="content"><p>Bla, bla, bla...</p></div></div>');
    echo('<div id="hignewsitem2"><div class="toolbar"><h1>Nyhet 2</h1><a class="button back" href="#">Tilbake</a></div><div class="content"><p>Bla, bla, bla...</p></div></div>');
    echo('<div id="hignewsitem3"><div class="toolbar"><h1>Nyhet 3</h1><a class="button back" href="#">Tilbake</a></div><div class="content"><p>Bla, bla, bla...</p></div></div>');
    exit;

  } else {

    echo('<ul class="rounded">');
    echo('<li><a class="flip" href="#hignewsitem1">test 1</a></li>');
    echo('<li><a class="flip" href="#hignewsitem2">test 2</a></li>');
    echo('<li><a class="flip" href="#hignewsitem3">test 3</a></li>');
    echo('</ul>');
    exit;

  }

}

// Make sure SimplePie is included. You may need to change this to match the location of simplepie.inc.
require_once('SimplePie-1.2/simplepie.inc');

// We'll process this feed with all of the default options.
$feed = new SimplePie();

$feed->set_cache_location('feedcache/');
 
// Set which feed to process.
$feed->set_feed_url($config['lib']['nav'][$feed_id]['url']);

// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

$i = 0;
$items = '';

$menu = '<ul class="edgetoedge">';
foreach ($feed->get_items() as $item) {
 
	$permalink = $item->get_permalink();
	// Turn the permalink into a unique id
	$id = md5($permalink);
	$title = $item->get_title();
	$description = $item->get_description();
	$date = $item->get_date('j F Y, H.i');
	
	$menu .= '<li class="arrow feeditem"><a href="#' . $id . '">' . "$title ($date)" . '</a></li>';
	
	$items .= "<div id=\"$id\" style=\"display: none;\">
            <div>
                <h2>$title</h2>  
                $description          
            </div>
            <a style=\"margin:0 10px;color:rgba(0,0,0,.9)\" href=\"#\" class=\"whiteButton goback\">Tilbake</a>
        </div>";
	
	$i++;
	 
}
$menu .= '</ul>';

if (!empty($_GET['part'])) {
  echo($items);
} else {
  echo($menu);
}

?>
