<?php

echo('<h1>$_SERVER</h1>');
echo('<ul>');
foreach($_SERVER as $key => $value) {
  echo("<li>$key: $value</li>");
  if ($key == 'argv') {
  	foreach($value as $argvkey => $argvvalue) {
      echo("<li>argv $argvkey: $argvvalue</li>");
  	}
  }
}
echo('</ul>');

?>