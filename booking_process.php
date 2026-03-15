<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$tour_id = $_POST['tour_id'];
$customer_name = $_POST['customer_name'];
$customer_phone = $_POST['customer_phone'];
$customer_email = $_SESSION['user']['email'];
$total_price = $_POST['total_price'];

try {
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, tour_id, customer_name, customer_phone, customer_email, total_price, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$user_id, $tour_id, $customer_name, $customer_phone, $customer_email, $total_price]);
    header("Location: tour-detail.php?id=$tour_id");
} catch (Exception $e) {
    die("Lỗi hệ thống.");
}