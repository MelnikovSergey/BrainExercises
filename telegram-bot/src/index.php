<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require __DIR__ . "/setup/config.php";

require __DIR__ . "/Weather.php";
require __DIR__ . "/CurrencyExchangeRate.php";
require __DIR__ . "/SmartKDMBot.php";

$params = new stdClass();
$params->APIKey = '<ТОКЕН>';

# Источник новостей для пользователей
$params->url = 'https://yandex.ru/news/?utm_source=main_stripe_big';

# Логи для админа
$params->adminIDChat = ['1751979873'];

# Логи для менеджеров
$params->managersIDChat = ['1751979873', '1751979873'];

$pp = new SmartKDMBot($params);
