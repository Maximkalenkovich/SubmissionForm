<?php
session_start();

// Проверяем, была ли форма уже отправлена для данного пользователя
if (isset($_SESSION['form_submitted'])) {
    echo "Форма уже была отправлена!";
    exit;
}

// Получение данных из формы
$name = $_POST['name'];
$phone = $_POST['phone'];
$hiddenField = $_POST['hidden-field'];

// Проверка корректности номера телефона
if (preg_match('/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phone)) {
    echo "Номер телефона корректный!";
} else {
    echo "Некорректный номер телефона!";
    exit;
}

// Формирование данных для отправки на сторонний сервис
$data = array(
    'stream_code' => 'iu244',
    'client' => array(
        'name' => $name,
        'phone' => $phone
    ),
    'sub1' => $hiddenField
);

// Преобразование данных в формат JSON
$jsonData = json_encode($data);

// URL стороннего сервиса, на который нужно отправить запрос
$url = 'https://order.drcash.sh/v1/order';

// Настройка заголовков запроса
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n" .
                     "Authorization: Bearer NWJLZGEWOWETNTGZMS00MZK4LWFIZJUTNJVMOTG0NJQXOTI3", 
        'method'  => 'POST',
        'content' => $jsonData
    )
);

// Создание контекста запроса
$context  = stream_context_create($options);

// Отправка запроса на сторонний сервис
$result = file_get_contents($url, false, $context);

if ($result) {
    // Ответ получен успешно
    $_SESSION['form_submitted'] = true;
    header("Location: thank_you.php"); // Перенаправление на страницу "Спасибо за заказ"
    exit;
} else {
    // Произошла ошибка при отправке запроса
    header("Location: error.php"); // Перенаправление на страницу "Ошибка"
    exit;
}
?>