<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/src/clients.php');
require_once(__DIR__ . '/src/leads.php');
require_once(__DIR__ . '/src/sum.php');

// Получаем параметры из URL
$dateFrom = isset($_GET['date_from']) ? strtotime($_GET['date_from']) : null;
$dateTo = isset($_GET['date_to']) ? strtotime($_GET['date_to']) : null;

//http://amocrm/index.php?date_from=01-11-2024&date_to=05-11-2024

 //Получаем список клиентов
$clients = getClients();

// Получаем информацию о клиентах
list($results, $errors, $client_init) = fetchClientInfo($clients);

// Получаем сделки
list($leads, $errorsLeads) = getLeads($client_init, $dateFrom, $dateTo);

//получаем суммы
list($totalSumClient, $totalSum) = getLeadsTotalSum($leads);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .client-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .error {
            color: red;
        }
	</style>
</head>
<body>
<h2>amoCRM</h2>
<?php foreach ($results as $clientName => $result): ?>
	<div class="client-info">
		<h3>Вход для клиента: <?= htmlspecialchars($clientName) ?></h3>
		<pre><?= htmlspecialchars(print_r($result, true)) ?></pre>
	</div>
<?php endforeach; ?>

<?php if (!empty($errors)): ?>
	<div class="client-info">
		<h3>Ошибки входа для клиента:</h3>
		<?php foreach ($errors as $clientName => $errorMessage): ?>
			<div class="error">
				Ошибка для клиента <?= htmlspecialchars($clientName) ?>: <?= htmlspecialchars($errorMessage) ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0">
	<thead>
	<tr>
		<th>Название клиента</th>
		<th>Сумма сделок</th>
		<th>За период</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($totalSumClient as $clientName => $sum): ?>
		<tr>
			<td><?= htmlspecialchars($clientName) ?></td>
			<td><?= htmlspecialchars($sum) ?></td>
			<td>
				<?php
				// Проверяем, заданы ли параметры date_from и date_to
				if (isset($dateTo)) {
					echo htmlspecialchars(date('d-m-Y', $dateTo));
				} else {
					echo "за все время";
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
	<tr>
		<th>Итого по всем клиентам</th>
		<th>
			<?php
			// Выводим общую сумму по всем клиентам
			echo htmlspecialchars($totalSum);
			?>
		</th>
	</tr>
	</tfoot>
</table>

<?php if (!empty($errorsLeads)): ?>
	<h3>Ошибки сделок:</h3>
	<?php foreach ($errorsLeads as $clientName => $errorMessage): ?>
		<div class="error">
			Ошибка сделки <?= htmlspecialchars($clientName) ?>: <?= htmlspecialchars($errorMessage) ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
