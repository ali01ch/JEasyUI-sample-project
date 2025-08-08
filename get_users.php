<?php
header('Content-Type: application/json; charset=utf-8');

$db = new mysqli('localhost', 'root', '', 'jeasy_sample');

if ($db->connect_error) {
    die("اتصال به پایگاه داده ناموفق بود: " . $db->connect_error);
}

$db->set_charset('utf8');

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$rows = isset($_POST['rows']) ? (int)$_POST['rows'] : 10;
$sort = isset($_POST['sort']) ? $_POST['sort'] : 'id';
$order = isset($_POST['order']) ? $_POST['order'] : 'asc';

$offset = ($page - 1) * $rows;

$sql = "SELECT * FROM user_inf ORDER BY $sort $order LIMIT $offset, $rows";
$result = $db->query($sql);

$total_result = $db->query("SELECT COUNT(*) AS total FROM user_inf");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];

$data = [
    'total' => $total,
    'rows' => []
];

while ($row = $result->fetch_assoc()) {
    $data['rows'][] = $row;
}

$db->close();

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>