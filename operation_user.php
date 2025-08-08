<?php
header('Content-Type: application/json');
$db = new mysqli('localhost', 'root', '', 'jeasy_sample');


if ($db->connect_error) {
    die("اتصال به پایگاه داده ناموفق بود: " . $db->connect_error);
}

$db->set_charset("utf8");

echo $_GET['id'];

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
}
if(!isset($_GET['remove'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    echo $first_name . " " .$last_name." ".$age." " . $email. " ". $phone;

}

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
    mysqli_query($db,$sql);
    $response = [
        'success' => true,
        'message' => 'عملیات کاربر موفقیت آمیز بود',
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'خطا در عملیات کاربر' . $e->getMessage()
    ];
}


ob_clean();

echo json_encode($response);

$db->close();
?>