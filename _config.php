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

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/lib/pear/PEAR');

/* MISC SETTINGS */

$config['max_records'] = 11;
$config['per_page'] = 4;

/* LIBRARIES
title: Name of library
z3950 OR sru and item_url
z3950: Connection-string for Z39.50
sru: Connection-string for SRU
item_url: Base URL for links to the catalogue */

$config['libraries']['hig'] = array(
	'title' => 'Høgskolen i Gjøvik', 
	'z3950' => 'z3950.bibsys.no:2100/HIG'
);
$config['libraries']['deich'] = array(
	'title' => 'Deichmanske', 
	'z3950' => 'z3950.deich.folkebibl.no:210/data'
);
$config['libraries']['pode'] = array(
	'title'    => 'Pode', 
	'sru'      => 'http://torfeus.deich.folkebibl.no:9999/biblios', 
	'item_url' => 'http://dev.bibpode.no/cgi-bin/koha/opac-detail.pl?biblionumber='
);

?>