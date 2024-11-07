<?php
include '../templates/header.php';


$page = $_GET['page'] ?? null; // Используем оператор ?? для установки значения по умолчанию, если параметр не передан

// Проверяем, есть ли параметр и выводим его
if ($page) {
	echo "Вы выбрали страницу: " . htmlspecialchars($page);
} else {
	echo "Параметр 'page' не был передан.";
}


require_once __DIR__ . '/../templates/header.php';
?>
<h3>Клиент: <?= htmlspecialchars($page) ?></h3>

<?php
include '../templates/footer.php';
?>

