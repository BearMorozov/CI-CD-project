<?php
// Конфигурация базы данных
define('DB_HOST', 'mysql.web-prj.ru');
define('DB_USER', 'morecats'); // Ваш логин
define('DB_PASS', 'Tq87764!'); // Ваш пароль
define('DB_NAME', 'morecats'); // Имя базы данных (обычно совпадает с логином)

// Настройки сессии
session_start();

// Подключение к базе данных
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Настройки для отправки почты (если потребуется)
define('SMTP_HOST', 'smtp.web-prj.ru');
define('SMTP_USER', 'morecats@web-prj.ru');
define('SMTP_PASS', 'Tq87764!');
define('SMTP_PORT', 587);
define('SMTP_FROM', 'morecats@web-prj.ru');
?>