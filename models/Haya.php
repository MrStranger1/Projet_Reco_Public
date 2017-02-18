<?php 
/**
* 
*/
class Haya extends AppModel
{
	public static $_table = 'Events';

	public function getEventsNow()
	{
		return $this->getTable('events')->find(
			array('conditions'=>array(
				'date_event='=> date('Y-m-d')
				)
			)
		);
	}
	public function getEventsAfter()
	{
		return $this->getTable('events')->query('SELECT * FROM events WHERE date_event > NOW()');
	}

	public function getPieces()
	{
		return $this->getTable('pieces')->find('all');
	}
}
?>