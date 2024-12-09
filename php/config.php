<?php
$host = 'localhost'; // или IP-адрес вашего сервера PostgreSQL
$port = '5432'; // порт PostgreSQL
$dbname = 'postgres'; // имя вашей базы данных
$user = 'postgres'; // ваше имя пользователя PostgreSQL
$password = '3683'; // ваш пароль PostgreSQL

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Подключение к базе данных успешно!"; /* */
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

/*



Fatal error
: Uncaught PDOException: SQLSTATE[42P01]: Undefined table: 7 ОШИБКА: отношение "actions" 
не существует LINE 1: SELECT * FROM actions ^ in Z:\OSPanel\home\example.local\index.php:79 
Stack trace: #0 Z:\OSPanel\home\example.local\index.php(79): PDO->query('SELECT * FROM a...') #1
{main} thrown in

Z:\OSPanel\home\example.local\index.php
on line
79



*/
?>
