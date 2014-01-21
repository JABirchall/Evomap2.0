<?php
// How i like to load shit.
require_once('classes/init.class.php');



$SID = (isset($_GET['Servers'])) ? $_GET['Servers'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once 'kendo/lib/DataSourceResult.php';
	$i = NEW init();

    header('Content-Type: application/json');
    //print_r($request = json_decode(file_get_contents('php://input')));
    $request = json_decode(file_get_contents('php://input'));
    $result = new DataSourceResult('mysql:host=127.0.0.1;port=3306;dbname=evomap','root','');
    echo json_encode($result->read('everything', array('x', 'y', 'city_name', 'lord_name', 'alliance', 'status', 'flag', 'honor', 'prestige'), $request));

    exit;
}
/* Main application */

$i = NEW init(1);

$map = NEW map();
if (!@$SID)
{
	echo "<h2>Evony Map</h2>" .$map->server_form();
	var_dump($_POST);

} else {
	echo $map->map_table();
}
$i->footer();