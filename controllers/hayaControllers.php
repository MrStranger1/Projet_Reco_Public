<?php 
class hayaControllers extends AppControllers{
		
	protected $template = "haya";
	public function accueil()
	{
		$eventsNow = $this->Haya->getEventsNow();
		$eventsAfter = $this->Haya->getEventsAfter();
		$this->set(compact('eventsNow', 'eventsAfter'));
	}
	public function moi()
	{
		
	}

	public function alarms()
	{
		
	}

	public function pieces()
	{
		$pieces = $this->Haya->getPieces();
		$this->set(compact('pieces'));
	}

	public function params()
	{
		
	}
}
?>