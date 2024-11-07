<?php
function getClients()
{
	return [
		[
			'id' => 1,
			'name' => 'yandex',
			'api' => '23bc075b710da43f0ffb50ff9e889'
		],
		[
			'id' => 2,
			'name' => 'introvert',
			'api' => '23bc075b710da43f0ffb50ff9e889aed',
		],
	];
}

function fetchClientInfo($clients)
{
	$results = []; // Массив для хранения результатов
	$errors = []; // Массив для хранения ошибок
	$client_init = [];

	if (empty($_SESSION['clients_api_keys'])) {
		// Если массив пуст, инициализируем его
		$_SESSION['clients_api_keys'] = [];
	}

	foreach ($clients as $client) {
		$API_KEY = $client['api'];
		$API_URL = 'https://api.s1.yadrocrm.ru/tmp';

		Introvert\Configuration::getDefaultConfiguration()
			->setApiKey('key', $API_KEY)
			->setHost($API_URL);

		$api = new Introvert\ApiClient();

		try {
			$result = $api->account->statuses();

			// Добавляем ошибку
			if ($result['count'] == 0) {
				$errors[$client['name']] = '[count] равен нулю.';
			} else {
				// Сохраняем результат по имени клиента
				$client_init[$client['name']] = $api;

				// Сохраняем в сессии по имени клиента
				$_SESSION['clients_api_keys'][$client['name']] = $client['api'];

				// Сохраняем результат по имени клиента
				$results[$client['name']] = $result['message'];
			}
		} catch (Exception $e) {
			// Сохраняем ошибку по имени клиента
			$errors[$client['name']] = $e->getMessage();
		}
	}
	// Возвращаем результаты и ошибки
	return [$results, $errors , $client_init];
}
