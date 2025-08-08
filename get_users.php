<?php
header('Content-Type: application/json; charset=utf-8');

// اتصال به پایگاه داده
$db = new mysqli('localhost', 'root', '6842@Ali', 'jeasy_sample');

// بررسی اتصال
if ($db->connect_error) {
    die(json_encode([
        'error' => 'Database connection failed: ' . $db->connect_error
    ], JSON_UNESCAPED_UNICODE));
}

// تنظیم کدگذاری برای پشتیبانی از فارسی
$db->set_charset('utf8');

// دریافت پارامترهای DataGrid
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$rows = isset($_GET['rows']) ? (int)$_GET['rows'] : 10;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// محاسبه محدوده داده‌های مورد نیاز
$offset = ($page - 1) * $rows;

// کوئری اصلی برای دریافت داده‌ها
$sql = "SELECT * FROM user_inf ORDER BY $sort $order LIMIT $offset, $rows";
$result = $db->query($sql);

// کوئری برای محاسبه تعداد کل رکوردها
$total_result = $db->query("SELECT COUNT(*) AS total FROM user_inf");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];

// آماده‌سازی داده‌ها برای خروجی
$data = [
    'total' => $total,
    'rows' => []
];

while ($row = $result->fetch_assoc()) {
    // تبدیل هر رکورد به فرمت مورد نیاز
    $data['rows'][] = $row;
}

// بستن اتصال به پایگاه داده
$db->close();

// برگرداندن داده به صورت JSON
echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>