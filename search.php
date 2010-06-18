<?php 

/*

Copyright 2010 Magnus Enger Libriotech

This file is part of mkat.

mkat is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

mkat is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with mkat.  If not, see <http://www.gnu.org/licenses/>.

*/

header('Content-Type: text/html; charset=utf-8');
echo('<?xml version="1.0" encoding="utf-8"?>' . "\n\n"); 

include('config.php');
$config = get_config('hig');
include('include/functions.php');
require('File/MARCXML.php');

echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n"); 
echo('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nb_NO" lang="nb_NO">' . "\n");
echo("<head>\n<title>mkat</title>\n" . "\n");

echo('<link rel="stylesheet" type="text/css" href="css/default.css" />' . "\n");

echo('<body>' . "\n");
echo('<div id="content">' . "\n");

/* SØKESKJERM */

echo('
<div class="searchform">
<form method="get" action="search.php">
<p>
<input type="text" name="q" value="' . $_GET['q'] . '" />
<input type="hidden" name="lib" value="hig" />
<input type="hidden" name="sorter" value="aar" />
<input type="hidden" name="orden" value="synk" />
<input type="submit" value="Søk" />
</p>
</form>
</div>' . "\n");

// q eller item må være satt
// bib må være satt, og må være en nøkkel i $config['lib']
if ((!empty($_GET['q']) || !empty($_GET['id'])) && !empty($_GET['lib'])) {

	echo('<div id="main">' . "\n");
	
	/* TREFFLISTE */
	
	// Sortering
	if (!empty($_GET['q'])) {
	
		// Søk
		if (!empty($_GET['q'])) {
			echo('<div id="treffliste">' . "\n");
			$q = masser_input($_GET['q']);
			$query = '';
			if (!empty($config['lib']['sru'])) {
				// SRU
				$qu = urlencode($q);
				$query = $qu;
			} else {
				// Z39.50
				$query = "any=$q";
			}
			echo(podesearch($query));
			echo('</div>' . "\n");
		}
	}

	// Postvisning	
	if (!empty($_GET['id'])) {
		echo(postvisning($_GET['id']));
	}

	// Avslutter div main
	echo('</div>');

} else {

	echo('default');
	
}

// Avslutter div content
echo('</div>' . "\n");

// Sjekk om vi skal skrive ut kode for Google Analytics
if (isset($config['google_analytics']) && $config['google_analytics'] != '') {
	?>
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("<?php echo($config['google_analytics']); ?>");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	<?php
}

echo("</body>\n</html>");

?>