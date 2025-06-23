<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    // Валидация
    if ($password !== $confirm_password) {
        die("Пароли не совпадают");
    }

    // Проверка существующего пользователя
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Пользователь с таким email уже существует");
    }

    // Хеширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Создание пользователя
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password, $user_type])) {
        header("Location: login.html?registration=success");
        exit();
    } else {
        die("Ошибка при регистрации");
    }
}
?>