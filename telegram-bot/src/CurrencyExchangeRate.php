<?php

class CurrencyExchangeRate
{
	public static $message =  'Выберите наименование валюты';
	public static $buttons = [
		[
			['text' => 'Рубль ', 'callback_data' => 'ruble' ],
			['text' => 'Евро', 'callback_data' => 'euro' ],
			['text' => 'Доллар', 'callback_data' => 'dollar' ]
		]
	];
  
	public static function selectingAnOption($select) 
	{

		$currency_data = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=" . date("d/m/Y"));
	      
		if($select === 'ruble') {
			$currency_unit =  'рубля';
			$currency_value = 1;
		}
	      
		if($select === 'euro') {
			$currency_unit =  'евро';
	
			$xml =  $currency_data->xpath("//Valute[@ID='R01239']");
			$valute_euro = strval($xml[0]->Value);
			$currency_value = isset($valute_euro) ? $valute_euro : 100;
		}  
	      
		if($select === 'dollar') {
			$currency_unit =  'доллара';
	
			$xml =  $currency_data->xpath("//Valute[@ID='R01235']");
			$valute_usd = strval($xml[0]->Value);
			$currency_value = isset($valute_usd) ? $valute_usd : 100;
		}      
	      
		$message = 'Курс ' . $currency_unit . ' 1 к ' . $currency_value;
	            
		return $message;
	}
}