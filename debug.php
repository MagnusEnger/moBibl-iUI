<?php

echo('<h1>$_SERVER</h1>');
echo('<ul>');
foreach($_SERVER as $key => $value) {
  echo("<li>$key: $value</li>");
}
echo('</ul>');

echo('<h1>$_GET</h1>');
echo('<ul>');
foreach($_REQUEST as $key => $value) {
  echo("<li>$key: $value</li>");
}
echo('</ul>');

?>