<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/clients.php');
require_once(__DIR__ . '/../src/leads.php');
require_once(__DIR__ . '/../src/sum.php');
session_start(); // Начинаем сессию

// Получаем параметры из URL
$dateFrom = isset($_GET['date_from']) ? strtotime($_GET['date_from']) : null;
$dateTo = isset($_GET['date_to']) ? strtotime($_GET['date_to']) : null;

if (isset($_GET['page'])) {
//	echo "<pre>";
//	var_dump($_GET['page']);
//	echo "</pre>";
//	return;
	$selectedPage = $_GET['page'];
	header("Location: $selectedPage");
	exit;
}

//http://amocrm/index.php?date_from=01-11-2024&date_to=05-11-2024

//Получаем список клиентов
$clients = getClients();

// Получаем информацию о клиентах
list($results, $errors, $client_init) = fetchClientInfo($clients);

//echo "<pre>";
//var_dump($_SESSION['clients_api_keys']);
//echo "</pre>";
//return;

// Получаем сделки
//list($leads, $errorsLeads) = getLeads($client_init, $dateFrom, $dateTo);
//
////получаем суммы
//list($totalSumClient, $totalSum) = getLeadsTotalSum($leads);


include '../templates/header.php'
?>

<label for="page">Выберите страницу:</label>
<select id="page" onchange="location.href='page.php?page=' + this.value">
	<option value="">Выберите клиента</option>
	<?php foreach ($client_init as $clientName => $result): ?>
		<option value="<?php echo htmlspecialchars($clientName); ?>">
			<?php echo htmlspecialchars($clientName); ?>
		</option>
	<?php endforeach; ?>
</select>

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

<!--<table border="1" cellpadding="5" cellspacing="0">-->
<!--	<thead>-->
<!--	<tr>-->
<!--		<th>Название клиента</th>-->
<!--		<th>Сумма сделок</th>-->
<!--		<th>За период</th>-->
<!--	</tr>-->
<!--	</thead>-->
<!--	<tbody>-->
<!--	--><?php //foreach ($totalSumClient as $clientName => $sum): ?>
<!--		<tr>-->
<!--			<td>--><?php //= htmlspecialchars($clientName) ?><!--</td>-->
<!--			<td>--><?php //= htmlspecialchars($sum) ?><!--</td>-->
<!--			<td>-->
<!--				--><?php
//				// Проверяем, заданы ли параметры date_from и date_to
//				if (isset($dateTo)) {
//					echo htmlspecialchars(date('d-m-Y', $dateTo));
//				} else {
//					echo "за все время";
//				}
//				?>
<!--			</td>-->
<!--		</tr>-->
<!--	--><?php //endforeach; ?>
<!--	</tbody>-->
<!--	<tfoot>-->
<!--	<tr>-->
<!--		<th>Итого по всем клиентам</th>-->
<!--		<th>-->
<!--			--><?php
//			// Выводим общую сумму по всем клиентам
//			echo htmlspecialchars($totalSum);
//			?>
<!--		</th>-->
<!--	</tr>-->
<!--	</tfoot>-->
<!--</table>-->
<!---->
<?php //if (!empty($errorsLeads)): ?>
<!--	<h3>Ошибки сделок:</h3>-->
<!--	--><?php //foreach ($errorsLeads as $clientName => $errorMessage): ?>
<!--		<div class="error">-->
<!--			Ошибка сделки --><?php //= htmlspecialchars($clientName) ?><!--: --><?php //= htmlspecialchars($errorMessage) ?>
<!--		</div>-->
<!--	--><?php //endforeach; ?>
<?php //endif; ?>

<?php
include '../templates/footer.php';
?>
