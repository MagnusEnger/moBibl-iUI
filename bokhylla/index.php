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

if (empty($_GET['page'])) {  
	echo('<ul id="bokhylla" title="Bokhylla.no">');
}
foreach ($tmparray as $line) {
	echo($line);
}
$next = $offset + 1;
echo('<li><a href="/bokhylla/?page=' . $next . '" target="_replace">Vis flere</a></li>');
if (empty($_GET['page'])) {  
	echo('</ul>');
}
?>