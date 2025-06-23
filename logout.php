<?php
require_once 'config.php';

// Уничтожение сессии
session_destroy();

// Перенаправление на главную страницу
header("Location: index.html");
exit();
?>