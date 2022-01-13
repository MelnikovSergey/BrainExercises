<?php

class SmartKDMBot
{
	public $params, $callfunc, $weatherState, $telegramRequest;

	public function __construct($params) 
	{
		$this->params = $params;
		$this->telegramRequest = json_decode(file_get_contents("php://input"));
		$this->request_incoming();
      
		$this->callfunc = 'false';
		$this->weatherState = 'false';
	}
  
  # Логируем
	private function logs($filelog_name, $message)
	{
		$fd = fopen(__DIR__ . "/logs/" . $filelog_name, "a");
		fwrite($fd, date("Ymd-G:i:s") . " ------------------ \n\n" . $message . "\n\n");
		fclose($fd);
	}
}
