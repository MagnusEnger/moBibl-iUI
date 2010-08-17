<?php

if (!isset($_GET['feed'])){
  exit;
}

// TODO: Check that $_GET['feed'] only contains legal chars

require_once('../config.php');
require_once('../inc.db.php');
$config = get_lib();
$dbconfig = get_db_config();
$db = db_open($dbconfig['hostname'], $dbconfig['user'], $dbconfig['database'], $dbconfig['password']);

$sql = 'SELECT * FROM feeditems WHERE feed_key = "' . $_GET['feed'] . '" ORDER BY date DESC LIMIT 10';
$dbitems = db_execute_query($sql, $db);

$items = '';
$menu = '<ul class="edgetoedge">';
while ($item = mysql_fetch_assoc($dbitems)) {
 
	$permalink = $item['permalink'];
	$id = $item['hash_id'];
	$title = $item['title'];
	$description = $item['description'];
	$date = $item['date'];
	
	$menu .= '<li class="arrow feeditem"><a href="#' . $id . '">' . "$title ($date)" . '</a></li>';
	
	$items .= "<div id=\"$id\" style=\"display: none;\">
                <div class=\"toolbar\"><h1>$title</h1><a class=\"button back\" href=\"#\">Tilbake</a></div> 
                <div class=\"content\"> 
                $description
                </div>      
                <div class=\"content\"><p>Publisert: $date</p></div>    
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
