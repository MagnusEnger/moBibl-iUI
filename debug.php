<?php

echo('<h1>$_SERVER</h1>');
echo('<ul>');
foreach($_SERVER as $key => $value) {
  echo("<li>$key: $value</li>");
}
echo('</ul>');

?>