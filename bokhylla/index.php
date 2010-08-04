<?php

include('bokhylla.inc');

$per_page = 10;
$offset = 0;
if (!empty($_GET['page']) && is_int((int) $_GET['page'])) {
	$offset = $_GET['page'];
} elseif (!empty($_GET['rand']) && $_GET['rand'] == 'true') {
	shuffle($bokhylla);	
}
$offset = $offset * $per_page;

$tmparray = array_slice($bokhylla, $offset, $per_page);

foreach ($tmparray as $line) {
	echo($line);
}

?>