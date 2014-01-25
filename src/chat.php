<?php
// How i like to load shit.
require_once('classes/init.class.php');

$SID = (isset($_GET['Servers'])) ? $_GET['Servers'] : '';


$i = NEW init(1);
$DB = NEW database($DB_ip, $DB_database, $DB_user, $DB_password);
$chat = NEW chat();

if (!@$SID) {
	echo "<h2>Evony chat logs</h2>" .$chat->server_form();
} else {

}

$i->footer();