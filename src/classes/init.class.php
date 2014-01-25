<?php

class init
{
	/* This is what i use to load everything needed */
	/* If you make additions its recomended to include them here */
	function __construct($html = NULL)
	{
		require_once("classes/database.class.php");
		require_once("classes/map.class.php");
		require_once("classes/chat.class.php");
		require_once("kendo/lib/Kendo/Autoload.php");
		
		if($html != NULL){
			require_once("header.php");
			echo $this::build_menu();
		}

		
	}

	/* KendoUI Menu function */
	/* Make Additions here */
	private static function build_menu()
	{
		$menu = new \Kendo\UI\Menu("menu");

		$home = new \Kendo\UI\MenuItem("<a href=\"index.php\">Home</a>\n");
		$menu->addItem($home);

		$service = new \Kendo\UI\MenuItem("Service's");
		$service->addItem(
			new \Kendo\UI\MenuItem("<a href=\"map.php\">Map</a>\n"),
			new \Kendo\UI\MenuItem("<a href=\"market.php\">Market</a>\n"),
			new \Kendo\UI\MenuItem("<a href=\"cap.php\">Captures</a>\n"),
			new \Kendo\UI\MenuItem("<a href=\"chat.php\">Chat</a>\n"));
		$menu->addItem($service);

		$blog = new \Kendo\UI\MenuItem("<a href=\"http://blog.dr/\">Blog</a>\n");
		$menu->addItem($blog);

		$about = new \Kendo\UI\MenuItem("<a href=\"about.php\">About me</a>\n");
		$menu->addItem($about);

		return $menu->render()."<div class=\"page\">"."<div id=\"example\" class=\"k-content\">\n";

	}

	public function footer()
	{
		require_once("footer.php");
	}

}
require_once("config.php");
