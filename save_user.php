<?php
// تنظیمات اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "6842@Ali";
$dbname = "jeasy_sample";

// ایجاد اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("اتصال به پایگاه داده ناموفق بود: " . $conn->connect_error);
}

// تنظیم کدگذاری برای پشتیبانی از فارسی
$conn->set_charset("utf8");

echo $_GET['id'];

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
}
if(!isset($_GET['remove'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] ?? null; // استفاده از عملگر null coalescing برای فیلدهای اختیاری

    echo $first_name . " " .$last_name." ".$age." " . $email. " ". $phone;

}


// اعتبارسنجی داده‌ها (امنیتی)
//$name = htmlspecialchars(strip_tags($name));
//$email = filter_var($email, FILTER_SANITIZE_EMAIL);
//$phone = htmlspecialchars(strip_tags($phone));
//$message = htmlspecialchars(strip_tags($message));

if($id && !isset($_GET['remove'])){
$sql =  "UPDATE `user_inf` SET `first_name`='$first_name',`last_name`='$last_name',`age`='$age',`phone`='$phone',`email`='$email' WHERE `id`=$id " ;
}
elseif($id && isset($_GET['remove'])){
    $sql = "DELETE FROM `user_inf` WHERE `id`=$id";
}
else{
$sql= "INSERT INTO `user_inf` (`id` , `first_name`, `last_name`, `age`, `phone`, `email`) VALUES (NULL , '$first_name' , '$last_name' , '$age' , '$phone' , '$email') " ;
}


try {
    mysqli_query($conn,$sql);
    
    $response = [
        'success' => true,
        'message' => 'کاربر با موفقیت حذف شد!',
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'خطا در حذف کاربر: ' . $e->getMessage()
    ];
}
ob_clean();
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>