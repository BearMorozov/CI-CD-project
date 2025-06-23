<?php
require_once 'config.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещен");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $editor_email = "editor@catsite.com"; // Заменить на реальный email

    // Сохранение в базу данных
    $stmt = $pdo->prepare("INSERT INTO content_submissions (user_id, title, content, submitted_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $title, $content]);

    // В реальном приложении здесь бы отправлялось письмо
    // mail($editor_email, "Новый материал на проверку: $title", $content);
    
    echo "Материал успешно отправлен на проверку редактору. Мы свяжемся с вами по email.";
    exit();
}

echo "Ошибка при отправке материала";
?>