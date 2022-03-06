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
  

	public function request_incoming() 
	{
		# Обрабатываем кнопку Погода
		if ($this->telegramRequest->callback_query->data === 'weather') {
			$to =  $this->telegramRequest->callback_query->message->chat->id;
			$this->telegramSend($to, Weather::$message);
		} 
      
		# Обрабатываем кнопку Погода->Введите наименование города
		if (isset($this->telegramRequest->message->text) and file_exists(__DIR__ . '/logs/'. $this->telegramRequest->message->chat->id . '.txt')) {
		    $this->callfunc = 'true';
		  	
		    $to = $this->telegramRequest->message->chat->id;
		    $this->telegramSend($to, Weather::getTheWeatherInTheCity($this->telegramRequest->message->text)); 
		}
          
		# Обрабатываем кнопку "Курс валюты"
		if ($this->telegramRequest->callback_query->data === 'money') {
			$to =  $this->telegramRequest->callback_query->message->chat->id;
			$this->telegramSend($to, CurrencyExchangeRate::$message, CurrencyExchangeRate::$buttons);
		}

		# Обрабатываем кнопку "Курс валюты->Рубль"
		if ($this->telegramRequest->callback_query->data === 'ruble') {
			$this->callfunc = 'true';
            
			$to =  $this->telegramRequest->callback_query->message->chat->id;
			$this->telegramSend($to, CurrencyExchangeRate::selectingAnOption('ruble'));
		}
      
		# Обрабатываем кнопку "Курс валюты->Евро"
		if ($this->telegramRequest->callback_query->data === 'euro') {
			$this->callfunc = 'true';
            
			$to =  $this->telegramRequest->callback_query->message->chat->id;
			$this->telegramSend($to, CurrencyExchangeRate::selectingAnOption('euro'));
		}

		# Обрабатываем кнопку "Курс валюты->Доллар"
		if ($this->telegramRequest->callback_query->data === 'dollar') {
			$this->callfunc = 'true';
            
			$to =  $this->telegramRequest->callback_query->message->chat->id;
			$this->telegramSend($to, CurrencyExchangeRate::selectingAnOption('dollar'));
		}        
  
		# Если пользователь набрал /start
		if ($this->telegramRequest->message->text === '/start') {
			$this->callfunc = 'true';
              
			$this->telegramSend(
				$this->telegramRequest->message->chat->id, 	
				"Добрый день! Вас приветствует бот!.\n Good afternoon! The bot welcomes you!"
			);
		} 
 
		elseif ($this->telegramRequest->message->text === '/help') {
			// $this->callfunc = 'true';
              
			$this->telegramSend(
				$this->telegramRequest->message->chat->id, 	
				"Одну секунду! Сейчас я вам выведу список опций!.\n One second, please! Now I will show the menu on the screen!"
			);

		} elseif (isset($this->telegramRequest->message->text)) {
			$this->telegramSend(
				$this->telegramRequest->message->chat->id, 	
				"Извините, команда не распознана.\n Sorry, the command is not recognized"
			);
		}
  }
 
   
	# Выбор опций
	private function selectingAnOption() 
	{
		$this->callfunc = 'false';

		$message = "Выберите информацию, которую хотите получить";
		
		# Шлём сообщение администратору
		$to = $this->params->adminIDChat;
      
		$buttons = [
			[
				['text' => 'Погода ', 'callback_data' => 'weather' ],
				['text' => 'Курс валюты', 'callback_data' => 'money' ],
				['text' => 'Новости', 'url' => $this->params->url ]
			]
		];
		
		$this->telegramSend($to, $message, $buttons);
      
		# Для отладки
		$this->logs("myRequest.txt", print_r([$to, $message], TRUE));
	}

 
	# Отправляем
	public function telegramSend($telegramchatId, $msg, $buttons = [], $apiMethod = 'sendMessage') 
	{
		$this->logs("myRequest.txt", print_r([$this->telegramRequest->message->chat->id, $msg], TRUE));

		$url = 'https://api.telegram.org/bot' . $this->params->APIKey . '/' . $apiMethod;
      
		$list = [];
		
		if(!is_array($telegramchatId)) { 
			$list[] = $telegramchatId; 
		} else { 
			$list = $telegramchatId; 
		}
		
		foreach ($list as $chatId) {
			$data = [
				'chat_id' => $chatId,
				'text' => $msg,
				'parse_mode' => 'html',
				'disable_web_page_preview' => 1,
				'reply_markup' => json_encode([
				'inline_keyboard' => $buttons
				]),
				'message_id' => $editMessageID
			];
		
			$options = ['http' => 
				[
					'method' => 'POST', 
					'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
					'content' => http_build_query($data),
				]
			];

			$context = stream_context_create($options);
			$response = file_get_contents($url, false, $context);
          
			$this->logs('sendMessageToTelegramServer.txt', print_r($data, true));
			$this->logs('telegramResponseToOnMyRequest.txt', $responce);
		}

		if($this->callfunc == 'true') {
			// default state mashine
			$this->callfunc = 'false';

			// interval
			sleep(1);

			// call func
			$this->selectingAnOption();
		}
        
        if(file_exists(__DIR__ . '/logs/'. $this->telegramRequest->message->chat->id . '.txt')) {
          unlink(__DIR__ . '/logs/' . $this->telegramRequest->message->chat->id . '.txt');
        }
      
		if($msg == 'Введите наименование города') {
			$msg == '';
			$this->logs($telegramchatId . '.txt', print_r($data, true));
		}
       
		exit('["message" : "Успешно отправлено"]');
	}


	# Логируем
	private function logs($filelog_name, $message)
	{
		$fd = fopen(__DIR__ . "/logs/" . $filelog_name, "a");
		fwrite($fd, date("Ymd-G:i:s") . " ------------------ \n\n" . $message . "\n\n");
		fclose($fd);
	}
}