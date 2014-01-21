<?php
class map {

	public function select_server($sid)
	{
		$DB->query("SELECT * FROM `everything` WHERE `servers_id` = :sid",
			['sid' => $sid]);
		
		if ($DB->count() >= 1)
			return $DB->statement->fetchall(PDO::FETCH_OBJ);
		else
			return $this->error = "No results.";
	}

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

	public function search_form()
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

	static public function list_coords($sid, $lord = '', $city = '', $alliance = '')
	{
		global $DB;
		$DB->query("SELECT * FROM `everything` WHERE `servers_id` =:sid AND `city_name` LIKE :city AND `lord_name` LIKE :lord AND `alliance` LIKE :alliance;",
			[':sid' => $sid, ':lord' => '%' .$lord. '%', ':city' => '%' .$city. '%', ':alliance' => '%' .$alliance. '%']);
		return $DB->statement->fetchall(PDO::FETCH_ASSOC);
	}

	public function map_table()
	{
		
     	return $this->map_table_grid()->render();
	}

	private function map_table_data()
	{
		$read = new \Kendo\Data\DataSourceTransportRead();
		$transport = new \Kendo\Data\DataSourceTransport();

		$read->url('map.php')
     		 ->contentType('application/json')
     		 ->type('POST');

     	$transport->read($read)
        		  ->parameterMap('function(data) {
        		  				      return kendo.stringify(data);
        		  				  }');

		
		/* Create the Datastream */
		$schema = new \Kendo\Data\DataSourceSchema();
		$schema->data('data')
		       ->errors('errors')
		       ->groups('groups')
		       ->model($this->map_table_model())
		       ->total('total');

		$dataSource = new \Kendo\Data\DataSource();
		$dataSource->transport($transport)
		           ->pageSize(10)
		           ->serverPaging(true)
		           ->serverSorting(true)
		           ->serverGrouping(true)
		           ->schema($schema);

		return $dataSource;
	}

	private function map_table_read()
	{

	}

	private function map_table_model()
	{
		$model = new \Kendo\Data\DataSourceSchemaModel();

		$xField = new \Kendo\Data\DataSourceSchemaModelField('xCoord');
		$xField->type('integer');

		$yField = new \Kendo\Data\DataSourceSchemaModelField('yCoord');
		$yField->type('integer');

		$lordField = new \Kendo\Data\DataSourceSchemaModelField('lordName');
		$lordField->type('string');

		$cityField = new \Kendo\Data\DataSourceSchemaModelField('cityName');
		$cityField->type('string');

		$allianceField = new \Kendo\Data\DataSourceSchemaModelField('allianceName');
		$allianceField->type('string');

		$statusField = new \Kendo\Data\DataSourceSchemaModelField('status');
		$statusField->type('string');

		$flagField = new \Kendo\Data\DataSourceSchemaModelField('flag');
		$flagField->type('string');

		$honorField = new \Kendo\Data\DataSourceSchemaModelField('honor');
		$honorField->type('integer');

		$prestigeField = new \Kendo\Data\DataSourceSchemaModelField('prestige');
		$prestigeField->type('integer');

		$model->addField($xField)
			  ->addField($yField)
			  ->addField($lordField)
			  ->addField($cityField)
			  ->addField($allianceField)
			  ->addField($statusField)
			  ->addField($flagField)
			  ->addField($honorField)
			  ->addField($prestigeField);

		return $model;
	}

	private function map_table_grid()
	{
		$grid = new \Kendo\UI\Grid('grid');

		$xCoord = new \Kendo\UI\GridColumn();
		$xCoord->field('x')
		       ->title('xxx')
		       ->width(40);

		$yCoord = new \Kendo\UI\GridColumn();
		$yCoord->field('y')
		       ->title('yyy')
		       ->width(40);

		$lordName = new \Kendo\UI\GridColumn();
		$lordName->field('lord_name')
		         ->title('Lord Name')
		         ->width(90);

		$cityName = new \Kendo\UI\GridColumn();
		$cityName->field('city_name')
		         ->title('City')
		         ->width(90);

		$allainceName = new \Kendo\UI\GridColumn();
		$allainceName->field('alliance')
		             ->title('Allaince')
		             ->width(90);

		$cityStatus = new \Kendo\UI\GridColumn();
		$cityStatus->field('status')
		           ->title('Status')
		           ->width(60);

		$flagName = new \Kendo\UI\GridColumn();
		$flagName->field('flag')
		           ->title('Flag')
		           ->width(50);

		$playerHonor = new \Kendo\UI\GridColumn();
		$playerHonor->field('honor')
		            ->title('Horor')
		            ->width(70);

		$playerPrestige = new \Kendo\UI\GridColumn();
		$playerPrestige->field('prestige')
		               ->title('Prestige')
		               ->width(70);

		/* The long line of repeated code >.> */
		$pageable = new Kendo\UI\GridPageable();
		$pageable->refresh(true)
		         ->pageSizes(true)
		         ->buttonCount(5);

		$grid->addColumn($xCoord, $yCoord, $lordName, $cityName, $allainceName, $cityStatus, $flagName, $playerHonor, $playerPrestige)
     		 ->dataSource($this->map_table_data())     
     		 ->sortable(true)
     		 ->groupable(true)
     		 ->pageable($pageable)
     		 ->attr('style', 'height:380px');

     	return $grid;
	}
}

