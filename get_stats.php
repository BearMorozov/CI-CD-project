<?php
require_once 'config.php';

// Проверка авторизации и прав администратора
if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещен");
}

if ($_SESSION['user_type'] !== 'admin') {
    die("Недостаточно прав");
}

// Получение общей статистики
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_visits = $pdo->query("SELECT SUM(visit_count) FROM users")->fetchColumn();
$active_users = $pdo->query("SELECT COUNT(*) FROM users WHERE last_login > DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();

// Вывод статистики
echo '<div class="stats">';
echo '<p><strong>Всего пользователей:</strong> ' . $total_users . '</p>';
echo '<p><strong>Всего посещений:</strong> ' . $total_visits . '</p>';
echo '<p><strong>Активных пользователей (за 30 дней):</strong> ' . $active_users . '</p>';
echo '</div>';

// Получение статистики по дням
$stmt = $pdo->query("SELECT DATE(last_login) as day, COUNT(*) as count FROM users WHERE last_login IS NOT NULL GROUP BY DATE(last_login) ORDER BY day DESC LIMIT 7");
$daily_stats = $stmt->fetchAll();

if (!empty($daily_stats)) {
    echo '<h3>Последние посещения по дням</h3>';
    echo '<table class="profile-list">';
    echo '<tr><th>Дата</th><th>Посещений</th></tr>';
    foreach ($daily_stats as $stat) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($stat['day']) . '</td>';
        echo '<td>' . htmlspecialchars($stat['count']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>