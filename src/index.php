<?php
// How i like to load shit.
require_once('classes/init.class.php');
$i = NEW init(1); // Use init(1) to init HTML elements.
$DB = NEW database($DB_ip, $DB_database, $DB_user, $DB_password);


echo "<h1> Hello</h1>";
$i->footer();