<?php
// How i like to load shit.
require_once('classes/init.class.php');
$i = NEW init(1); // Use init(1) to init HTML elements.

if (!@$SID) {
	echo "<h2>Evony chat logs</h2>" .$chat->server_form();
} else {
	
}

echo "<h1>Market place holder</h1>";
$i->footer();