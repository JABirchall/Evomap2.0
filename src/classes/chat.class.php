<?php

class chat 
{
	/*
	 * Chat 
	 *
	 */
	public function server_form()
	{
		global $DB;
		
		$input = new \Kendo\UI\ComboBox('Servers');
		$input->dataSource($this::get_servers())
		      ->dataTextField('name')
		      ->dataValueField('servers_id')
		      ->filter('contains')
		      ->placeholder('Select server ...')
		      ->suggest(true)
		      ->index($DB->count());
		
		$textButton = new \Kendo\UI\Button('Submit');
		$textButton->attr('type', 'Submit')
				   ->content('Submit');

		return "<form action=\"" . basename($_SERVER['PHP_SELF']) . "\" method=\"GET\">\n" . $input->render() . "\n " . $textButton->render() . "</form>\n";
	}

	static public function get_servers()
	{
		global $DB;

		$DB->query("SELECT * FROM `servers`");

		if ($DB->count() >= 1)
			return $DB->statement->fetchall(PDO::FETCH_ASSOC);
		else
			return $this->error = "No results.";
	}


}