<!DOCTYPE html>
<html>
<head>
    <title>Форма заказа</title>
</head>
<body>
    <h1>Форма заказа</h1>
    <form action="process.php" method="POST">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone">Номер телефона:</label>
        <input type="text" id="phone" name="phone" required pattern="\+7\(\d{3}\)\d{3}-\d{2}-\d{2}" title="Введите номер телефона в формате +7(XXX)XXX-XX-XX"><br><br>

        <input type="hidden" name="hidden-field" value="test">

        <input type="submit" value="Отправить">
    </form>
</body>
</html>