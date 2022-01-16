<?php

class Weather
{
	public static $message = 'Введите наименование города';

	public $city;
	
	public static function getTheWeatherInTheCity($city) {

		$api_key = '<ТОКЕН>';
		$api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $api_key;
		$weather_data = json_decode(file_get_contents($api_url), true);

		if($weather_data->main->temp) {
			$temperature = $weather_data->main->temp;
			$temperature_in_celcius = round($temperature - 273.15);
			$temperature_current_weather = $weather_data->weather[0]->main;
			$temperature_current_weather_description = $weather_data->weather[0]->description;

			$message = 'Погода в городе ' . $city . ' хорошая. Температура ' . $temperature_in_celcius . ' градусов Цельсия.';
		} else {
	  		$message = 'Извините, но мне ничего не известно о данном населенном пункте';
		}

		return $message;
	}
}
