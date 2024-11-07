<?php

function getLeads($param, $timestampFrom = null, $timestampTo = null)
{
	set_time_limit(120);

	$crm_user_id = []; // int[] | фильтр по id ответственного
	$status = [142]; // int[] | фильтр по id статуса
	$id = []; // int[] | фильтр по id
	$ifmodif = ""; // string | фильтр по дате изменения. timestamp или строка в формате 'D, j M Y H:i:s'
	$count = 2000; // int | Количество запрашиваемых элементов
	$offset = 0; // int | смещение, относительно которого нужно вернуть элементы

	$errorsLeads = [];

	foreach ($param as $clientName => $result) {

		$leads[$clientName] = [];

		while (true) {

			try {
				//выполняем запрос список сделок с параметрами
				$currentLeads = $result->lead->getAll($crm_user_id, $status, $id, $ifmodif, $count, $offset);

				$offset++;

				if ($timestampTo !== null) {

					foreach ($currentLeads['result'] as $item) {

						if ((int)date('Ymd', $timestampTo) == (int)date('Ymd', $item['date_close'])) {
							// Добавляем текущий результат в массив клиента
							$leads[$clientName][] = $item;
						}
					}
				} else {
					foreach ($currentLeads['result'] as $item) {
						// Добавляем текущий результат в массив клиента
						$leads[$clientName][] = $item;
					}
				}

				if ($currentLeads['count'] < $count) {
					break;
				}

				sleep(1);
			} catch (Exception $e) {
				// Обработка ошибки, если запрос не удался
				$errorsLeads[$clientName] = 'Ошибка: ' . $e->getMessage(); // Сохраняем сообщение об ошибке
				break;
			}

		}

		return [$leads, $errorsLeads]; // Возвращаем результаты
	}
}

