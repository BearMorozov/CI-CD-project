<?php
require_once 'config.php';

// Проверка авторизации и прав администратора
if (!isset($_SESSION['user_id']) {
    die("Доступ запрещен");
}

if ($_SESSION['user_type'] !== 'admin') {
    die("Недостаточно прав");
}

// Получение списка пользователей
$stmt = $pdo->query("SELECT id, username, email, user_type, last_login, visit_count FROM users ORDER BY id");
$users = $stmt->fetchAll();

// Вывод данных в формате HTML
echo '<table class="profile-list">';
echo '<tr><th>ID</th><th>Имя</th><th>Email</th><th>Тип</th><th>Последний вход</th><th>Посещений</th></tr>';
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($user['id']) . '</td>';
    echo '<td>' . htmlspecialchars($user['username']) . '</td>';
    echo '<td>' . htmlspecialchars($user['email']) . '</td>';
    echo '<td>' . htmlspecialchars($user['user_type']) . '</td>';
    echo '<td>' . htmlspecialchars($user['last_login']) . '</td>';
    echo '<td>' . htmlspecialchars($user['visit_count']) . '</td>';
    echo '</tr>';
}
echo '</table>';
?>