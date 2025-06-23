<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Поиск пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Успешная авторизация
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        
        // Обновление счетчика посещений
        $stmt = $pdo->prepare("UPDATE users SET last_login = NOW(), visit_count = visit_count + 1 WHERE id = ?");
        $stmt->execute([$user['id']]);

        // Перенаправление в зависимости от типа пользователя
        if ($user['user_type'] === 'admin') {
            header("Location: admin.html");
        } else {
            header("Location: author.html");
        }
        exit();
    } else {
        header("Location: login.html?error=invalid_credentials");
        exit();
    }
}
?>